<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Codes\GenderCode;
use DrdPlus\Codes\PropertyCode;
use DrdPlus\Codes\RaceCode;
use DrdPlus\Codes\SubRaceCode;
use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Measurements\Weight\WeightBonus;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use Granam\Tools\ValueDescriber;

class RacesTable extends AbstractFileTable
{

    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/races.csv';
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
            PropertyCode::TOUGHNESS => self::INTEGER,
            PropertyCode::HEIGHT_IN_CM => self::FLOAT,
            PropertyCode::WEIGHT_IN_KG => self::FLOAT,
            PropertyCode::SIZE => self::INTEGER,
            PropertyCode::SENSES => self::INTEGER,
            PropertyCode::REMARKABLE_SENSE => self::STRING,
            PropertyCode::INFRAVISION => self::BOOLEAN,
            PropertyCode::NATIVE_REGENERATION => self::BOOLEAN,
            PropertyCode::REQUIRES_DM_AGREEMENT => self::BOOLEAN,
        ];
    }

    const RACE = 'race';
    const SUBRACE = 'subrace';

    /**
     * @return array
     */
    protected function getRowsHeader()
    {
        return [
            self::RACE,
            self::SUBRACE
        ];
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getCommonHumanModifiers()
    {
        return $this->getRow([RaceCode::HUMAN, SubRaceCode::COMMON]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getHighlanderModifiers()
    {
        return $this->getRow([RaceCode::HUMAN, SubRaceCode::HIGHLANDER]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getCommonElfModifiers()
    {
        return $this->getRow([RaceCode::ELF, SubRaceCode::COMMON]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getDarkElfModifiers()
    {
        return $this->getRow([RaceCode::ELF, SubRaceCode::DARK]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getGreenElfModifiers()
    {
        return $this->getRow([RaceCode::ELF, SubRaceCode::GREEN]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getCommonDwarfModifiers()
    {
        return $this->getRow([RaceCode::DWARF, SubRaceCode::COMMON]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getMountainDwarfModifiers()
    {
        return $this->getRow([RaceCode::DWARF, SubRaceCode::MOUNTAIN]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getWoodDwarfModifiers()
    {
        return $this->getRow([RaceCode::DWARF, SubRaceCode::WOOD]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getCommonHobbitModifiers()
    {
        return $this->getRow([RaceCode::HOBBIT, SubRaceCode::COMMON]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getCommonKrollModifiers()
    {
        return $this->getRow([RaceCode::KROLL, SubRaceCode::COMMON]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getWildKrollModifiers()
    {
        return $this->getRow([RaceCode::KROLL, SubRaceCode::WILD]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getCommonOrcModifiers()
    {
        return $this->getRow([RaceCode::ORC, SubRaceCode::COMMON]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getGoblinModifiers()
    {
        return $this->getRow([RaceCode::ORC, SubRaceCode::GOBLIN]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getSkurutModifiers()
    {
        return $this->getRow([RaceCode::ORC, SubRaceCode::SKURUT]);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getMaleStrength($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::STRENGTH);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getFemaleStrength($raceCode, $subraceCode, FemaleModifiersTable $femaleModifiersTable)
    {
        return $this->getMaleStrength($raceCode, $subraceCode) + $femaleModifiersTable->getStrength($raceCode);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param $propertyName
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    private function getProperty($raceCode, $subraceCode, $propertyName)
    {
        return $this->getValue([$raceCode, $subraceCode], $propertyName);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getMaleAgility($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::AGILITY);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getFemaleAgility($raceCode, $subraceCode, FemaleModifiersTable $femaleModifiersTable)
    {
        return $this->getMaleAgility($raceCode, $subraceCode) + $femaleModifiersTable->getAgility($raceCode);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getMaleKnack($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::KNACK);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getFemaleKnack($raceCode, $subraceCode, FemaleModifiersTable $femaleModifiersTable)
    {
        return $this->getMaleKnack($raceCode, $subraceCode) + $femaleModifiersTable->getKnack($raceCode);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getMaleWill($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::WILL);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getFemaleWill($raceCode, $subraceCode, FemaleModifiersTable $femaleModifiersTable)
    {
        return $this->getMaleWill($raceCode, $subraceCode) + $femaleModifiersTable->getWill($raceCode);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getMaleIntelligence($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::INTELLIGENCE);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getFemaleIntelligence($raceCode, $subraceCode, FemaleModifiersTable $femaleModifiersTable)
    {
        return $this->getMaleIntelligence($raceCode, $subraceCode) + $femaleModifiersTable->getIntelligence($raceCode);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getMaleCharisma($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::CHARISMA);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getFemaleCharisma($raceCode, $subraceCode, FemaleModifiersTable $femaleModifiersTable)
    {
        return $this->getMaleCharisma($raceCode, $subraceCode) + $femaleModifiersTable->getCharisma($raceCode);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getToughness($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::TOUGHNESS);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return float
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getHeightInCm($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::HEIGHT_IN_CM);
    }

    /**
     * @param string $raceCode
     * @param string $subRaceCode
     * @param string $genderCode
     * @param FemaleModifiersTable $femaleModifiersTable
     * @param WeightTable $weightTable
     * @return float
     * @throws \DrdPlus\Tables\Races\Exceptions\UnknownGender
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getWeightInKg(
        $raceCode,
        $subRaceCode,
        $genderCode,
        FemaleModifiersTable $femaleModifiersTable,
        WeightTable $weightTable
    )
    {
        switch ($genderCode) {
            case GenderCode::MALE :
                return $this->getMaleWeightInKg($raceCode, $subRaceCode);
            case GenderCode::FEMALE :
                return $this->getFemaleWeightInKg(
                    $raceCode,
                    $subRaceCode,
                    $femaleModifiersTable,
                    $weightTable
                );
            default :
                throw new Exceptions\UnknownGender(
                    'Unknown gender ' . ValueDescriber::describe($genderCode)
                );
        }
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return float
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getMaleWeightInKg($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::WEIGHT_IN_KG);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     * @param WeightTable $weightTable
     *
     * @return float
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
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
        $femaleWeightBonus = new WeightBonus($femaleWeightBonusValue, $weightTable);

        return $femaleWeightBonus->getWeight()->getValue();
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getMaleSize($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::SIZE);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getFemaleSize($raceCode, $subraceCode, FemaleModifiersTable $femaleModifiersTable)
    {
        return $this->getMaleSize($raceCode, $subraceCode) + $femaleModifiersTable->getSize($raceCode);
    }

    public function getSize($raceCode, $subraceCode, $genderCode, FemaleModifiersTable $femaleModifiersTable)
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
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return string
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getRemarkableSense($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::REMARKABLE_SENSE);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return bool
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function hasInfravision($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::INFRAVISION);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return bool
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function hasNativeRegeneration($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::NATIVE_REGENERATION);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function getSenses($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::SENSES);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return bool
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     */
    public function requiresDmAgreement($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCode::REQUIRES_DM_AGREEMENT);
    }
}
