<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Codes\PropertyCode;
use DrdPlus\Codes\RaceCode;
use DrdPlus\Tables\Partials\AbstractFileTable;

class FemaleModifiersTable extends AbstractFileTable
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
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            PropertyCode::STRENGTH => self::INTEGER,
            PropertyCode::AGILITY => self::INTEGER,
            PropertyCode::KNACK => self::INTEGER,
            PropertyCode::WILL => self::INTEGER,
            PropertyCode::INTELLIGENCE => self::INTEGER,
            PropertyCode::CHARISMA => self::INTEGER,
            PropertyCode::WEIGHT => self::INTEGER,
            PropertyCode::SIZE => self::INTEGER,
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
        return $this->getRaceModifiers(RaceCode::HUMAN);
    }

    /**
     * @param string $race
     * @return array|int[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    private function getRaceModifiers($race)
    {
        return $this->getRow([$race]);
    }

    public function getElfModifiers()
    {
        return $this->getRaceModifiers(RaceCode::ELF);
    }

    public function getDwarfModifiers()
    {
        return $this->getRaceModifiers(RaceCode::DWARF);
    }

    public function getHobbitModifiers()
    {
        return $this->getRaceModifiers(RaceCode::HOBBIT);
    }

    public function getKrollModifiers()
    {
        return $this->getRaceModifiers(RaceCode::KROLL);
    }

    public function getOrcModifiers()
    {
        return $this->getRaceModifiers(RaceCode::ORC);
    }

    /**
     * @param string $raceCode
     *
     * @return int
     */
    public function getStrength($raceCode)
    {
        return $this->getValue([$raceCode], PropertyCode::STRENGTH);
    }

    /**
     * @param string $raceCode
     *
     * @return int
     */
    public function getAgility($raceCode)
    {
        return $this->getValue([$raceCode], PropertyCode::AGILITY);
    }

    /**
     * @param string $raceCode
     *
     * @return int
     */
    public function getKnack($raceCode)
    {
        return $this->getValue([$raceCode], PropertyCode::KNACK);
    }

    /**
     * @param string $raceCode
     *
     * @return int
     */
    public function getWill($raceCode)
    {
        return $this->getValue([$raceCode], PropertyCode::WILL);
    }

    /**
     * @param string $raceCode
     *
     * @return int
     */
    public function getIntelligence($raceCode)
    {
        return $this->getValue([$raceCode], PropertyCode::INTELLIGENCE);
    }

    /**
     * @param string $raceCode
     *
     * @return int
     */
    public function getCharisma($raceCode)
    {
        return $this->getValue([$raceCode], PropertyCode::CHARISMA);
    }

    /**
     * @param $raceCode
     *
     * @return int
     */
    public function getWeightBonus($raceCode)
    {
        return $this->getValue([$raceCode], PropertyCode::WEIGHT);
    }

    /**
     * @param $raceCode
     *
     * @return int
     */
    public function getSize($raceCode)
    {
        return $this->getValue([$raceCode], PropertyCode::SIZE);
    }
}
