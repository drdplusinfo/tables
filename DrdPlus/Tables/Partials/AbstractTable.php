<?php
namespace DrdPlus\Tables\Partials;

use DrdPlus\Tables\Table;
use Granam\Scalar\ScalarInterface;
use Granam\Scalar\Tools\ToString;
use Granam\Strict\Object\StrictObject;
use Granam\String\StringInterface;
use Granam\Tools\ValueDescriber;

abstract class AbstractTable extends StrictObject implements Table
{
    /** @var array|string[][] */
    private $valuesInFlatStructure;

    /** @var array|string[][] */
    private $headerInFlatStructure;

    /**
     * @return array|\string[][]
     */
    public function getValues()
    {
        if ($this->valuesInFlatStructure === null) {
            $this->valuesInFlatStructure = $this->toFlatStructure(
                $this->getIndexedValues(), true // keys to values
            );
        }

        return $this->valuesInFlatStructure;
    }

    public function getHeader()
    {
        if ($this->headerInFlatStructure === null) {
            $this->headerInFlatStructure = $this->createHeader();
        }

        return $this->headerInFlatStructure;
    }

    private function createHeader()
    {
        $rowsHeader = $this->toFlatStructure($this->getRowsHeader());
        $columnsHeader = $this->toFlatStructure($this->getColumnsHeader());
        $rowsHeaderRowCount = count(current($rowsHeader));
        $columnsHeaderRowCount = count(current($columnsHeader));
        $maxRowsCount = max($rowsHeaderRowCount, $columnsHeaderRowCount);
        $rowsHeaderIndexShift = $rowsHeaderRowCount - $maxRowsCount;
        $columnsHeaderIndexShift = $columnsHeaderRowCount - $maxRowsCount;
        $header = [];
        for ($rowIndex = 0; $rowIndex < $maxRowsCount; $rowIndex++) {
            $headerRowFromRowsHeader = [];
            $rowsHeaderRowIndex = $rowIndex + $rowsHeaderIndexShift;
            if ($rowsHeaderRowIndex < 0) { // not yet
                $headerRowFromRowsHeader[] = '';
            } else {
                foreach ($rowsHeader as $columnsHeaderColumn) {
                    $headerRowFromRowsHeader[] = $columnsHeaderColumn[$rowsHeaderRowIndex];
                }
            }
            $headerRowFromColumnsHeader = [];
            $columnsHeaderRowIndex = $rowIndex + $columnsHeaderIndexShift;
            if ($columnsHeaderRowIndex < 0) { // not yet
                $headerRowFromColumnsHeader[] = '';
            } else {
                foreach ($columnsHeader as $columnsHeaderColumn) {
                    $headerRowFromColumnsHeader[] = $columnsHeaderColumn[$columnsHeaderRowIndex];
                }
            }
            $header[] = array_merge(
                $headerRowFromRowsHeader,
                array_diff($headerRowFromColumnsHeader, $headerRowFromRowsHeader) // only those not already included by rows header
            );
        }

        return $header;
    }

    private function toFlatStructure(array $values, $convertTopKeysToValues = false)
    {
        $inFlatStructure = [];
        foreach ($values as $key => $wrappedValues) {
            if (!is_array($wrappedValues)) {
                $rows = [[$wrappedValues]];
            } elseif (!is_array(current($wrappedValues))) {
                $rows = [array_values($wrappedValues)];
            } else {
                $rows = $this->toFlatStructure($wrappedValues, $convertTopKeysToValues);
            }
            if ($convertTopKeysToValues) {
                foreach ($rows as &$row) {
                    array_unshift($row, $key);
                }
                unset($row);
            }
            foreach ($rows as $wantedRow) {
                $inFlatStructure[] = $wantedRow;
            }
        }

        return $inFlatStructure;
    }

    /**
     * Names of those first columns defining where row names lays (mostly just first column).
     *
     * @return array|\ArrayObject|string[]|string[][]
     */
    abstract protected function getRowsHeader();

    /**
     * Names of all those columns where data itself lays (mostly all except first one).
     *
     * @return array|\ArrayObject|string[]|string[][][]
     */
    abstract protected function getColumnsHeader();

    /**
     * @param array|string|int|ScalarInterface $rowIndexes
     * @param string|StringInterface $columnIndex
     * @return int|float|string|bool
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\NoRowRequested
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getValue($rowIndexes, $columnIndex)
    {
        $row = $this->getRow((array)$rowIndexes);

        return $this->getValueInRow($row, $columnIndex);
    }

    /**
     * @param array|string $singleRowIndexes
     * @return array|mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\NoRowRequested
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function getRow($singleRowIndexes)
    {
        $arraySingleRowIndexes = (array)$singleRowIndexes;
        if (count($arraySingleRowIndexes) === 0) {
            throw new Exceptions\NoRowRequested('Expected row indexes, got empty array');
        }
        $values = $this->getIndexedValues();
        foreach ($arraySingleRowIndexes as $rowIndex) {
            $stringRowIndex = ToString::toString($rowIndex);
            if (!array_key_exists($stringRowIndex, $values)) {
                throw new Exceptions\RequiredRowNotFound(
                    'Row has not been found by index ' . ValueDescriber::describe($rowIndex)
                );
            }
            $values = $values[$stringRowIndex];
            if (!is_array(current($values))) { // flat array found
                break;
            }
        }

        return $values;
    }

    /**
     * @param array $row
     * @param string|int|float|ScalarInterface $columnIndex
     * @return int|float|string|bool
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    private function getValueInRow(array $row, $columnIndex)
    {
        $stringColumnIndex = ToString::toString($columnIndex);
        if (!array_key_exists($stringColumnIndex, $row)) {
            throw new Exceptions\RequiredColumnNotFound(
                'Column of name ' . ValueDescriber::describe($columnIndex) . ' does not exist'
            );
        }

        return $row[$stringColumnIndex];
    }

}