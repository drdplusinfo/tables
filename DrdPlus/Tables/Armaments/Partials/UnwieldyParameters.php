<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface UnwieldyParameters extends WearableParameters
{
    /**
     * @param string $coverCode
     * @return int
     */
    public function getRestrictionOf($coverCode);
}