<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Races\Dwarfs\CommonDwarf;
use DrdPlus\Races\Dwarfs\Dwarf;
use DrdPlus\Races\Dwarfs\MountainDwarf;
use DrdPlus\Races\Dwarfs\WoodDwarf;
use DrdPlus\Races\Elfs\CommonElf;
use DrdPlus\Races\Elfs\DarkElf;
use DrdPlus\Races\Elfs\Elf;
use DrdPlus\Races\Elfs\GreenElf;
use DrdPlus\Races\Hobbits\CommonHobbit;
use DrdPlus\Races\Hobbits\Hobbit;
use DrdPlus\Races\Humans\CommonHuman;
use DrdPlus\Races\Humans\Highlander;
use DrdPlus\Races\Humans\Human;
use DrdPlus\Races\Krolls\CommonKroll;
use DrdPlus\Races\Krolls\Kroll;
use DrdPlus\Races\Krolls\WildKroll;
use DrdPlus\Races\Orcs\CommonOrc;
use DrdPlus\Races\Orcs\Goblin;
use DrdPlus\Races\Orcs\Orc;
use DrdPlus\Races\Orcs\Skurut;

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
    const TOUGHNESS = 'Toughness';
    const HEIGHT_IN_CM = 'Height in cm';
    const WEIGHT_IN_KG = 'Weight in kg';
    const SIZE = 'Size';
    const SENSES = 'Senses';
    const REMARKABLE_SENSE = 'Remarkable sense';
    const INFRAVISION = 'Infravision';
    const NATIVE_REGENERATION = 'Native regeneration';
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
            self::TOUGHNESS => self::INTEGER,
            self::HEIGHT_IN_CM => self::FLOAT,
            self::WEIGHT_IN_KG => self::FLOAT,
            self::SIZE => self::INTEGER,
            self::SENSES => self::INTEGER,
            self::REMARKABLE_SENSE => self::STRING,
            self::INFRAVISION => self::BOOLEAN,
            self::NATIVE_REGENERATION => self::BOOLEAN,
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

    public function getCommonHumanModifiers()
    {
        return $this->getRow([Human::HUMAN, CommonHuman::COMMON]);
    }

    public function getHighlanderModifiers()
    {
        return $this->getRow([Human::HUMAN, Highlander::HIGHLANDER]);
    }

    public function getCommonElfModifiers()
    {
        return $this->getRow([Elf::ELF, CommonElf::COMMON]);
    }

    public function getDarkElfModifiers()
    {
        return $this->getRow([Elf::ELF, DarkElf::DARK]);
    }

    public function getGreenElfModifiers()
    {
        return $this->getRow([Elf::ELF, GreenElf::GREEN]);
    }

    public function getCommonDwarfModifiers()
    {
        return $this->getRow([Dwarf::DWARF, CommonDwarf::COMMON]);
    }

    public function getMountainDwarfModifiers()
    {
        return $this->getRow([Dwarf::DWARF, MountainDwarf::MOUNTAIN]);
    }

    public function getWoodDwarfModifiers()
    {
        return $this->getRow([Dwarf::DWARF, WoodDwarf::WOOD]);
    }

    public function getCommonHobbitModifiers()
    {
        return $this->getRow([Hobbit::HOBBIT, CommonHobbit::COMMON]);
    }

    public function getCommonKrollModifiers()
    {
        return $this->getRow([Kroll::KROLL, CommonKroll::COMMON]);
    }

    public function getWildKrollModifiers()
    {
        return $this->getRow([Kroll::KROLL, WildKroll::WILD]);
    }

    public function getCommonOrcModifiers()
    {
        return $this->getRow([Orc::ORC, CommonOrc::COMMON]);
    }

    public function getGoblinModifiers()
    {
        return $this->getRow([Orc::ORC, Goblin::GOBLIN]);
    }

    public function getSkurutModifiers()
    {
        return $this->getRow([Orc::ORC, Skurut::SKURUT]);
    }

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

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     */
    public function getToughness($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, self::TOUGHNESS);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return float
     */
    public function getHeightInCm($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, self::HEIGHT_IN_CM);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return float
     */
    public function getWeightInKg($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, self::WEIGHT_IN_KG);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     */
    public function getSize($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, self::SIZE);
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
        return $this->getProperty($raceCode, $subraceCode, self::INFRAVISION);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return bool
     */
    public function hasNativeRegeneration($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, self::NATIVE_REGENERATION);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     */
    public function getSenses($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, self::SENSES);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return bool
     */
    public function requiresDmAgreement($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, self::REQUIRES_DM_AGREEMENT);
    }
}
