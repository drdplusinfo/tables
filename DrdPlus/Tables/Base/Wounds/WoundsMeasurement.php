<?php
namespace DrdPlus\Tables\Base\Wounds;

use DrdPlus\Tables\AbstractMeasurement;
use Granam\Integer\Tools\ToInteger;

class WoundsMeasurement extends AbstractMeasurement
{
    const WOUNDS = 'wounds';

    public function __construct($value, $unit = self::WOUNDS)
    {
        parent::__construct($value, $unit);
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return ToInteger::toInteger(parent::getValue());
    }

    /**
     * @return string[]
     */
    public function getPossibleUnits()
    {
        return [self::WOUNDS];
    }

}
