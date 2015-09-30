<?php
namespace DrdPlus\Tables\Parts;

use Granam\Integer\IntegerInterface;
use Granam\Integer\Tools\ToInteger;
use Granam\Strict\Object\StrictObject;

abstract class AbstractBonus extends StrictObject implements IntegerInterface
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param int $value
     */
    protected function __construct($value)
    {
        try {
            $this->value = ToInteger::toInteger($value);
        } catch (\Granam\Integer\Tools\Exceptions\WrongParameterType $exception) {
            throw new Exceptions\BonusRequiresInteger(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getValue();
    }

}
