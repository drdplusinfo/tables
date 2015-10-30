<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use DrdPlus\Properties\Derived\Endurance;
use DrdPlus\Properties\Derived\Senses;
use DrdPlus\Properties\Native\Infravision;
use DrdPlus\Properties\Native\NativeRegeneration;

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
    protected function getExpectedHorizontalHeader()
    {
        return [
            [
                self::STRENGTH,
                self::AGILITY,
                self::KNACK,
                self::WILL,
                self::INTELLIGENCE,
                self::CHARISMA,
                self::ENDURANCE,
                self::INFRAVISION,
                self::NATIVE_REGENERATION,
                self::SENSES,
                self::REQUIRES_DM_AGREEMENT,
            ]
        ];
    }

    const RACE = 'Race';

    /**
     * @return array
     */
    protected function getExpectedVerticalHeader()
    {
        return [
            [
                self::RACE,
                self::SUBRACE
            ]
        ];
    }

    const HUMAN = 'Human';
    const COMMON = 'Common';

    public function getCommonHumanModifiers()
    {
        return $this->getRaceModifiers(self::HUMAN, self::COMMON);
    }

    private function getRaceModifiers($race, $subrace)
    {
        return [
            self::STRENGTH => Strength::getIt($this->getValue([$race, $subrace], [self::STRENGTH])),
            self::AGILITY => Agility::getIt($this->getValue([$race, $subrace], [self::AGILITY])),
            self::KNACK => Knack::getIt($this->getValue([$race, $subrace], [self::KNACK])),
            self::WILL => Will::getIt($this->getValue([$race, $subrace], [self::WILL])),
            self::INTELLIGENCE => Intelligence::getIt($this->getValue([$race, $subrace], [self::INTELLIGENCE])),
            self::CHARISMA => Charisma::getIt($this->getValue([$race, $subrace], [self::CHARISMA])),
            self::ENDURANCE => Endurance::getIt($this->getValue([$race, $subrace], [self::ENDURANCE])),
            self::INFRAVISION => Infravision::getIt($this->getValue([$race, $subrace], [self::INFRAVISION])),
            self::NATIVE_REGENERATION => NativeRegeneration::getIt($this->getValue([$race, $subrace], [self::NATIVE_REGENERATION])),
            self::SENSES => Senses::getIt($this->getValue([$race, $subrace], [self::SENSES])),
            // TODO provide RequiresDmAgreement as a local boolean enum property
            self::REQUIRES_DM_AGREEMENT => $this->getValue([$race, $subrace], [self::REQUIRES_DM_AGREEMENT]),
        ];
    }

    const HIGHLANDER = 'Highlander';

    public function getHighlanderModifiers()
    {
        return $this->getRaceModifiers(self::HUMAN, self::HIGHLANDER);
    }

    const ELF = 'Elf';

    public function getCommonElfModifiers()
    {
        return $this->getRaceModifiers(self::ELF, self::COMMON);
    }

    const DARK = 'Dark';

    public function getDarkElfModifiers()
    {
        return $this->getRaceModifiers(self::ELF, self::DARK);
    }

    const GREEN = 'Green';

    public function getGreenElfModifiers()
    {
        return $this->getRaceModifiers(self::ELF, self::GREEN);
    }

    const DWARF = 'Dwarf';

    public function getCommonDwarfModifiers()
    {
        return $this->getRaceModifiers(self::DWARF, self::COMMON);
    }

    const MOUNTAIN = 'Mountain';

    public function getMountainDwarfModifiers()
    {
        return $this->getRaceModifiers(self::DWARF, self::MOUNTAIN);
    }

    const WOOD = 'Wood';

    public function getWoodDwarfModifiers()
    {
        return $this->getRaceModifiers(self::DWARF, self::WOOD);
    }

    const HOBBIT = 'Hobbit';

    public function getCommonHobbitModifiers()
    {
        return $this->getRaceModifiers(self::HOBBIT, self::COMMON);
    }

    const KROLL = 'Kroll';

    public function getCommonKrollModifiers()
    {
        return $this->getRaceModifiers(self::KROLL, self::COMMON);
    }

    const WILD = 'Wild';

    public function getWildKrollModifiers()
    {
        return $this->getRaceModifiers(self::KROLL, self::WILD);
    }

    const ORC = 'Orc';

    public function getCommonOrcModifiers()
    {
        return $this->getRaceModifiers(self::ORC, self::COMMON);
    }

    const GOBLIN = 'Goblin';

    public function getGoblinModifiers()
    {
        return $this->getRaceModifiers(self::ORC, self::GOBLIN);
    }

    const SKURUT = 'Skurut';

    public function getSkurutModifiers()
    {
        return $this->getRaceModifiers(self::ORC, self::SKURUT);
    }

}
