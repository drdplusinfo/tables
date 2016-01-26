<?php
namespace DrdPlus\Tables\Parts;

use DrdPlus\Tables\Table;
use Granam\Strict\Object\StrictObject;

abstract class AbstractTable extends StrictObject implements Table
{
    /** @var array|string[][] */
    private $valuesInFlatStructure;

    /** @var array|string[][] */
    private $headerInFlatStructure;

    public function getValues()
    {
        if (!isset($this->valuesInFlatStructure)) {
            $this->valuesInFlatStructure = $this->toFlatStructure(
                $this->getIndexedValues(), true // keys to values
            );
        }

        return $this->valuesInFlatStructure;
    }

    public function getHeader()
    {
        if (!isset($this->headerInFlatStructure)) {
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
            $headerRow = [];
            $rowsHeaderRowIndex = $rowIndex + $rowsHeaderIndexShift;
            if ($rowsHeaderRowIndex >= 0) {
                foreach ($rowsHeader as $columnsHeaderColumn) {
                    $headerRow[] = $columnsHeaderColumn[$rowsHeaderRowIndex];
                }
            } else {
                $headerRow[] = '';
            }
            $columnsHeaderRowIndex = $rowIndex + $columnsHeaderIndexShift;
            if ($columnsHeaderRowIndex >= 0) {
                foreach ($columnsHeader as $columnsHeaderColumn) {
                    $headerRow[] = $columnsHeaderColumn[$columnsHeaderRowIndex];
                }
            } else {
                $headerRow[] = '';
            }
            $header[] = $headerRow;
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
            }
            $inFlatStructure = array_merge($inFlatStructure, $rows);
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
