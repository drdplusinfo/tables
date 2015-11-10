<?php
namespace DrdPlus\Tables\Races;

use Granam\Boolean\Tools\ToBoolean;
use Granam\Float\Tools\ToFloat;
use Granam\Integer\Tools\ToInteger;
use Granam\Scalar\Tools\ValueDescriber;

abstract class AbstractTable implements TableInterface
{
    const INTEGER = 'integer';
    const FLOAT = 'float';
    const BOOLEAN = 'boolean';
    const DEFAULT_TYPE = self::INTEGER;

    /** @var array */
    private $values;

    /** @return array */
    public function getValues()
    {
        if (!isset($this->values)) {
            $this->loadData();
        }

        return $this->values;
    }

    /** @return array */
    private function loadData()
    {
        $rawData = $this->fetchDataFromFile($this->getDataFileName());
        $this->values = $this->mapValues($rawData);
    }

    /** @return string */
    abstract protected function getDataFileName();

    private function fetchDataFromFile($dataSourceFile)
    {
        $resource = fopen($dataSourceFile, 'r');
        if (!$resource) {
            throw new Exceptions\CanNotReadFile("File with table data could not be read from $dataSourceFile");
        }
        $data = [];
        do {
            $row = fgetcsv($resource);
            if (count($row) > 0 && $row !== false) { // otherwise skip empty row
                $data[] = $row;
            }
        } while (is_array($row));

        if (!$data) {
            throw new Exceptions\NoDataFetched("No data have been read from $dataSourceFile");
        }

        return $data;
    }

    private function mapValues(array $rawData)
    {
        // TODO vertical header should be columnIndex=>columnName, @see usage in indexData
        $verticalHeader = $this->parseVerticalHeader($rawData);
        $valuesWithoutVerticalHeader = $this->cutOffVerticalHeader($rawData);

        $horizontalHeader = $this->parseHorizontalHeader($valuesWithoutVerticalHeader);
        $valuesWithoutHeader = $this->cutOffHorizontalHeader($valuesWithoutVerticalHeader);

        $formattedValues = $this->formatValues($valuesWithoutHeader);

        $indexed = $this->indexData($formattedValues, $verticalHeader, $horizontalHeader);

        return $indexed;
    }

    private function parseVerticalHeaderNames(array $rawData)
    {
        $verticalHeaderNames = [];
        foreach ($this->getExpectedVerticalHeader() as $expectedColumnIndex => $expectedHeaderValue) {
            $this->checkHeaderValue($rawData, $expectedColumnIndex, $expectedHeaderValue);
            $verticalHeaderNames[$expectedColumnIndex] = $expectedHeaderValue;
        }

        return $verticalHeaderNames;
    }

    /** @return string[] */
    abstract protected function getExpectedVerticalHeader();

    private function checkHeaderValue($rawData, $columnIndex, $expectedHeaderValue)
    {
        if (!isset($rawData[$columnIndex])) {
            throw new Exceptions\DataAreCorrupted(
                'Missing cell with header with column index ' . $columnIndex
            );
        }
        if ($rawData[0][$columnIndex] !== $expectedHeaderValue) {
            throw new Exceptions\DataAreCorrupted(
                "Expected header with name '$expectedHeaderValue' on column index " . $columnIndex
                . ', got ' . ValueDescriber::describe($rawData[$columnIndex])
            );
        }
    }

    private function parseVerticalHeader(array $data)
    {
        $verticalHeaderNamesRow = $this->parseVerticalHeaderNames($data);
        $verticalHeaderValues = []; // vertical header values to data row index
        foreach ($data as $rowIndex => $dataRow) {
            if ($rowIndex === 0) {
                continue; // skipping header names
            }
            $verticalHeaderValuesPart = &$verticalHeaderValues;
            foreach ($verticalHeaderNamesRow as $dataColumnIndex => $headerName) {
                $headerValue = $dataRow[$dataColumnIndex];
                if (!isset($verticalHeaderValuesPart[$headerValue])) {
                    $verticalHeaderValuesPart[$headerValue] = [];
                }
                $verticalHeaderValuesPart = &$verticalHeaderValuesPart[$headerValue];
            }
            $verticalHeaderValuesPart = $rowIndex - 1; // because of gap by skipped first row
        }

        return $verticalHeaderValues;
    }

    private function cutOffVerticalHeader(array $values)
    {
        foreach (array_keys($values) as $rowIndex) {
            foreach (array_keys($this->getExpectedVerticalHeader()) as $columnIndex) {
                unset($values[$rowIndex][$columnIndex]);
            }
            // fixing number-indexes sequence ([1=>foo, 3=>bar] = [0=>foo, 1=>bar])
            $values[$rowIndex] = array_merge($values[$rowIndex]);
        }

        return $values; // pure values without header
    }

    private function parseHorizontalHeader(array $data)
    {
        $horizontalHeaderValues = [];
        $expectedHeaderRow = $this->getNormalizedExpectedHorizontalHeader(); // the very first rows of data
        foreach (array_keys($expectedHeaderRow) as $dataColumnIndex) {
            $expectedHeaderValue = $expectedHeaderRow[$dataColumnIndex]['value'];
            $this->checkHeaderValue($data, $dataColumnIndex, $expectedHeaderValue);
            $horizontalHeaderValues[$expectedHeaderValue] = $dataColumnIndex;
        }

        return $horizontalHeaderValues;
    }

