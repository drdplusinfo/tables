<?php
namespace DrdPlus\Tables\Measurements\Parts;

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
            $this->valuesInFlatStructure = $this->toFlatStructure($this->getIndexedValues());
        }

        return $this->valuesInFlatStructure;
    }

    private function toFlatStructure(array $values)
    {
        $inFlatStructure = [];
        foreach ($values as $value) {
            $row = $this->toRow($value);
            $inFlatStructure[] = $row;
        }

        return $inFlatStructure;
    }

    private function toRow($values)
    {
        if (!is_array($values)) {
            return [$values];
        }
        $row = [];
        foreach ($values as $value) {
            if (is_array($value)) {
                $value = $this->toRow($value);
                $row = array_merge($row, $value); // flatting the structure
            } else {
                $row [] = $value;
            }
        }

        return $row;
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
        $maxRowsCount = max(count($rowsHeader), max($columnsHeader));
        $rowsHeaderIndexShift = count($rowsHeader) - $maxRowsCount;
        $columnsHeaderIndexShift = count($columnsHeader) - $maxRowsCount;
        $header = [];
        for ($rowIndex = 0; $rowIndex < $maxRowsCount; $rowIndex++) {
            $headerRow = [];
            $rowsHeaderIndex = $rowIndex + $rowsHeaderIndexShift;
            if (isset($rowsHeader[$rowsHeaderIndex])) {
                $headerRow = array_merge($headerRow, $rowsHeader[$rowsHeaderIndex]);
            }
            $columnsHeaderIndex = $rowIndex + $columnsHeaderIndexShift;
            if (isset($columnsHeader[$columnsHeaderIndex])) {
                $headerRow = array_merge($headerRow, $columnsHeader[$rowsHeaderIndex]);
            }
            $header[] = $headerRow;
        }

        return $header;
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
