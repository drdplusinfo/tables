<?php
namespace DrdPlus\Tables\Experiences;

use DrdPlus\Tables\Parts\AbstractMeasurementWithBonus;
use Granam\Integer\Tools\ToInteger;

abstract class AbstractExperiencesMeasurement extends AbstractMeasurementWithBonus
{
    /**
     * @param mixed $value
     * @return int
     */
    protected function normalizeValue($value)
    {
        return ToInteger::toInteger($value);
    }

}
