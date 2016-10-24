<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface UnwieldyTable extends HeavyBearablesTable
{
    const RESTRICTION = 'restriction';

    /**
     * @param string $coverCode
     * @return int
     */
    public function getRestrictionOf($coverCode);
}