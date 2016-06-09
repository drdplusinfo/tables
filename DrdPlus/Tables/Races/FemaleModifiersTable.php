<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Codes\PropertyCodes;
use DrdPlus\Codes\RaceCodes;
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
            PropertyCodes::STRENGTH => self::INTEGER,
            PropertyCodes::AGILITY => self::INTEGER,
            PropertyCodes::KNACK => self::INTEGER,
            PropertyCodes::WILL => self::INTEGER,
            PropertyCodes::INTELLIGENCE => self::INTEGER,
            PropertyCodes::CHARISMA => self::INTEGER,
            PropertyCodes::WEIGHT => self::INTEGER,
            PropertyCodes::SIZE => self::INTEGER,
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
        return $this->getRaceModifiers(RaceCodes::HUMAN);
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
        return $this->getRaceModifiers(RaceCodes::ELF);
    }

    public function getDwarfModifiers()
    {
        return $this->getRaceModifiers(RaceCodes::DWARF);
    }

    public function getHobbitModifiers()
    {
        return $this->getRaceModifiers(RaceCodes::HOBBIT);
    }

    public function getKrollModifiers()
    {
        return $this->getRaceModifiers(RaceCodes::KROLL);
    }

    public function getOrcModifiers()
    {
        return $this->getRaceModifiers(RaceCodes::ORC);
    }

    /**
     * @param string $raceCode
     *
     * @return int
     */
    public function getStrength($raceCode)
    {
        return $this->getValue([$raceCode], PropertyCodes::STRENGTH);
    }

    /**
     * @param string $raceCode
     *
     * @return int
     */
    public function getAgility($raceCode)
    {
        return $this->getValue([$raceCode], PropertyCodes::AGILITY);
    }

    /**
     * @param string $raceCode
     *
     * @return int
     */
    public function getKnack($raceCode)
    {
        return $this->getValue([$raceCode], PropertyCodes::KNACK);
    }

    /**
     * @param string $raceCode
     *
     * @return int
     */
    public function getWill($raceCode)
    {
        return $this->getValue([$raceCode], PropertyCodes::WILL);
    }

    /**
     * @param string $raceCode
     *
     * @return int
     */
    public function getIntelligence($raceCode)
    {
        return $this->getValue([$raceCode], PropertyCodes::INTELLIGENCE);
    }

    /**
     * @param string $raceCode
     *
     * @return int
     */
    public function getCharisma($raceCode)
    {
        return $this->getValue([$raceCode], PropertyCodes::CHARISMA);
    }

    /**
     * @param $raceCode
     *
     * @return int
     */
    public function getWeightBonus($raceCode)
    {
        return $this->getValue([$raceCode], PropertyCodes::WEIGHT);
    }

    /**
     * @param $raceCode
     *
     * @return int
     */
    public function getSize($raceCode)
    {
        return $this->getValue([$raceCode], PropertyCodes::SIZE);
    }
}
