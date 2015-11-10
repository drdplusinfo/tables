<?php
namespace DrdPlus\Tables\Races;

interface TableInterface
{

    /**
     * @param array $rowIndexes
     * @param $columnIndex
     * @return int|float|bool
     */
    public function getValue(array $rowIndexes, $columnIndex);
}
