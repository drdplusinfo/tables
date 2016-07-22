<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface WearableParametersInterface
{
    const REQUIRED_STRENGTH = 'required_strength';

    /**
     * @param string $itemCode
     * @return int
     */
    public function getRequiredStrengthOf($itemCode);

    const WEIGHT = 'weight';

    /**
     * @param string $itemCode
     * @return float
     */
    public function getWeightOf($itemCode);
}