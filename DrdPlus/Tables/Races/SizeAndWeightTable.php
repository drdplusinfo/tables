<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Properties\Body\Size;

class SizeAndWeightTable extends AbstractTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/size_and_weight.csv';
    }

    const HEIGHT = 'Height';
    const WEIGHT = 'Weight';
    const SIZE = 'Size';

    /**
     * @return array|string
     */
    protected function getExpectedHorizontalHeader()
    {
        return [
            [
                self::HEIGHT,
                self::WEIGHT,
                self::SIZE,
            ]
        ];
    }

    /**
     * @return array
     */
    protected function getExpectedVerticalHeader()
    {
        return [
            [
                RacesTable::RACE,
                RacesTable::SUBRACE
            ]
        ];
    }

    public function getCommonHumanModifiers()
    {
        return $this->getHumanModifiers();
    }

    private function getHumanModifiers()
    {
        return $this->getRaceModifiers(RacesTable::HUMAN, '');
    }

    private function getRaceModifiers($race, $subrace)
    {
        return [
            // TODO height as standard property
            self::HEIGHT => $this->getValue([$race, $subrace], [self::HEIGHT]),
            // TODO weight as standard property
            self::WEIGHT => $this->getValue([$race, $subrace], [self::WEIGHT]),
            self::SIZE => new Size($this->getValue([$race, $subrace], [self::SIZE])),
        ];
    }

    public function getHighlanderModifiers()
    {
        return $this->getHumanModifiers();
    }

    public function getCommonDwarfModifier()
    {
        return $this->getDwarfModifiers();
    }

    private function getDwarfModifiers()
    {
        return $this->getRaceModifiers(RacesTable::DWARF, '');
    }

    public function getWoodDwarfModifier()
    {
        return $this->getDwarfModifiers();
    }

    public function getMountainDwarfModifier()
    {
        return $this->getDwarfModifiers();
    }

    public function getCommonElfModifiers()
    {
        return $this->getElfModifiers();
    }

    private function getElfModifiers()
    {
        return $this->getRaceModifiers(RacesTable::ELF, '');
    }

    public function getGreenElfModifiers()
    {
        return $this->getElfModifiers();
    }

    public function getDarkElfModifiers()
    {
        return $this->getElfModifiers();
    }

    public function getCommonHobbitModifiers()
    {
        return $this->getRaceModifiers(RacesTable::HOBBIT, '');
    }

    public function getCommonKrollModifier()
    {
        return $this->getKrollModifiers();
    }

    private function getKrollModifiers()
    {
        return $this->getRaceModifiers(RacesTable::KROLL, '');
    }

    public function getWildKrollModifier()
    {
        return $this->getKrollModifiers();
    }

    public function getCommonOrcModifiers()
    {
        return $this->getRaceModifiers(RacesTable::ORC, RacesTable::COMMON);
    }

    public function getGoblinModifiers()
    {
        return $this->getRaceModifiers(RacesTable::ORC, RacesTable::GOBLIN);
    }

    public function getSkurutModifiers()
    {
        return $this->getRaceModifiers(RacesTable::ORC, RacesTable::SKURUT);
    }

}
