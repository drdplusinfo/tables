<?php
namespace DrdPlus\Tables\Races;

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

    private function getRaceModifiers($race)
    {
        return [
            RacesTable::STRENGTH => $this->getValue([$race], [RacesTable::STRENGTH]),
            RacesTable::AGILITY => $this->getValue([$race], [RacesTable::AGILITY]),
            RacesTable::KNACK => $this->getValue([$race], [RacesTable::KNACK]),
            RacesTable::WILL => $this->getValue([$race], [RacesTable::WILL]),
            RacesTable::INTELLIGENCE => $this->getValue([$race], [RacesTable::INTELLIGENCE]),
            RacesTable::CHARISMA => $this->getValue([$race], [RacesTable::CHARISMA]),
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
