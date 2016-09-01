<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface WearableTableInterface
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