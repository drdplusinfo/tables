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

    /** @var array */
    private $normalizedExpectedColumnHeader;

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
        $rowsHeader = $this->parseRowsHeader($rawData);
        $valuesWithoutRowsHeader = $this->cutOffRowsHeader($rawData);

        $columnsHeader = $this->parseColumnsHeader($valuesWithoutRowsHeader);
        $valuesWithoutHeader = $this->cutOffColumnsHeader($valuesWithoutRowsHeader);

        $formattedValues = $this->formatValues($valuesWithoutHeader);

        $indexed = $this->indexData($formattedValues, $rowsHeader, $columnsHeader);

        return $indexed;
    }

    private function parseRowsHeaderNames(array $rawData)
    {
        $rowsHeaderNames = [];
        foreach ($this->getExpectedRowsHeader() as $expectedColumnIndex => $expectedHeaderValue) {
            $this->checkHeaderValue($rawData, $expectedColumnIndex, $expectedHeaderValue);
            $rowsHeaderNames[$expectedColumnIndex] = $expectedHeaderValue;
        }

        return $rowsHeaderNames;
    }

    /** @return string[] */
    abstract protected function getExpectedRowsHeader();

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

    private function parseRowsHeader(array $data)
    {
        $rowsHeaderNamesRow = $this->parseRowsHeaderNames($data);
        $rowsHeaderValues = []; // rows header values to data row index
        foreach ($data as $rowIndex => $dataRow) {
            if ($rowIndex === 0) {
                continue; // skipping header names
            }
            $rowsHeaderValuesPart = &$rowsHeaderValues;
            foreach ($rowsHeaderNamesRow as $dataColumnIndex => $headerName) {
                $headerValue = $dataRow[$dataColumnIndex];
                if (!isset($rowsHeaderValuesPart[$headerValue])) {
                    $rowsHeaderValuesPart[$headerValue] = [];
                }
                $rowsHeaderValuesPart = &$rowsHeaderValuesPart[$headerValue];
            }
            $rowsHeaderValuesPart = $rowIndex - 1; // because of gap by skipped first row
        }

        return $rowsHeaderValues;
    }

    private function cutOffRowsHeader(array $values)
    {
        $columnIndexes = array_keys($this->getExpectedRowsHeader());
        foreach (array_keys($values) as $rowIndex) {
            foreach ($columnIndexes as $columnIndex) {
                unset($values[$rowIndex][$columnIndex]);
            }
            // fixing number-indexes sequence ([1=>foo, 3=>bar] = [0=>foo, 1=>bar])
            $values[$rowIndex] = array_merge($values[$rowIndex]);
        }

        return $values; // pure values without header
    }

    private function parseColumnsHeader(array $data)
    {
        $columnsHeaderValues = [];
        $expectedHeaderRow = $this->getNormalizedExpectedColumnsHeader(); // the very first rows of data
        foreach (array_keys($expectedHeaderRow) as $dataColumnIndex) {
            $expectedHeaderValue = $expectedHeaderRow[$dataColumnIndex]['value'];
            $this->checkHeaderValue($data, $dataColumnIndex, $expectedHeaderValue);
            $columnsHeaderValues[$dataColumnIndex] = $expectedHeaderValue;
        }

        return $columnsHeaderValues;
    }

    private function cutOffColumnsHeader(array $rawData)
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

    private function getNormalizedExpectedColumnsHeader()
    {
        if (!isset($this->normalizedExpectedColumnHeader)) {
            $this->normalizedExpectedColumnHeader = [];
            $columnIndex = 0;
            foreach ($this->getExpectedColumnsHeader() as $headerName => $columnScalarType) {
                $this->normalizedExpectedColumnHeader[$columnIndex++] = [
                    'value' => $headerName,
                    'type' => $this->normalizeScalarType($columnScalarType),
                ];
            }
        }

        return $this->normalizedExpectedColumnHeader;
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
                throw new Exceptions\UnknownScalarTypeForColumn(
                    'Unknown scalar type ' . ValueDescriber::describe($scalarType)
                );
        }
    }

    /** @return string[] */
    abstract protected function getExpectedColumnsHeader();

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
                throw new Exceptions\UnknownScalarTypeForColumn(
                    'Unknown scalar type ' . ValueDescriber::describe($columnType)
                );
        }
    }

    private function getColumnType($columnIndex)
    {
        $header = $this->getNormalizedExpectedColumnsHeader();

        return $header[$columnIndex]['type'];
    }

    private function normalizeMinus($value)
    {
        return str_replace('−' /* ASCII 226 */, '-' /* ASCII 45 */, $value);
    }

    private function indexData(array $values, array $rowsHeader, array $columnsHeader)
    {
        $indexedRows = $this->indexByRowsHeader($values, $rowsHeader);
        $indexed = $this->indexByColumnsHeader($indexedRows, $columnsHeader);

        return $indexed;
    }

    private function indexByRowsHeader(array $toIndex, array $rowKeys)
    {
        $indexed = [];
        foreach ($rowKeys as $keyPart => $keyPartsOrRowIndex) {
            if (is_int($keyPartsOrRowIndex)) { // last string key pointing to row index
                $rowIndex = $keyPartsOrRowIndex;
                $indexed[$keyPart] = $toIndex[$rowIndex];
            } else {
                $indexed[$keyPart] = [];
                $indexed[$keyPart] = $this->indexByRowsHeader($toIndex, $keyPartsOrRowIndex);
            }
        }

        return $indexed;
    }

    private function indexByColumnsHeader(array $toIndex, array $columnKeys)
    {
        $indexed = [];
        foreach ($toIndex as $rowKeyOrColumnIndex => $rowOrFinalValue) {
            if (!is_array($rowOrFinalValue)) {
                $columnIndex = $rowKeyOrColumnIndex;
                $finalValue = $rowOrFinalValue;
                $columnKey = $columnKeys[$columnIndex];
                $indexed[$columnKey] = $finalValue;
            } else {
                $indexed[$rowKeyOrColumnIndex] = $this->indexByColumnsHeader($rowOrFinalValue, $columnKeys);
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
