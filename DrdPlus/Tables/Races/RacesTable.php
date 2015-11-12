<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Codes\PropertyCodes;
use DrdPlus\Codes\RaceCodes;

class RacesTable extends AbstractTable
{

    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/races.csv';
    }

    const REMARKABLE_SENSE = 'remarkable_sense';

    /**
     * @return array|string
     */
    protected function getExpectedColumnsHeader()
    {
        return [
            PropertyCodes::STRENGTH => self::INTEGER,
            PropertyCodes::AGILITY => self::INTEGER,
            PropertyCodes::KNACK => self::INTEGER,
            PropertyCodes::WILL => self::INTEGER,
            PropertyCodes::INTELLIGENCE => self::INTEGER,
            PropertyCodes::CHARISMA => self::INTEGER,
            PropertyCodes::TOUGHNESS => self::INTEGER,
            PropertyCodes::HEIGHT_IN_CM => self::FLOAT,
            PropertyCodes::WEIGHT_IN_KG => self::FLOAT,
            PropertyCodes::SIZE => self::INTEGER,
            PropertyCodes::SENSES => self::INTEGER,
            self::REMARKABLE_SENSE => self::STRING,
            PropertyCodes::INFRAVISION => self::BOOLEAN,
            PropertyCodes::NATIVE_REGENERATION => self::BOOLEAN,
            PropertyCodes::REQUIRES_DM_AGREEMENT => self::BOOLEAN,
        ];
    }

    const RACE = 'race';
    const SUBRACE = 'subrace';

    /**
     * @return array
     */
    protected function getExpectedRowsHeader()
    {
        return [
            self::RACE,
            self::SUBRACE
        ];
    }

    public function getCommonHumanModifiers()
    {
        return $this->getRow([RaceCodes::HUMAN, RaceCodes::COMMON]);
    }

    public function getHighlanderModifiers()
    {
        return $this->getRow([RaceCodes::HUMAN, RaceCodes::HIGHLANDER]);
    }

    public function getCommonElfModifiers()
    {
        return $this->getRow([RaceCodes::ELF, RaceCodes::COMMON]);
    }

    public function getDarkElfModifiers()
    {
        return $this->getRow([RaceCodes::ELF, RaceCodes::DARK]);
    }

    public function getGreenElfModifiers()
    {
        return $this->getRow([RaceCodes::ELF, RaceCodes::GREEN]);
    }

    public function getCommonDwarfModifiers()
    {
        return $this->getRow([RaceCodes::DWARF, RaceCodes::COMMON]);
    }

    public function getMountainDwarfModifiers()
    {
        return $this->getRow([RaceCodes::DWARF, RaceCodes::MOUNTAIN]);
    }

    public function getWoodDwarfModifiers()
    {
        return $this->getRow([RaceCodes::DWARF, RaceCodes::WOOD]);
    }

    public function getCommonHobbitModifiers()
    {
        return $this->getRow([RaceCodes::HOBBIT, RaceCodes::COMMON]);
    }

    public function getCommonKrollModifiers()
    {
        return $this->getRow([RaceCodes::KROLL, RaceCodes::COMMON]);
    }

    public function getWildKrollModifiers()
    {
        return $this->getRow([RaceCodes::KROLL, RaceCodes::WILD]);
    }

    public function getCommonOrcModifiers()
    {
        return $this->getRow([RaceCodes::ORC, RaceCodes::COMMON]);
    }

    public function getGoblinModifiers()
    {
        return $this->getRow([RaceCodes::ORC, RaceCodes::GOBLIN]);
    }

    public function getSkurutModifiers()
    {
        return $this->getRow([RaceCodes::ORC, RaceCodes::SKURUT]);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     */
    public function getStrength($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::STRENGTH);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param $propertyName
     *
     * @return int
     */
    private function getProperty($raceCode, $subraceCode, $propertyName)
    {
        return $this->getValue([$raceCode, $subraceCode], $propertyName);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     */
    public function getAgility($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::AGILITY);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     */
    public function getKnack($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::KNACK);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     */
    public function getWill($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::WILL);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     */
    public function getIntelligence($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::INTELLIGENCE);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     */
    public function getCharisma($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::CHARISMA);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     */
    public function getToughness($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::TOUGHNESS);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return float
     */
    public function getHeightInCm($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::HEIGHT_IN_CM);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return float
     */
    public function getWeightInKg($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::WEIGHT_IN_KG);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     */
    public function getSize($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::SIZE);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return string
     */
    public function getRemarkableSense($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, self::REMARKABLE_SENSE);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return bool
     */
    public function hasInfravision($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::INFRAVISION);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return bool
     */
    public function hasNativeRegeneration($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::NATIVE_REGENERATION);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     */
    public function getSenses($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::SENSES);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return bool
     */
    public function requiresDmAgreement($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::REQUIRES_DM_AGREEMENT);
    }
}
