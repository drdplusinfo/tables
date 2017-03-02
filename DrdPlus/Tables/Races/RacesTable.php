<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Codes\GenderCode;
use DrdPlus\Codes\Properties\PropertyCode;
use DrdPlus\Codes\RaceCode;
use DrdPlus\Codes\SubRaceCode;
use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Measurements\Weight\WeightBonus;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use Granam\Tools\ValueDescriber;

/**
 * See PPH page 29 top, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_ras
 */
class RacesTable extends AbstractFileTable
{

    /** @return string
     */
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/races.csv';
    }

    /** @return array|string
     */
    protected function getExpectedDataHeaderNamesToTypes(): array
    {
        return [
            PropertyCode::STRENGTH => self::INTEGER,
            PropertyCode::AGILITY => self::INTEGER,
            PropertyCode::KNACK => self::INTEGER,
            PropertyCode::WILL => self::INTEGER,
            PropertyCode::INTELLIGENCE => self::INTEGER,
            PropertyCode::CHARISMA => self::INTEGER,
            PropertyCode::TOUGHNESS => self::INTEGER,
            PropertyCode::HEIGHT_IN_CM => self::FLOAT,
            PropertyCode::WEIGHT_IN_KG => self::FLOAT,
            PropertyCode::SIZE => self::INTEGER,
            PropertyCode::SENSES => self::INTEGER,
            PropertyCode::REMARKABLE_SENSE => self::STRING,
            PropertyCode::INFRAVISION => self::BOOLEAN,
            PropertyCode::NATIVE_REGENERATION => self::BOOLEAN,
            PropertyCode::REQUIRES_DM_AGREEMENT => self::BOOLEAN,
            PropertyCode::AGE => self::POSITIVE_INTEGER,
        ];
    }

    const RACE = 'race';
    const SUBRACE = 'subrace';

    /** @return array
     */
    protected function getRowsHeader(): array
    {
        return [self::RACE, self::SUBRACE];
    }

    /** @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getCommonHumanModifiers()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getRow([RaceCode::HUMAN, SubRaceCode::COMMON]);
    }

    /** @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getHighlanderModifiers()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getRow([RaceCode::HUMAN, SubRaceCode::HIGHLANDER]);
    }

    /** @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getCommonElfModifiers()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getRow([RaceCode::ELF, SubRaceCode::COMMON]);
    }

    /** @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getDarkElfModifiers()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getRow([RaceCode::ELF, SubRaceCode::DARK]);
    }

    /** @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getGreenElfModifiers()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getRow([RaceCode::ELF, SubRaceCode::GREEN]);
    }

    /** @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getCommonDwarfModifiers()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getRow([RaceCode::DWARF, SubRaceCode::COMMON]);
    }

    /** @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getMountainDwarfModifiers()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getRow([RaceCode::DWARF, SubRaceCode::MOUNTAIN]);
    }

    /** @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getWoodDwarfModifiers()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getRow([RaceCode::DWARF, SubRaceCode::WOOD]);
    }

    /** @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getCommonHobbitModifiers()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getRow([RaceCode::HOBBIT, SubRaceCode::COMMON]);
    }

    /** @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getCommonKrollModifiers()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getRow([RaceCode::KROLL, SubRaceCode::COMMON]);
    }

    /** @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getWildKrollModifiers()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getRow([RaceCode::KROLL, SubRaceCode::WILD]);
    }

    /** @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getCommonOrcModifiers()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getRow([RaceCode::ORC, SubRaceCode::COMMON]);
    }

    /** @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getGoblinModifiers()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getRow([RaceCode::ORC, SubRaceCode::GOBLIN]);
    }

    /** @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getSkurutModifiers()
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getRow([RaceCode::ORC, SubRaceCode::SKURUT]);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @return int
     */
    public function getMaleStrength(RaceCode $raceCode, SubRaceCode $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::STRENGTH);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     * @return int
     */
    public function getFemaleStrength(RaceCode $raceCode, SubRaceCode $subraceCode, FemaleModifiersTable $femaleModifiersTable)
    {
        return $this->getMaleStrength($raceCode, $subraceCode) + $femaleModifiersTable->getStrength($raceCode);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @param string $propertyName
     * @return int
     */
    private function getProperty(RaceCode $raceCode, SubRaceCode $subraceCode, $propertyName)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue([$raceCode, $subraceCode], $propertyName);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @return int
     */
    public function getMaleAgility(RaceCode $raceCode, SubRaceCode $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::AGILITY);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     * @return int
     */
    public function getFemaleAgility(RaceCode $raceCode, SubRaceCode $subraceCode, FemaleModifiersTable $femaleModifiersTable)
    {
        return $this->getMaleAgility($raceCode, $subraceCode) + $femaleModifiersTable->getAgility($raceCode);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @return int
     */
    public function getMaleKnack(RaceCode $raceCode, SubRaceCode $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::KNACK);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     * @return int
     */
    public function getFemaleKnack(RaceCode $raceCode, SubRaceCode $subraceCode, FemaleModifiersTable $femaleModifiersTable)
    {
        return $this->getMaleKnack($raceCode, $subraceCode) + $femaleModifiersTable->getKnack($raceCode);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @return int
     */
    public function getMaleWill(RaceCode $raceCode, SubRaceCode $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::WILL);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     * @return int
     */
    public function getFemaleWill(RaceCode $raceCode, SubRaceCode $subraceCode, FemaleModifiersTable $femaleModifiersTable)
    {
        return $this->getMaleWill($raceCode, $subraceCode) + $femaleModifiersTable->getWill($raceCode);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @return int
     */
    public function getMaleIntelligence(RaceCode $raceCode, SubRaceCode $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::INTELLIGENCE);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     * @return int
     */
    public function getFemaleIntelligence(RaceCode $raceCode, SubRaceCode $subraceCode, FemaleModifiersTable $femaleModifiersTable)
    {
        return $this->getMaleIntelligence($raceCode, $subraceCode) + $femaleModifiersTable->getIntelligence($raceCode);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @return int
     */
    public function getMaleCharisma(RaceCode $raceCode, SubRaceCode $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::CHARISMA);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     * @return int
     */
    public function getFemaleCharisma(RaceCode $raceCode, SubRaceCode $subraceCode, FemaleModifiersTable $femaleModifiersTable)
    {
        return $this->getMaleCharisma($raceCode, $subraceCode) + $femaleModifiersTable->getCharisma($raceCode);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @return int
     */
    public function getToughness(RaceCode $raceCode, SubRaceCode $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::TOUGHNESS);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @return float
     */
    public function getHeightInCm(RaceCode $raceCode, SubRaceCode $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::HEIGHT_IN_CM);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @param GenderCode $genderCode
     * @param FemaleModifiersTable $femaleModifiersTable
     * @param WeightTable $weightTable
     * @return float
     * @throws \DrdPlus\Tables\Races\Exceptions\UnknownGender
     */
    public function getWeightInKg(
        RaceCode $raceCode,
        SubRaceCode $subraceCode,
        GenderCode $genderCode,
        FemaleModifiersTable $femaleModifiersTable,
        WeightTable $weightTable
    )
    {
        switch ($genderCode) {
            case GenderCode::MALE :
                return $this->getMaleWeightInKg($raceCode, $subraceCode);
            case GenderCode::FEMALE :
                return $this->getFemaleWeightInKg($raceCode, $subraceCode, $femaleModifiersTable, $weightTable);
            default :
                throw new Exceptions\UnknownGender(
                    'Unknown gender ' . ValueDescriber::describe($genderCode)
                );
        }
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @return float
     */
    public function getMaleWeightInKg(RaceCode $raceCode, SubRaceCode $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::WEIGHT_IN_KG);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     * @param WeightTable $weightTable
     * @return float
     */
    public function getFemaleWeightInKg(
        $raceCode,
        $subraceCode,
        FemaleModifiersTable $femaleModifiersTable,
        WeightTable $weightTable
    )
    {
        $maleWeightValue = $this->getMaleWeightInKg($raceCode, $subraceCode);
        $maleWeightBonus = $weightTable->toBonus(new Weight($maleWeightValue, Weight::KG, $weightTable));
        $femaleWeightBonusModifier = $femaleModifiersTable->getWeightBonus($raceCode);
        $femaleWeightBonusValue = $maleWeightBonus->getValue() + $femaleWeightBonusModifier;
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $femaleWeightBonus = new WeightBonus($femaleWeightBonusValue, $weightTable);

        return $femaleWeightBonus->getWeight()->getValue();
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @return int
     */
    public function getMaleSize(RaceCode $raceCode, SubRaceCode $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::SIZE);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     * @return int
     */
    public function getFemaleSize(RaceCode $raceCode, SubRaceCode $subraceCode, FemaleModifiersTable $femaleModifiersTable)
    {
        return $this->getMaleSize($raceCode, $subraceCode) + $femaleModifiersTable->getSize($raceCode);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @param GenderCode $genderCode
     * @param FemaleModifiersTable $femaleModifiersTable
     * @return int
     * @throws \DrdPlus\Tables\Races\Exceptions\UnknownGender
     */
    public function getSize(RaceCode $raceCode, SubRaceCode $subraceCode, GenderCode $genderCode, FemaleModifiersTable $femaleModifiersTable)
    {
        switch ($genderCode) {
            case GenderCode::MALE :
                return $this->getMaleSize($raceCode, $subraceCode);
            case GenderCode::FEMALE :
                return $this->getFemaleSize($raceCode, $subraceCode, $femaleModifiersTable);
            default :
                throw new Exceptions\UnknownGender(
                    'Expected one of ' . GenderCode::MALE . ' or ' . GenderCode::FEMALE
                    . ', got ' . ValueDescriber::describe($genderCode)
                );
        }
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @return string
     */
    public function getRemarkableSense(RaceCode $raceCode, SubRaceCode $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::REMARKABLE_SENSE);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @return bool
     */
    public function hasInfravision(RaceCode $raceCode, SubRaceCode $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::INFRAVISION);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @return bool
     */
    public function hasNativeRegeneration(RaceCode $raceCode, SubRaceCode $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::NATIVE_REGENERATION);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @return int
     */
    public function getSenses(RaceCode $raceCode, SubRaceCode $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::SENSES);
    }

    /**
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @return bool
     */
    public function requiresDmAgreement(RaceCode $raceCode, SubRaceCode $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::REQUIRES_DM_AGREEMENT);
    }

    /**
     * Gives usual age of a race on his first great adventure - like 15 years for common human or 25 for hobbit.
     *
     * @param RaceCode $raceCode
     * @param SubraceCode $subraceCode
     * @return bool
     */
    public function getAge(RaceCode $raceCode, SubRaceCode $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::AGE);
    }
}