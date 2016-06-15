<?php
namespace DrdPlus\Tables\Environments;

use Granam\Integer\IntegerInterface;
use Granam\Integer\Tools\ToInteger;
use Granam\Strict\Object\StrictObject;
use Granam\Tools\ValueDescriber;
use \Granam\Integer\Tools\Exceptions\Exception as ToIntegerException;

class TerrainDifficultyPercents extends StrictObject implements IntegerInterface
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param mixed $value
     * @throws \DrdPlus\Tables\Environments\Exceptions\UnexpectedDifficultyPercents
     */
    public function __construct($value)
    {
        try {
            $value = ToInteger::toInteger($value);
        } catch (ToIntegerException $toIntegerException) {
            throw new Exceptions\UnexpectedDifficultyPercents(
                'Invalid percent value ' . $toIntegerException->getMessage()
            );
        }
        if ($value < 0 || $value > 100) {
            throw new Exceptions\UnexpectedDifficultyPercents(
                'Percents can be from zero to one hundred, got ' . ValueDescriber::describe($value)
            );
        }
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return float
     */
    public function getRate()
    {
        return (float)$this->getValue() / 100;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getValue() . ' %';
    }

}