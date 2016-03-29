<?php
namespace DrdPlus\Tables\Parts;

use Granam\Boolean\Tools\ToBoolean;
use Granam\Float\Tools\ToFloat;
use Granam\Integer\Tools\ToInteger;
use Granam\Tools\ValueDescriber;

abstract class AbstractFileTable extends AbstractTable
{
    const INTEGER = 'integer';
    const FLOAT = 'float';
    const BOOLEAN = 'boolean';
    const STRING = 'string';

    /** @var array */
    private $indexedValues;

    /** @var array */
    private $normalizedExpectedColumnHeader;

    /** @var array */
    private $columnsHeader;

    /**
     * @return array|string[][]|string[][][]
     */
    public function getIndexedValues()
    {
        if (!isset($this->indexedValues)) {
            $this->loadData();
        }

        return $this->indexedValues;
    }

    /**
     * @return array
     */
    protected function getRowsHeader()
    {
        return $this->getExpectedRowsHeader();
    }

    /**
     * @return array|string[][]|string[][][]
     */
    protected function getColumnsHeader()
    {
        if (!isset($this->columnsHeader)) {
            $this->loadData();
        }

        return $this->columnsHeader;
    }

    /** @return array */
    private function loadData()
    {
        $rawData = $this->fetchDataFromFile($this->getDataFileName());
        $this->indexedValues = $this->normalizeAndIndex($rawData);
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

    private function normalizeAndIndex(array $rawData)
    {
        $rowsHeader = $this->parseRowsHeader($rawData);
        $this->columnsHeader = $this->parseColumnsHeader($rawData);
        $valuesWithoutColumnsHeader = $this->cutOffColumnsHeader($rawData);
        $valuesWithoutHeader = $this->cutOffRowsHeader($valuesWithoutColumnsHeader);
        $formattedValues = $this->formatValues($valuesWithoutHeader);
        $indexed = $this->indexValues($formattedValues, $rowsHeader, $this->columnsHeader);

        return $indexed;
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

    /** @return string[] */
    abstract protected function getExpectedRowsHeader();

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

    private function parseRowsHeaderNames(array $rawData)
    {
        $rowsHeaderNames = [];
        foreach ($this->getExpectedRowsHeader() as $expectedColumnIndex => $expectedHeaderValue) {
            $this->checkHeaderValue($rawData, $expectedColumnIndex, $expectedHeaderValue);
            $rowsHeaderNames[$expectedColumnIndex] = $expectedHeaderValue;
        }

        return $rowsHeaderNames;
    }

    private function checkHeaderValue($rawData, $columnIndex, $expectedHeaderValue)
    {
        if (!isset($rawData[0][$columnIndex])) {
            throw new Exceptions\DataAreCorrupted(
                "Missing header cell[$columnIndex] with expected value " . ValueDescriber::describe($expectedHeaderValue)
            );
        }
        if ($rawData[0][$columnIndex] !== $expectedHeaderValue) {
            throw new Exceptions\DataAreCorrupted(
                "Expected header with name '$expectedHeaderValue' on first row and column with index " . $columnIndex
                . ', got ' . ValueDescriber::describe($rawData[0][$columnIndex])
            );
        }
    }

    private function parseColumnsHeader(array $rawData)
    {
        $columnsHeaderValues = [];
        $expectedHeaderRow = $this->getNormalizedExpectedColumnsHeader(); // the very first rows of data
        $indexShift = count($this->getExpectedRowsHeader());
        foreach (array_keys($expectedHeaderRow) as $expectedColumnIndex) {
            $expectedHeaderValue = $expectedHeaderRow[$expectedColumnIndex]['value'];
            $rawDataColumnIndex = $expectedColumnIndex + $indexShift;
            $this->checkHeaderValue($rawData, $rawDataColumnIndex, $expectedHeaderValue);
            $columnsHeaderValues[$expectedColumnIndex] = $expectedHeaderValue;
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
                        return $this->parseRowValue($value, $columnIndex);
                    },
                    $row, array_keys($row)
                );
            },
            $data
        );
    }

    private function getNormalizedExpectedColumnsHeader()
    {
        if ($this->normalizedExpectedColumnHeader === null) {
            $this->normalizedExpectedColumnHeader = [];
            $columnIndex = 0;
            foreach ($this->getExpectedDataHeader() as $headerName => $columnScalarType) {
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
            case self::STRING :
                return self::STRING;
            default :
                throw new Exceptions\UnknownScalarTypeForColumn(
                    'Unknown scalar type ' . ValueDescriber::describe($scalarType)
                );
        }
    }

    /** @return string[] */
    abstract protected function getExpectedDataHeader();

    private function parseRowValue($value, $columnIndex)
    {
        $value = trim($value);
        switch ($columnType = $this->getColumnType($columnIndex)) {
            case self::BOOLEAN :
                return ToBoolean::toBoolean($value);
            case self::INTEGER :
                return ToInteger::toInteger($this->normalizeMinus($value));
            case self::FLOAT :
                return ToFloat::toFloat($this->normalizeMinus($value));
            default : // string
                return (string)$value;
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

    private function indexValues(array $values, array $rowsHeader, array $columnsHeader)
    {
        $indexedRows = $this->indexByRowsHeader($values, $rowsHeader);

        return $this->indexByColumnsHeader($indexedRows, $columnsHeader);
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

        return $this->getValueInRow($row, $columnIndex);
    }

    /**
     * @param array $rowIndexes
     *
     * @return array|mixed[]
     */
    public function getRow(array $rowIndexes)
    {
        $values = $this->getIndexedValues();
        $row = null;
        foreach ($rowIndexes as $rowIndex) {
            if (!isset($values[$rowIndex])) {
                throw new Exceptions\RequiredRowDataNotFound(
                    'Has not found row by index ' . ValueDescriber::describe($rowIndex)
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
            throw new Exceptions\RequiredValueNotFound(
                'Has not found value in row by index ' . ValueDescriber::describe($columnIndex)
            );
        }

        return $row[$columnIndex];
    }
}
