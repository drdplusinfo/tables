<?php
namespace DrdPlus\Tables\Armaments\Partials;

use DrdPlus\Tables\Table;

interface BearablesTable extends Table
{
    const WEIGHT = 'weight';

    /**
     * @param string $itemCode
     * @return float
     */
    public function getWeightOf($itemCode);
}