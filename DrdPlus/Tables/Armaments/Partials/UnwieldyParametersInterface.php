<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface UnwieldyParametersInterface extends WearableParametersInterface
{
    const RESTRICTION = 'restriction';

    /**
     * @param string $coverCode
     * @return int
     */
    public function getRestrictionOf($coverCode);
}