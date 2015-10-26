<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Properties\AbstractIntegerProperty;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;

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
    protected function getExpectedHorizontalHeader()
    {
        return [
            [
                RacesTable::STRENGTH,
                RacesTable::AGILITY,
                RacesTable::KNACK,
                RacesTable::WILL,
                RacesTable::INTELLIGENCE,
                RacesTable::CHARISMA
            ]
        ];
    }

    /**
     * @return array
     */
    protected function getExpectedVerticalHeader()
    {
        return [
            [RacesTable::RACE]
        ];
    }

    public function getHumanModifiers()
    {
        return $this->getRaceModifiers(RacesTable::HUMAN);
    }

    /**
     * @param string $race
     * @return array|AbstractIntegerProperty[]
     */
    private function getRaceModifiers($race)
    {
        return [
            RacesTable::STRENGTH => new Strength($this->getValue([$race], [RacesTable::STRENGTH])),
            RacesTable::AGILITY => new Agility($this->getValue([$race], [RacesTable::AGILITY])),
            RacesTable::KNACK => new Knack($this->getValue([$race], [RacesTable::KNACK])),
            RacesTable::WILL => new Will($this->getValue([$race], [RacesTable::WILL])),
            RacesTable::INTELLIGENCE => new Intelligence($this->getValue([$race], [RacesTable::INTELLIGENCE])),
            RacesTable::CHARISMA => new Charisma($this->getValue([$race], [RacesTable::CHARISMA])),
        ];
    }

    public function getElfModifiers()
    {
        return $this->getRaceModifiers(RacesTable::ELF);
    }

    public function getDwarfModifiers()
    {
        return $this->getRaceModifiers(RacesTable::DWARF);
    }

    public function getHobbitModifiers()
    {
        return $this->getRaceModifiers(RacesTable::HOBBIT);
    }

    public function getKrollModifiers()
    {
        return $this->getRaceModifiers(RacesTable::KROLL);
    }

    public function getOrcModifiers()
    {
        return $this->getRaceModifiers(RacesTable::ORC);
    }

}
