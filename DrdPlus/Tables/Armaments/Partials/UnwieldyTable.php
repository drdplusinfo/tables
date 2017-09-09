<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

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