    private function cutOffHorizontalHeader(array $rawData)
    {
        unset($rawData[0]);

        return array_merge($rawData); // fixing row numeric indexes sequence ([1=>foo, 3=>bar] = [0=>foo, 1=>bar])
    }

    private function formatValues(array $data)
    {
        return array_map(
            function (array $row) {
                return array_map(
                    function ($value, $columnIndex) {
                        return $this->parseValue($value, $columnIndex);
                    },
                    $row, array_keys($row)
                );
            },
            $data
        );
    }

    private function getNormalizedExpectedHorizontalHeader()
    {
        $normalized = [];
        $columnIndex = 0;
        foreach ($this->getExpectedHorizontalHeader() as $headerName => $columnScalarType) {
            $normalized[$columnIndex++] = [
                'value' => $headerName,
                'type' => $this->normalizeScalarType($columnScalarType),
            ];
        }

        return $normalized;
    }

    private function normalizeScalarType($scalarType)
    {
        switch (strtolower($scalarType)) {
            case self::BOOLEAN :
                return self::BOOLEAN;
            case self::FLOAT :
                return self::FLOAT;
            case self::INTEGER :
                return self::INTEGER;
            default :
                throw new \LogicException('Unknown scalar type ' . ValueDescriber::describe($scalarType));
        }
    }

    /** @return string[] */
    abstract protected function getExpectedHorizontalHeader();

    private function parseValue($value, $columnIndex)
    {
        $value = trim($value);
        switch ($columnType = $this->getColumnType($columnIndex)) {
            case self::BOOLEAN :
                return ToBoolean::toBoolean($value);
            case self::INTEGER :
                return ToInteger::toInteger($this->normalizeMinus($value));
            case self::FLOAT :
                return ToFloat::toFloat($this->normalizeMinus($value));
            default :
                throw new \LogicException('Unknown scalar type ' . ValueDescriber::describe($columnType));
        }
    }

    private function getColumnType($columnIndex)
    {
        $header = $this->getNormalizedExpectedHorizontalHeader();

        return $header[$columnIndex]['type'];
    }

    private function normalizeMinus($value)
    {
        return str_replace('−' /* ASCII 226 */, '-' /* ASCII 45 */, $value);
    }

    private function indexData(array $values, array $horizontalHeader, array $verticalHeader)
    {
        $indexedRows = $this->indexByHorizontalHeader($values, $horizontalHeader);
        $indexed = $this->indexByVerticalHeader($indexedRows, $verticalHeader);

        return $indexed;
    }

    private function indexByHorizontalHeader(array $toIndex, array $rowKeys)
    {
        $indexed = [];
        foreach ($rowKeys as $keyPart => $keyPartsOrRowIndex) {
            if (is_int($keyPartsOrRowIndex)) { // last string key pointing to row index
                $rowIndex = $keyPartsOrRowIndex;
                $indexed[$keyPart] = $toIndex[$rowIndex];
            } else {
                $indexed[$keyPart] = [];
                $indexed[$keyPart] = $this->indexByHorizontalHeader($toIndex, $keyPartsOrRowIndex);
            }
        }

        return $indexed;
    }

    private function indexByVerticalHeader(array $toIndex, array $columnKeys)
    {
        $indexed = [];
        foreach ($toIndex as $rowKeyOrColumnIndex => $rowOrFinalValue) {
            if (!is_array($rowOrFinalValue)) {
                $columnIndex = $rowKeyOrColumnIndex;
                $finalValue = $rowOrFinalValue;
                $columnKey = array_search($columnIndex, $columnKeys);
                $indexed[$columnKey] = $finalValue;
            } else {
                $indexed[$rowKeyOrColumnIndex] = $this->indexByVerticalHeader($rowOrFinalValue, $columnKeys);
            }
        }

        return $indexed;
    }

    /**
     * @param array $rowIndexes
     * @param string $columnIndex
     *
     * @return int|float|bool
     */
    public function getValue(array $rowIndexes, $columnIndex)
    {
        $row = $this->getRow($rowIndexes);

        $value = $this->getValueInRow($row, $columnIndex);

        return $value;
    }

    /**
     * @param array $rowIndexes
     *
     * @return array|mixed[]
     */
    public function getRow(array $rowIndexes)
    {
        $values = $this->getValues();
        $row = null;
        foreach ($rowIndexes as $rowIndex) {
            if (!isset($values[$rowIndex])) {
                throw new Exceptions\RequiredDataNotFound(
                    'Has not found data by index ' . ValueDescriber::describe($rowIndex)
                );
            }
            $values = &$values[$rowIndex];
            if (!is_array(current($values))) { // flat array found
                $row = $values;
                break;
            }
        }

        return $row;
    }

    private function getValueInRow(array $row, $columnIndex)
    {
        if (!isset($row[$columnIndex])) {
            throw new Exceptions\RequiredDataNotFound(
                'Has not found value in row by index ' . ValueDescriber::describe($columnIndex)
            );
        }

        return $row[$columnIndex];
    }
}
