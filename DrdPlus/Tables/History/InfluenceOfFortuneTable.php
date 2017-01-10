<?php
namespace DrdPlus\Tables\History;

use DrdPlus\Codes\FateCode;
use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound;
use Granam\Integer\IntegerInterface;
use Granam\Integer\Tools\ToInteger;
use Granam\Tools\ValueDescriber;

class InfluenceOfFortuneTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/influence_of_fortune.csv';
    }

    const PRIMARY_PROPERTY_ON_1 = 'primary_property_on_1';
    const SECONDARY_PROPERTY_ON_1 = 'secondary_property_on_1';
    const PRIMARY_PROPERTY_ON_2 = 'primary_property_on_2';
    const SECONDARY_PROPERTY_ON_2 = 'secondary_property_on_2';
    const PRIMARY_PROPERTY_ON_3 = 'primary_property_on_3';
    const SECONDARY_PROPERTY_ON_3 = 'secondary_property_on_3';
    const PRIMARY_PROPERTY_ON_4 = 'primary_property_on_4';
    const SECONDARY_PROPERTY_ON_4 = 'secondary_property_on_4';
    const PRIMARY_PROPERTY_ON_5 = 'primary_property_on_5';
    const SECONDARY_PROPERTY_ON_5 = 'secondary_property_on_5';
    const PRIMARY_PROPERTY_ON_6 = 'primary_property_on_6';
    const SECONDARY_PROPERTY_ON_6 = 'secondary_property_on_6';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::PRIMARY_PROPERTY_ON_1 => self::POSITIVE_INTEGER,
            self::SECONDARY_PROPERTY_ON_1 => self::POSITIVE_INTEGER,
            self::PRIMARY_PROPERTY_ON_2 => self::POSITIVE_INTEGER,
            self::SECONDARY_PROPERTY_ON_2 => self::POSITIVE_INTEGER,
            self::PRIMARY_PROPERTY_ON_3 => self::POSITIVE_INTEGER,
            self::SECONDARY_PROPERTY_ON_3 => self::POSITIVE_INTEGER,
            self::PRIMARY_PROPERTY_ON_4 => self::POSITIVE_INTEGER,
            self::SECONDARY_PROPERTY_ON_4 => self::POSITIVE_INTEGER,
            self::PRIMARY_PROPERTY_ON_5 => self::POSITIVE_INTEGER,
            self::SECONDARY_PROPERTY_ON_5 => self::POSITIVE_INTEGER,
            self::PRIMARY_PROPERTY_ON_6 => self::POSITIVE_INTEGER,
            self::SECONDARY_PROPERTY_ON_6 => self::POSITIVE_INTEGER,
        ];
    }

    const FATE = 'fate';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [self::FATE];
    }

    /**
     * @param FateCode $fateCode
     * @param int $diceRoll
     * @return int
     * @throws \DrdPlus\Tables\History\Exceptions\UnexpectedDiceRoll
     */
    public function getPrimaryPropertyOnFate(FateCode $fateCode, $diceRoll)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->getValue($fateCode, 'primary_property_on_' . ToInteger::toPositiveInteger($diceRoll));
        } catch (RequiredColumnNotFound $requiredColumnNotFound) {
            throw new Exceptions\UnexpectedDiceRoll('Expected roll from 1 to 6, got ' . ValueDescriber::describe($diceRoll));
        }
    }

    /**
     * @param FateCode $fateCode
     * @param int|IntegerInterface $diceRoll
     * @return int
     * @throws \DrdPlus\Tables\History\Exceptions\UnexpectedDiceRoll
     */
    public function getSecondaryPropertyOnFate(FateCode $fateCode, $diceRoll)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->getValue($fateCode, 'secondary_property_on_' . ToInteger::toPositiveInteger($diceRoll));
        } catch (RequiredColumnNotFound $requiredColumnNotFound) {
            throw new Exceptions\UnexpectedDiceRoll('Expected roll from 1 to 6, got ' . ValueDescriber::describe($diceRoll));
        }
    }

}