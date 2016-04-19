<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface WearableParametersInterface
{
    const REQUIRED_STRENGTH_HEADER = 'required_strength';

    /**
     * @param string $itemCode
     * @return false|int
     */
    public function getRequiredStrengthOf($itemCode);

    const WEIGHT_HEADER = 'weight';

    /**
     * @param string $itemCode
     * @return float
     */
    public function getWeightOf($itemCode);
}