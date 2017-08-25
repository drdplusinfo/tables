<?php
namespace DrdPlus\Tables\Armaments\Partials;

use DrdPlus\Tables\Table;
use Granam\String\StringInterface;

interface BearablesTable extends Table
{
    const WEIGHT = 'weight';

    /**
     * @param string|StringInterface $itemCode
     * @return float
     */
    public function getWeightOf($itemCode): float;
}