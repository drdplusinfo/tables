<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface WearableParameters
{
    /**
     * @param string $itemCode
     * @return false|int
     */
    public function getRequiredStrengthOf($itemCode);

    /**
     * @param string $itemCode
     * @return float
     */
    public function getWeightOf($itemCode);
}