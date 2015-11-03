<?php
namespace DrdPlus\Tables\Races;

use Granam\Integer\Tools\ToInteger;
use Granam\Scalar\Tools\ValueDescriber;

abstract class AbstractTable implements TableInterface
{
    /** @var array */
    private $values;
    /** @var array */
    private $horizontalHeader;
    /** @var array */
    private $verticalHeader;

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
        list($this->verticalHeader, $this->horizontalHeader, $this->values) = $this->mapValues($rawData);
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
        $verticalHeader = $this->parseVerticalHeader($rawData);
        $valuesWithoutVerticalHeader = $this->cutOffVerticalHeader($rawData);

        $horizontalHeader = $this->parseHorizontalHeader($valuesWithoutVerticalHeader);
        $valuesWithoutHeader = $this->cutOffHorizontalHeader($valuesWithoutVerticalHeader);

        $formattedValues = $this->formatValues($valuesWithoutHeader);

        return [$verticalHeader, $horizontalHeader, $formattedValues];
    }

    private function parseVerticalHeaderNames(array $rawData)
    {
        $verticalHeaderNames = [];
        foreach ($this->getExpectedVerticalHeader() as $expectedRowIndex => $expectedVerticalHeaderRow) {
            $verticalHeaderNames[$expectedRowIndex] = [];
            foreach ($expectedVerticalHeaderRow as $expectedColumnIndex => $expectedHeaderValue) {
                $this->checkHeaderValue($rawData, $expectedRowIndex, $expectedColumnIndex, $expectedHeaderValue);
                $verticalHeaderNames[$expectedRowIndex][$expectedColumnIndex] = $expectedHeaderValue;
            }
        }

        return $verticalHeaderNames;
    }

    /** @return string[][] */
    abstract protected function getExpectedVerticalHeader();

    private function checkHeaderValue($rawData, $expectedRowIndex, $columnIndex, $expectedHeaderValue)
    {
        if (!isset($rawData[$expectedRowIndex])) {
            throw new Exceptions\DataAreCorrupted('Expected header row with index ' . $expectedRowIndex);
        }
        if (!isset($rawData[$expectedRowIndex][$columnIndex])) {
            throw new Exceptions\DataAreCorrupted(
                'Missing cell with row index ' . $expectedRowIndex . ' and column index ' . $columnIndex
            );
        }
        if ($rawData[$expectedRowIndex][$columnIndex] !== $expectedHeaderValue) {
            throw new Exceptions\DataAreCorrupted(
                "Expected header with name '$expectedHeaderValue' on row index "
                . $expectedRowIndex . " and column index " . $columnIndex
                . ', got ' . ValueDescriber::describe($rawData[$expectedRowIndex][$columnIndex])
            );
        }
    }

    private function parseVerticalHeader(array $data)
    {
        $verticalHeaderNames = $this->parseVerticalHeaderNames($data);
        $verticalHeaderValues = []; // vertical header values to data row index
        foreach ($data as $rowIndex => $dataRow) {
            $verticalHeaderValuesIndex = $rowIndex - count($verticalHeaderNames);
            if ($verticalHeaderValuesIndex >= 0) { // otherwise skip header names
                $verticalHeaderValuesRow = [];
                $verticalHeaderValuesRowPart = &$verticalHeaderValuesRow;
                foreach ($verticalHeaderNames as $verticalHeaderNamesRow) {
                    foreach ($verticalHeaderNamesRow as $dataColumnIndex => $headerName) {
                        $headerValue = $dataRow[$dataColumnIndex];
                        $verticalHeaderValuesRowPart[$headerValue] = [];
                        $verticalHeaderValuesRowPart = &$verticalHeaderValuesRowPart[$headerValue];
                    }
                }
                $verticalHeaderValuesRowPart = $verticalHeaderValuesIndex;
                $verticalHeaderValues = array_merge_recursive($verticalHeaderValues, $verticalHeaderValuesRow);
            }
        }

        return $verticalHeaderValues;
    }

    private function cutOffVerticalHeader(array $values)
    {
        foreach (array_keys($values) as $rowIndex) {
            foreach (array_keys($this->getExpectedVerticalHeader()[0]) as $columnIndex) {
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
        $expectedHeader = $this->getExpectedHorizontalHeader(); // the very first rows of data
        foreach (array_keys(current($expectedHeader)) as $dataColumnIndex) {
            $horizontalHeaderValuesColumn = [];
            $horizontalHeaderValuesColumnPart = &$horizontalHeaderValuesColumn;
            foreach ($expectedHeader as $headerRowIndex => $expectedHeaderRow) {
                $expectedHeaderValue = $expectedHeaderRow[$dataColumnIndex];
                $this->checkHeaderValue($data, $headerRowIndex, $dataColumnIndex, $expectedHeaderValue);
                $horizontalHeaderValuesColumnPart[$expectedHeaderValue] = [];
                $horizontalHeaderValuesColumnPart = &$horizontalHeaderValuesColumnPart[$expectedHeaderValue];
            }
            $horizontalHeaderValuesColumnPart = $dataColumnIndex;
            $horizontalHeaderValues = array_merge_recursive($horizontalHeaderValues, $horizontalHeaderValuesColumn);
        }

        return $horizontalHeaderValues;
    }

    private function cutOffHorizontalHeader(array $rawData)
    {
        foreach (array_keys($this->getExpectedHorizontalHeader()) as $rowIndexWithAxisXHeader) {
            unset($rawData[$rowIndexWithAxisXHeader]);
        }

        return array_merge($rawData); // fixing row numeric indexes sequence ([1=>foo, 3=>bar] = [0=>foo, 1=>bar])
    }

    private function formatValues(array $data)
    {
        return array_map(
            function (array $row) {
                return array_map(
                    function ($value) {
                        return $this->parseValue($value);
                    },
                    $row
                );
            },
            $data
        );
    }

    /** @return string[][] */
    abstract protected function getExpectedHorizontalHeader();

    private function parseValue($value)
    {
        $value = trim($value);
        if ($value === '') {
            return $value;
        }

        return ToInteger::toInteger($this->parseNumber($value));
    }

    private function parseNumber($value)
    {
        return str_replace('−' /* ASCII 226 */, '-' /* ASCII 45 */, $value);
    }

    /** @return array */
    protected function getHorizontalHeader()
    {
        if (!isset($this->horizontalHeader)) {
            $this->loadData();
        }

        return $this->horizontalHeader;
    }

    /** @return array */
    protected function getVerticalHeader()
    {
        if (!isset($this->verticalHeader)) {
            $this->loadData();
        }

        return $this->verticalHeader;
    }

    /**
     * @param array $verticalCoordinates
     * @param array $horizontalCoordinates
     *
     * @return int|false
     */
    public function getValue(array $verticalCoordinates, array $horizontalCoordinates)
    {
        $row = $this->getRow($this->getValues(), $this->getVerticalHeader(), $verticalCoordinates);

        $value = $this->getValueInRow($row, $this->getHorizontalHeader(), $horizontalCoordinates);

        return $value;
    }

    private function getRow(array $data, array $header, array $verticalCoordinates)
    {
        $rowIndex = $this->findIndex($header, $verticalCoordinates);

        return $data[$rowIndex];
    }

    /** @noinspection PhpInconsistentReturnPointsInspection */
    /**
     * @param array $header
     * @param array $searchedCoordinates
     *
     * @return int
     */
    private function findIndex(array $header, array $searchedCoordinates)
    {
        $headerPart = $header;
        $index = null;
        foreach ($searchedCoordinates as $coordinatePart) {
            if (!isset($headerPart[$coordinatePart])) {
                throw new Exceptions\RequiredDataNotFound(
                    'Was searching for data index in header "' . var_export($header, true)
                    . '" by coordinates "' . var_export($searchedCoordinates, true) . '"'
                );
            }
            $headerPart = &$headerPart[$coordinatePart];
            if (is_int($headerPart)) {
                $index = $headerPart;
                break;
            }
        }

        return $index;
    }

    private function getValueInRow(array $row, array $horizontalHeader, array $horizontalCoordinates)
    {
        $columnIndex = $this->findIndex($horizontalHeader, $horizontalCoordinates);

        return $row[$columnIndex];
    }
}
