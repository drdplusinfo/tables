<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Races\Dwarfs\Dwarf;
use DrdPlus\Races\Elfs\Elf;
use DrdPlus\Races\Hobbits\Hobbit;
use DrdPlus\Races\Humans\Human;
use DrdPlus\Races\Krolls\Kroll;
use DrdPlus\Races\Orcs\Orc;

class FemaleModifiersTable extends AbstractTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/female_modifiers.csv';
    }

    /**
     * @return array|string
     */
    protected function getExpectedColumnsHeader()
    {
        return [
            RacesTable::STRENGTH => self::INTEGER,
            RacesTable::AGILITY => self::INTEGER,
            RacesTable::KNACK => self::INTEGER,
            RacesTable::WILL => self::INTEGER,
            RacesTable::INTELLIGENCE => self::INTEGER,
            RacesTable::CHARISMA => self::INTEGER,
        ];
    }

    /**
     * @return array
     */
    protected function getExpectedRowsHeader()
    {
        return [RacesTable::RACE];
    }

    public function getHumanModifiers()
    {
        return $this->getRaceModifiers(Human::HUMAN);
    }

    /**
     * @param string $race
     *
     * @return array|int[]
     */
    private function getRaceModifiers($race)
    {
        return $this->getRow([$race]);
    }

    public function getElfModifiers()
    {
        return $this->getRaceModifiers(Elf::ELF);
    }

    public function getDwarfModifiers()
    {
        return $this->getRaceModifiers(Dwarf::DWARF);
    }

    public function getHobbitModifiers()
    {
        return $this->getRaceModifiers(Hobbit::HOBBIT);
    }

    public function getKrollModifiers()
    {
        return $this->getRaceModifiers(Kroll::KROLL);
    }

    public function getOrcModifiers()
    {
        return $this->getRaceModifiers(Orc::ORC);
    }

    /**
     * @param string $raceCode
     *
     * @return int
     */
    public function getStrength($raceCode)
    {
        return $this->getValue([$raceCode], RacesTable::STRENGTH);
    }

    /**
     * @param string $raceCode
     *
     * @return int
     */
    public function getAgility($raceCode)
    {
        return $this->getValue([$raceCode], RacesTable::AGILITY);
    }

    /**
     * @param string $raceCode
     *
     * @return int
     */
    public function getKnack($raceCode)
    {
        return $this->getValue([$raceCode], RacesTable::KNACK);
    }

    /**
     * @param string $raceCode
     *
     * @return int
     */
    public function getWill($raceCode)
    {
        return $this->getValue([$raceCode], RacesTable::WILL);
    }

    /**
     * @param string $raceCode
     *
     * @return int
     */
    public function getIntelligence($raceCode)
    {
        return $this->getValue([$raceCode], RacesTable::INTELLIGENCE);
    }

    /**
     * @param string $raceCode
     *
     * @return int
     */
    public function getCharisma($raceCode)
    {
        return $this->getValue([$raceCode], RacesTable::CHARISMA);
    }
}
