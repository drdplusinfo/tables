<?php
namespace DrdPlus\Tables\Partials;

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
    const SLASH_ARRAY_OF_INTEGERS = 'slash_array_of_integers';

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
        if ($this->indexedValues === null) {
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
        if ($this->columnsHeader === null) {
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
            if ($row !== false && count($row) > 0) { // otherwise skip empty row
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
        $rowIndexes = array_keys($values);
        foreach ($rowIndexes as $rowIndex) {
            foreach ($columnIndexes as $columnIndex) {
                unset($values[$rowIndex][$columnIndex]);
            }
            // fixing sequence of number indexes ([1=>foo, 3=>bar] = [0=>foo, 1=>bar])
            $values[$rowIndex] = array_values($values[$rowIndex]);
        }

        return $values; // pure values without header
    }

    /** @return string[] */
    abstract protected function getExpectedRowsHeader();

    private function parseRowsHeader(array $data)
    {
        $rowsHeaderNamesRow = $this->parseRowsHeaderNames($data);
        if (count($rowsHeaderNamesRow) === 0) {
            return [];
        }
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

    private function checkHeaderValue(array $rawData, $columnIndex, $expectedHeaderValue)
    {
        if (!array_key_exists(0, $rawData) || !array_key_exists($columnIndex, $rawData[0])) {
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
        $expectedColumnIndexes = array_keys($expectedHeaderRow);
        foreach ($expectedColumnIndexes as $expectedColumnIndex) {
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

        return array_values($rawData); // fixing row numeric indexes sequence ([1=>foo, 3=>bar] = [0=>foo, 1=>bar])
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
            case self::SLASH_ARRAY_OF_INTEGERS :
                return self::SLASH_ARRAY_OF_INTEGERS;
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
        return $this->normalizeValueForType($value, $this->getColumnType($columnIndex));
    }

    private function getColumnType($columnIndex)
    {
        $header = $this->getNormalizedExpectedColumnsHeader();

        return $header[$columnIndex]['type'];
    }

    private function normalizeValueForType($value, $type)
    {
        $value = trim($value);
        switch ($type) {
            case self::BOOLEAN :
                return ToBoolean::toBoolean($value, false /* not strict */);
            case self::INTEGER :
                return $value === '' ? false : ToInteger::toInteger($this->normalizeMinus($value));
            case self::FLOAT :
                return $value === '' ? false : ToFloat::toFloat($this->normalizeMinus($value));
            case self::SLASH_ARRAY_OF_INTEGERS :
                return $value === ''
                    ? []
                    : array_map(
                        function ($fromArrayValue) {
                            return $this->normalizeValueForType($fromArrayValue, self::INTEGER);
                        },
                        explode('/', $value)
                    );
            default : // string
                return $value;
        }
    }

    private function normalizeMinus($value)
    {
        return str_replace('−' /* ASCII 226 */, '-' /* ASCII 45 */, $value);
    }

    private function indexValues(array $values, array $rowsHeader, array $columnsHeader)
    {
        $indexedRows = $this->indexByRowsHeader($values, $rowsHeader);

        return $this->indexByColumnsHeader($indexedRows, $columnsHeader, $this->countDept($rowsHeader));
    }

    private function countDept(array $rowsHeader)
    {
        $depth = 1; // always at least 1
        $value = current($rowsHeader);
        if (is_array($value)) {
            $depth += $this->countDept($value);
        }

        return $depth;
    }

    private function indexByRowsHeader(array $toIndex, array $rowKeys)
    {
        if (count($rowKeys) === 0) {
            return $toIndex;
        }
        $indexed = [];
        foreach ($rowKeys as $keyPart => $keyPartsOrRowIndex) {
            if (is_int($keyPartsOrRowIndex)) { // last key pointing to row index
                $indexed[$keyPart] = $toIndex[$keyPartsOrRowIndex];
            } else {
                $indexed[$keyPart] = [];
                $indexed[$keyPart] = $this->indexByRowsHeader($toIndex, $keyPartsOrRowIndex);
            }
        }

        return $indexed;
    }

    private function indexByColumnsHeader(array $toIndex, array $columnKeys, $stepsToBottom)
    {
        $indexed = [];
        foreach ($toIndex as $rowKeyOrColumnIndex => $rowOrFinalValue) {
            if (!is_array($rowOrFinalValue)
                || ($stepsToBottom === 0 && $this->isArrayColumnType($rowKeyOrColumnIndex))
            ) {
                $columnKey = $columnKeys[$rowKeyOrColumnIndex];
                $indexed[$columnKey] = $rowOrFinalValue;
            } else {
                $indexed[$rowKeyOrColumnIndex] = $this->indexByColumnsHeader($rowOrFinalValue, $columnKeys, $stepsToBottom - 1);
            }
        }

        return $indexed;
    }

    private function isArrayColumnType($columnIndex)
    {
        return $this->getColumnType($columnIndex) === self::SLASH_ARRAY_OF_INTEGERS;
    }

    /**
     * @param array $rowIndexes
     * @param string $columnIndex
     * @return int|float|string|bool
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredValueNotFound
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
     * @throws \DrdPlus\Tables\Partials\Exceptions\NoRowRequested
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getRow(array $rowIndexes)
    {
        if (count($rowIndexes) === 0) {
            throw new Exceptions\NoRowRequested('Expected row indexes, got empty array');
        }
        $values = $this->getIndexedValues();
        foreach ($rowIndexes as $rowIndex) {
            if (!isset($values[$rowIndex])) {
                throw new Exceptions\RequiredRowDataNotFound(
                    'Row has not been found by index ' . ValueDescriber::describe($rowIndex)
                );
            }
            $values = &$values[$rowIndex];
            if (!is_array(current($values))) { // flat array found
                break;
            }
        }

        return $values;
    }

    /**
     * @param array $row
     * @param $columnIndex
     * @return int|float|string|bool
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredValueNotFound
     */
    private function getValueInRow(array $row, $columnIndex)
    {
        if (!array_key_exists($columnIndex, $row)) {
            throw new Exceptions\RequiredValueNotFound(
                'Has not found value in row by index ' . ValueDescriber::describe($columnIndex)
            );
        }

        return $row[$columnIndex];
    }
}
