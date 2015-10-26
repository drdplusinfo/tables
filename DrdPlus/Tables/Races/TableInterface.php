<?php
namespace DrdPlus\Tables\Races;

interface TableInterface
{

    /**
     * @param array $verticalIndexes
     * @param array $horizontalIndexes
     *
     * @return mixed
     */
    public function getValue(array $verticalIndexes, array $horizontalIndexes);
}
