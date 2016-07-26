<?php
namespace DrdPlus\Tables\Partials;

use DrdPlus\Tables\Table;
use Granam\Strict\Object\StrictObject;

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
     * @return array|\ArrayObject|string[]|string[][]
     */
    abstract protected function getRowsHeader();

    /**
     * @return array|\ArrayObject|string[]|string[][][]
     */
    abstract protected function getColumnsHeader();

}
