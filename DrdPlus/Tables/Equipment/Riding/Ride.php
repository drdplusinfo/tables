<?php
namespace DrdPlus\Tables\Equipment\Riding;

use Granam\Integer\IntegerInterface;
use Granam\Integer\Tools\ToInteger;
use Granam\Strict\Object\StrictObject;
use \Granam\Integer\Tools\Exceptions\Exception as ToIntegerException;

class Ride extends StrictObject implements IntegerInterface
{
    private $rideValue;

    /**
     * @param int $rideValue
     * @throws \DrdPlus\Tables\Equipment\Riding\Exceptions\InvalidRideValue
     * @throws \Granam\Integer\Exceptions\PositiveIntegerCanNotBeNegative
     */
    public function __construct($rideValue)
    {
        try {
            $this->rideValue = ToInteger::toInteger($rideValue);
        } catch (ToIntegerException $toIntegerException) {
            throw new Exceptions\InvalidRideValue($toIntegerException->getMessage());
        }
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->rideValue;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->rideValue;
    }

}