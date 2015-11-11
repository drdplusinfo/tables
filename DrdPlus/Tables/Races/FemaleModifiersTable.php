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
        return [
            RacesTable::STRENGTH => $this->getValue([$race], RacesTable::STRENGTH),
            RacesTable::AGILITY => $this->getValue([$race], RacesTable::AGILITY),
            RacesTable::KNACK => $this->getValue([$race], RacesTable::KNACK),
            RacesTable::WILL => $this->getValue([$race], RacesTable::WILL),
            RacesTable::INTELLIGENCE => $this->getValue([$race], RacesTable::INTELLIGENCE),
            RacesTable::CHARISMA => $this->getValue([$race], RacesTable::CHARISMA),
        ];
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

}
