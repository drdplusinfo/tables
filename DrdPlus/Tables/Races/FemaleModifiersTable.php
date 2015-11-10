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
    protected function getExpectedVerticalHeader()
    {
        return [RacesTable::RACE];
    }

    public function getHumanModifiers()
    {
        return $this->getRaceModifiers(RacesTable::HUMAN);
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
