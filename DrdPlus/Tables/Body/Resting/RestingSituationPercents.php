<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Body\Resting;

use DrdPlus\Tables\Partials\Exceptions\UnexpectedPercents;
use DrdPlus\Tables\Partials\Percents;

class RestingSituationPercents extends Percents
{
    /**
     * @param mixed $value
     * @throws \DrdPlus\Tables\Body\Resting\Exceptions\UnexpectedRestingSituationPercents
     */
    public function __construct($value)
    {
        try {
            parent::__construct($value);
        } catch (UnexpectedPercents $unexpectedPercents) {
            throw new Exceptions\UnexpectedRestingSituationPercents($unexpectedPercents->getMessage());
        }
    }

}