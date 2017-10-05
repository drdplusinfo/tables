<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Measurements\Wounds;

use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementWithBonus;
use Granam\Integer\Tools\ToInteger;

class Wounds extends AbstractMeasurementWithBonus
{
    const WOUNDS = 'wounds';

    /**
     * @var WoundsTable
     */
    private $woundsTable;

    /**
     * @param \Granam\Integer\IntegerInterface|int $value
     * @param WoundsTable $woundsTable
     * @throws \Granam\Float\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    public function __construct($value, WoundsTable $woundsTable)
    {
        $this->woundsTable = $woundsTable;
        parent::__construct($value, self::WOUNDS);
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        // turning float to integer (without value lost)
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return ToInteger::toInteger(parent::getValue());
    }

    /**
     * @return array|string[]
     */
    public function getPossibleUnits(): array
    {
        return [self::WOUNDS];
    }

    /**
     * @return WoundsBonus
     */
    public function getBonus(): WoundsBonus
    {
        return $this->woundsTable->toBonus($this);
    }
}