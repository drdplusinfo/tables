<?php
namespace DrdPlus\Tables\Experiences;

use DrdPlus\Tables\AbstractMeasurement;
use Granam\Integer\Tools\ToInteger;

abstract class AbstractExperiencesMeasurement extends AbstractMeasurement
{

    /**
     * @return int
     */
    abstract public function toLevel();

    /**
     * @return int
     */
    abstract public function toExperiences();

    /**
     * @return int
     */
    public function getValue()
    {
        return ToInteger::toInteger(parent::getValue());
    }
}
