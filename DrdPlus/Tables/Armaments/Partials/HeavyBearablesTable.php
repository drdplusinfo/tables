<?php
namespace DrdPlus\Tables\Armaments\Partials;

use Granam\String\StringInterface;

interface HeavyBearablesTable extends BearablesTable
{
    const REQUIRED_STRENGTH = 'required_strength';

    /**
     * @param string|StringInterface $wearableCode
     * @return int|false
     */
    public function getRequiredStrengthOf($wearableCode);
}