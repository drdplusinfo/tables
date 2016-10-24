<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface HeavyBearablesTable extends BearablesTable
{
    const REQUIRED_STRENGTH = 'required_strength';

    /**
     * @param string $wearableCode
     * @return int
     */
    public function getRequiredStrengthOf($wearableCode);
}