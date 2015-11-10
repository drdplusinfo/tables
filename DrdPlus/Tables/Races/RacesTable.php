<?php
namespace DrdPlus\Tables\Races;

class RacesTable extends AbstractTable
{

    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/races.csv';
    }

    const SUBRACE = 'Subrace';
    const STRENGTH = 'Strength';
    const AGILITY = 'Agility';
    const KNACK = 'Knack';
    const WILL = 'Will';
    const INTELLIGENCE = 'Intelligence';
    const CHARISMA = 'Charisma';
    const ENDURANCE = 'Endurance';
    const INFRAVISION = 'Infravision';
    const NATIVE_REGENERATION = 'Native regeneration';
    const SENSES = 'Senses';
    const REQUIRES_DM_AGREEMENT = 'Requires DM agreement';

    /**
     * @return array|string
     */
    protected function getExpectedColumnsHeader()
    {
        return [
            self::STRENGTH => self::INTEGER,
            self::AGILITY => self::INTEGER,
            self::KNACK => self::INTEGER,
            self::WILL => self::INTEGER,
            self::INTELLIGENCE => self::INTEGER,
            self::CHARISMA => self::INTEGER,
            self::ENDURANCE => self::INTEGER,
            self::INFRAVISION => self::BOOLEAN,
            self::NATIVE_REGENERATION => self::BOOLEAN,
            self::SENSES => self::INTEGER,
            self::REQUIRES_DM_AGREEMENT => self::BOOLEAN,
        ];
    }

    const RACE = 'Race';

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

    const HUMAN = 'Human';
    const COMMON = 'Common';

    public function getCommonHumanModifiers()
    {
        return $this->getRow([self::HUMAN, self::COMMON]);
    }

    const HIGHLANDER = 'Highlander';

    public function getHighlanderModifiers()
    {
        return $this->getRow([self::HUMAN, self::HIGHLANDER]);
    }

    const ELF = 'Elf';

    public function getCommonElfModifiers()
    {
        return $this->getRow([self::ELF, self::COMMON]);
    }

    const DARK = 'Dark';

    public function getDarkElfModifiers()
    {
        return $this->getRow([self::ELF, self::DARK]);
    }

    const GREEN = 'Green';

    public function getGreenElfModifiers()
    {
        return $this->getRow([self::ELF, self::GREEN]);
    }

    const DWARF = 'Dwarf';

    public function getCommonDwarfModifiers()
    {
        return $this->getRow([self::DWARF, self::COMMON]);
    }

    const MOUNTAIN = 'Mountain';

    public function getMountainDwarfModifiers()
    {
        return $this->getRow([self::DWARF, self::MOUNTAIN]);
    }

    const WOOD = 'Wood';

    public function getWoodDwarfModifiers()
    {
        return $this->getRow([self::DWARF, self::WOOD]);
    }

    const HOBBIT = 'Hobbit';

    public function getCommonHobbitModifiers()
    {
        return $this->getRow([self::HOBBIT, self::COMMON]);
    }

    const KROLL = 'Kroll';

    public function getCommonKrollModifiers()
    {
        return $this->getRow([self::KROLL, self::COMMON]);
    }

    const WILD = 'Wild';

    public function getWildKrollModifiers()
    {
        return $this->getRow([self::KROLL, self::WILD]);
    }

    const ORC = 'Orc';

    public function getCommonOrcModifiers()
    {
        return $this->getRow([self::ORC, self::COMMON]);
    }

    const GOBLIN = 'Goblin';

    public function getGoblinModifiers()
    {
        return $this->getRow([self::ORC, self::GOBLIN]);
    }

    const SKURUT = 'Skurut';

    public function getSkurutModifiers()
    {
        return $this->getRow([self::ORC, self::SKURUT]);
    }

    // TODO missing tests for explicit property getters

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     */
    public function getStrength($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, self::STRENGTH);
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
        return $this->getValue([$raceCode, $subraceCode], [$propertyName]);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     */
    public function getAgility($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, self::AGILITY);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     */
    public function getKnack($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, self::KNACK);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     */
    public function getWill($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, self::WILL);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     */
    public function getIntelligence($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, self::INTELLIGENCE);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     */
    public function getCharisma($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, self::CHARISMA);
    }
}
