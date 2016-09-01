<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface UnwieldyTableInterface extends WearableTableInterface
{
    const RESTRICTION = 'restriction';

    /**
     * @param string $coverCode
     * @return int
     */
    public function getRestrictionOf($coverCode);
}