<?php
namespace DrdPlus\Tables\Body\Healing;

use DrdPlus\Tables\Partials\Exceptions\UnexpectedPercents;
use DrdPlus\Tables\Partials\Percents;

class HealingConditionsPercents extends Percents
{
    /**
     * @param int $value
     * @throws \DrdPlus\Tables\Body\Healing\Exceptions\UnexpectedHealingConditionsPercents
     */
    public function __construct($value)
    {
        try {
            parent::__construct($value);
        } catch (UnexpectedPercents $unexpectedPercents) {
            throw new Exceptions\UnexpectedHealingConditionsPercents($unexpectedPercents->getMessage());
        }
    }

}