<?php
namespace DrdPlus\Tables\Races;

use DrdPlus\Codes\GenderCodes;
use DrdPlus\Codes\PropertyCodes;
use DrdPlus\Codes\RaceCodes;
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
            PropertyCodes::STRENGTH => self::INTEGER,
            PropertyCodes::AGILITY => self::INTEGER,
            PropertyCodes::KNACK => self::INTEGER,
            PropertyCodes::WILL => self::INTEGER,
            PropertyCodes::INTELLIGENCE => self::INTEGER,
            PropertyCodes::CHARISMA => self::INTEGER,
            PropertyCodes::TOUGHNESS => self::INTEGER,
            PropertyCodes::HEIGHT_IN_CM => self::FLOAT,
            PropertyCodes::WEIGHT_IN_KG => self::FLOAT,
            PropertyCodes::SIZE => self::INTEGER,
            PropertyCodes::SENSES => self::INTEGER,
            PropertyCodes::REMARKABLE_SENSE => self::STRING,
            PropertyCodes::INFRAVISION => self::BOOLEAN,
            PropertyCodes::NATIVE_REGENERATION => self::BOOLEAN,
            PropertyCodes::REQUIRES_DM_AGREEMENT => self::BOOLEAN,
        ];
    }

    const RACE = 'race';
    const SUBRACE = 'subrace';

    /**
     * @return array
     */
    protected function getExpectedRowsHeader()
    {
        return [
            self::RACE,
            self::SUBRACE
        ];
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getCommonHumanModifiers()
    {
        return $this->getRow([RaceCodes::HUMAN, RaceCodes::COMMON]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getHighlanderModifiers()
    {
        return $this->getRow([RaceCodes::HUMAN, RaceCodes::HIGHLANDER]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getCommonElfModifiers()
    {
        return $this->getRow([RaceCodes::ELF, RaceCodes::COMMON]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getDarkElfModifiers()
    {
        return $this->getRow([RaceCodes::ELF, RaceCodes::DARK]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getGreenElfModifiers()
    {
        return $this->getRow([RaceCodes::ELF, RaceCodes::GREEN]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getCommonDwarfModifiers()
    {
        return $this->getRow([RaceCodes::DWARF, RaceCodes::COMMON]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getMountainDwarfModifiers()
    {
        return $this->getRow([RaceCodes::DWARF, RaceCodes::MOUNTAIN]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getWoodDwarfModifiers()
    {
        return $this->getRow([RaceCodes::DWARF, RaceCodes::WOOD]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getCommonHobbitModifiers()
    {
        return $this->getRow([RaceCodes::HOBBIT, RaceCodes::COMMON]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getCommonKrollModifiers()
    {
        return $this->getRow([RaceCodes::KROLL, RaceCodes::COMMON]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getWildKrollModifiers()
    {
        return $this->getRow([RaceCodes::KROLL, RaceCodes::WILD]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getCommonOrcModifiers()
    {
        return $this->getRow([RaceCodes::ORC, RaceCodes::COMMON]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getGoblinModifiers()
    {
        return $this->getRow([RaceCodes::ORC, RaceCodes::GOBLIN]);
    }

    /**
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getSkurutModifiers()
    {
        return $this->getRow([RaceCodes::ORC, RaceCodes::SKURUT]);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getMaleStrength($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::STRENGTH);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
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
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
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
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getMaleAgility($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::AGILITY);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
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
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getMaleKnack($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::KNACK);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
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
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getMaleWill($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::WILL);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
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
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getMaleIntelligence($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::INTELLIGENCE);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
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
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getMaleCharisma($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::CHARISMA);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
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
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getToughness($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::TOUGHNESS);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return float
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getHeightInCm($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::HEIGHT_IN_CM);
    }

    /**
     * @param string $raceCode
     * @param string $subRaceCode
     * @param string $genderCode
     * @param FemaleModifiersTable $femaleModifiersTable
     * @param WeightTable $weightTable
     * @return float
     * @throws \DrdPlus\Tables\Races\Exceptions\UnknownGender
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
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
            case GenderCodes::MALE :
                return $this->getMaleWeightInKg($raceCode, $subRaceCode);
            case GenderCodes::FEMALE :
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
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getMaleWeightInKg($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::WEIGHT_IN_KG);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     * @param WeightTable $weightTable
     *
     * @return float
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
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
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getMaleSize($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::SIZE);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     * @param FemaleModifiersTable $femaleModifiersTable
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getFemaleSize($raceCode, $subraceCode, FemaleModifiersTable $femaleModifiersTable)
    {
        return $this->getMaleSize($raceCode, $subraceCode) + $femaleModifiersTable->getSize($raceCode);
    }

    public function getSize($raceCode, $subraceCode, $genderCode, FemaleModifiersTable $femaleModifiersTable)
    {
        switch ($genderCode) {
            case GenderCodes::MALE :
                return $this->getMaleSize($raceCode, $subraceCode);
            case GenderCodes::FEMALE :
                return $this->getFemaleSize($raceCode, $subraceCode, $femaleModifiersTable);
            default :
                throw new Exceptions\UnknownGender(
                    'Expected one of ' . GenderCodes::MALE . ' or ' . GenderCodes::FEMALE
                    . ', got ' . ValueDescriber::describe($genderCode)
                );
        }
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return string
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getRemarkableSense($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::REMARKABLE_SENSE);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return bool
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function hasInfravision($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::INFRAVISION);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return bool
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function hasNativeRegeneration($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::NATIVE_REGENERATION);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function getSenses($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::SENSES);
    }

    /**
     * @param string $raceCode
     * @param string $subraceCode
     *
     * @return bool
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    public function requiresDmAgreement($raceCode, $subraceCode)
    {
        return $this->getProperty($raceCode, $subraceCode, PropertyCodes::REQUIRES_DM_AGREEMENT);
    }
}
