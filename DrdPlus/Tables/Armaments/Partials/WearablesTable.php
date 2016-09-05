<?php
namespace DrdPlus\Tables\Armaments\Partials;

use DrdPlus\Tables\Table;

interface WearablesTable extends Table
{
    const REQUIRED_STRENGTH = 'required_strength';

    /**
     * @param string $wearableCode
     * @return int
     */
    public function getRequiredStrengthOf($wearableCode);

    const WEIGHT = 'weight';

    /**
     * @param string $itemCode
     * @return float
     */
    public function getWeightOf($itemCode);
}