<?php
namespace DrdPlus\Tables\Armaments;

use DrdPlus\Codes\ArmamentCode;
use DrdPlus\Codes\ArmorCode;
use DrdPlus\Codes\BodyArmorCode;
use DrdPlus\Codes\HelmCode;
use DrdPlus\Codes\MeleeWeaponCode;
use DrdPlus\Codes\RangeWeaponCode;
use DrdPlus\Codes\WeaponCode;
use DrdPlus\Tables\Armaments\Armors\Exceptions\CanNotUseArmorBecauseOfMissingStrength;
use DrdPlus\Tables\Armaments\Armors\Exceptions\UnknownArmorCode;
use DrdPlus\Tables\Armaments\Partials\AbstractArmamentsTable;
use DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength;
use DrdPlus\Tables\Armaments\Weapons\Exceptions\UnknownWeaponCode;
use DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeaponCode;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode;
use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTable;
use DrdPlus\Tables\Tables;
use Granam\Integer\Tools\ToInteger;
use Granam\Strict\Object\StrictObject;

class Armourer extends StrictObject
{
    /**
     * @var Tables
     */
    private $tables;

    public function __construct(Tables $tables)
    {
        $this->tables = $tables;
    }

    /**
     * @param ArmorCode $armorCode
     * @param int $bodySize
     * @param int $currentStrength
     * @return array|\mixed[]
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getSanctionValuesForArmor(ArmorCode $armorCode, $bodySize, $currentStrength)
    {
        return $this->tables->getArmorSanctionsTable()->getSanctionsForMissingStrength(
            $this->getMissingStrengthForArmor($armorCode, $bodySize, $currentStrength)
        );
    }

    /**
     * See PPH page 91, right column
     * @param ArmorCode $armorCode
     * @param int $bodySize
     * @param int $currentStrength
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getMissingStrengthForArmor(ArmorCode $armorCode, $bodySize, $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return max(
            0,
            $this->getMissingStrengthForArmament(
                $this->getArmorsTableByArmorCode($armorCode),
                $armorCode,
                $currentStrength,
                false // give as raw value, even negative
            ) + ToInteger::toInteger($bodySize)
        );
    }

    /**
     * @param ArmorCode $armorCode
     * @return Armors\BodyArmorsTable|Armors\HelmsTable
     * @throws UnknownArmorCode
     */
    private function getArmorsTableByArmorCode(ArmorCode $armorCode)
    {
        if ($armorCode instanceof BodyArmorCode) {
            return $this->tables->getBodyArmorsTable();
        }
        if ($armorCode instanceof HelmCode) {
            return $this->tables->getHelmsTable();
        }

        throw new UnknownArmorCode();
    }

    /**
     * See PPH page 91, right column
     * @param AbstractArmamentsTable $abstractArmamentsTable
     * @param ArmamentCode $armamentCode
     * @param int $currentStrength
     * @param bool $isFinalValue
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    private function getMissingStrengthForArmament(
        AbstractArmamentsTable $abstractArmamentsTable,
        ArmamentCode $armamentCode,
        $currentStrength,
        $isFinalValue
    )
    {
        $requiredStrength = $abstractArmamentsTable->getRequiredStrengthOf($armamentCode->getValue());
        $missingStrength = $requiredStrength - ToInteger::toInteger($currentStrength);
        if ($isFinalValue && $missingStrength < 0) {
            return 0;
        }

        return $missingStrength;
    }

    /**
     * @param ArmorCode $armorCode
     * @param int $bodySize
     * @param int $currentStrength
     * @return bool
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function canUseArmor(ArmorCode $armorCode, $bodySize, $currentStrength)
    {
        $missingStrength = $this->getMissingStrengthForArmor($armorCode, $bodySize, $currentStrength);

        return $this->tables->getArmorSanctionsTable()->canMove($missingStrength);
    }

    /**
     * @param ArmorCode $armorCode
     * @param int $bodySize
     * @param int $currentStrength
     * @return int
     * @throws CanNotUseArmorBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getSanctionDescriptionForArmor(ArmorCode $armorCode, $bodySize, $currentStrength)
    {
        $missingStrength = $this->getMissingStrengthForArmor($armorCode, $bodySize, $currentStrength);

        return $this->tables->getArmorSanctionsTable()->getSanctionDescription($missingStrength);
    }

    /**
     * @param ArmorCode $armorCode
     * @param int $bodySize
     * @param int $currentStrength
     * @return int
     * @throws CanNotUseArmorBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getAgilityMalusForArmor(ArmorCode $armorCode, $bodySize, $currentStrength)
    {
        $missingStrength = $this->getMissingStrengthForArmor($armorCode, $bodySize, $currentStrength);

        return $this->tables->getArmorSanctionsTable()->getAgilityMalus($missingStrength);
    }

    /**
     * @param MeleeWeaponCode $meleeWeaponCode
     * @param int $currentStrength
     * @return array|\mixed[]
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getSanctionValuesForMeleeWeapon(MeleeWeaponCode $meleeWeaponCode, $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $missingStrength = $this->getMissingStrengthForMeleeWeapon($meleeWeaponCode, $currentStrength);

        return $this->tables->getMeleeWeaponSanctionsTable()->getSanctionsForMissingStrength($missingStrength);
    }

    /**
     * @param MeleeWeaponCode $meleeWeaponCode
     * @param int $currentStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeaponCode
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getMissingStrengthForMeleeWeapon(MeleeWeaponCode $meleeWeaponCode, $currentStrength)
    {
        return $this->getMissingStrengthForArmament(
            $this->getTableByMeleeWeaponCode($meleeWeaponCode),
            $meleeWeaponCode,
            $currentStrength,
            true // it is final value, negative means zero
        );
    }

    /**
     * @param MeleeWeaponCode $meleeWeaponCode
     * @return MeleeWeaponsTable
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeaponCode
     */
    private function getTableByMeleeWeaponCode(MeleeWeaponCode $meleeWeaponCode)
    {
        if ($meleeWeaponCode->isAxe()) {
            return $this->tables->getAxesTable();
        }
        if ($meleeWeaponCode->isKnifeOrDagger()) {
            return $this->tables->getKnifesAndDaggersTable();
        }
        if ($meleeWeaponCode->isMaceOrClub()) {
            return $this->tables->getMacesAndClubsTable();
        }
        if ($meleeWeaponCode->isMorningStarOrMorgenstern()) {
            return $this->tables->getMorningStarsAndMorgensternsTable();
        }
        if ($meleeWeaponCode->isSaberOrBowieKnife()) {
            return $this->tables->getSabersAndBowieKnifesTable();
        }
        if ($meleeWeaponCode->isStaffOrSpear()) {
            return $this->tables->getStaffsAndSpearsTable();
        }
        if ($meleeWeaponCode->isSword()) {
            return $this->tables->getSwordsTable();
        }
        if ($meleeWeaponCode->isUnarmed()) {
            return $this->tables->getUnarmedTable();
        }
        if ($meleeWeaponCode->isVoulgeOrTrident()) {
            return $this->tables->getVoulgesAndTridentsTable();
        }
        throw new UnknownMeleeWeaponCode(
            "Given melee weapon of code {$meleeWeaponCode} does not belongs to any known type"
        );
    }

    /**
     * @param MeleeWeaponCode $meleeWeaponCode
     * @param int $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getMeleeWeaponFightNumberMalus(MeleeWeaponCode $meleeWeaponCode, $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $missingStrength = $this->getMissingStrengthForMeleeWeapon($meleeWeaponCode, $currentStrength);

        return $this->tables->getMeleeWeaponSanctionsTable()->getFightNumberSanction($missingStrength);
    }

    /**
     * @param MeleeWeaponCode $meleeWeaponCode
     * @param int $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getMeleeWeaponAttackNumberMalus(MeleeWeaponCode $meleeWeaponCode, $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $missingStrength = $this->getMissingStrengthForMeleeWeapon($meleeWeaponCode, $currentStrength);

        return $this->tables->getMeleeWeaponSanctionsTable()->getAttackNumberSanction($missingStrength);
    }

    /**
     * @param MeleeWeaponCode $meleeWeaponCode
     * @param int $currentStrength
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     * @throws \DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getMeleeWeaponDefenseNumberMalus(MeleeWeaponCode $meleeWeaponCode, $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $missingStrength = $this->getMissingStrengthForMeleeWeapon($meleeWeaponCode, $currentStrength);

        return $this->tables->getMeleeWeaponSanctionsTable()->getDefenseNumberSanction($missingStrength);
    }

    /**
     * @param MeleeWeaponCode $meleeWeaponCode
     * @param int $currentStrength
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     * @throws \DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getMeleeWeaponBaseOfWoundsMalus(MeleeWeaponCode $meleeWeaponCode, $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $missingStrength = $this->getMissingStrengthForMeleeWeapon($meleeWeaponCode, $currentStrength);

        return $this->tables->getMeleeWeaponSanctionsTable()->getBaseOfWoundsSanction($missingStrength);
    }

    /**
     * Beware of spear, which can be both range and melee - if you want to use it as range, provide it as RangeWeaponCode,
     * otherwise as MeleeWeaponCode
     * @param WeaponCode $weaponCode
     * @param $currentStrength
     * @return bool
     * @throws \DrdPlus\Tables\Armaments\Weapons\Exceptions\UnknownWeaponCode
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function canUseWeapon(WeaponCode $weaponCode, $currentStrength)
    {
        if ($weaponCode instanceof MeleeWeaponCode) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $missingStrength = $this->getMissingStrengthForMeleeWeapon($weaponCode, $currentStrength);

            return $this->tables->getMeleeWeaponSanctionsTable()->canUseWeapon($missingStrength);
        }
        if ($weaponCode instanceof RangeWeaponCode) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $missingStrength = $this->getMissingStrengthForRangeWeapon($weaponCode, $currentStrength);

            return $this->tables->getRangeWeaponSanctionsTable()->canUseWeapon($missingStrength);
        }

        throw new UnknownWeaponCode("Given weapon code {$weaponCode} is unknown");
    }

    /**
     * @param MeleeWeaponCode $meleeWeaponCode
     * @param int $currentStrength
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function canUseMeleeWeapon(MeleeWeaponCode $meleeWeaponCode, $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $missingStrength = $this->getMissingStrengthForMeleeWeapon($meleeWeaponCode, $currentStrength);

        return $this->tables->getMeleeWeaponSanctionsTable()->canUseWeapon($missingStrength);
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param int $currentStrength
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function canUseRangeWeapon(RangeWeaponCode $rangeWeaponCode, $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $missingStrength = $this->getMissingStrengthForRangeWeapon($rangeWeaponCode, $currentStrength);

        return $this->tables->getRangeWeaponSanctionsTable()->canUseWeapon($missingStrength);
    }

    /**
     * @param RangeWeaponCode $shootingWeaponCode
     * @param int $currentStrength
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getSanctionValuesForRangeWeapon(RangeWeaponCode $shootingWeaponCode, $currentStrength)
    {
        $missingStrength = $this->getMissingStrengthForRangeWeapon($shootingWeaponCode, $currentStrength);

        return $this->tables->getRangeWeaponSanctionsTable()->getSanctionsForMissingStrength($missingStrength);
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param int $currentStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getMissingStrengthForRangeWeapon(RangeWeaponCode $rangeWeaponCode, $currentStrength)
    {
        return $this->getMissingStrengthForArmament(
            $this->getTableByRangeWeaponCode($rangeWeaponCode),
            $rangeWeaponCode,
            $currentStrength,
            true // it is final value, negative means zero
        );
    }

    /**
     * @param RangeWeaponCode $shootingWeaponCode
     * @return RangeWeaponsTable
     * @throws \DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode
     */
    private function getTableByRangeWeaponCode(RangeWeaponCode $shootingWeaponCode)
    {
        if ($shootingWeaponCode->isArrow()) {
            return $this->tables->getArrowsTable();
        }
        if ($shootingWeaponCode->isBow()) {
            return $this->tables->getBowsTable();
        }
        if ($shootingWeaponCode->isCrossbow()) {
            return $this->tables->getCrossbowsTable();
        }
        if ($shootingWeaponCode->isDart()) {
            return $this->tables->getDartsTable();
        }
        if ($shootingWeaponCode->isSlingStone()) {
            return $this->tables->getSlingStonesTable();
        }
        throw new UnknownRangeWeaponCode(
            "Given shooting weapon of code {$shootingWeaponCode} does not belongs to any known type"
        );
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param int $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getRangeWeaponFightNumberMalus(RangeWeaponCode $rangeWeaponCode, $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $missingStrength = $this->getMissingStrengthForRangeWeapon($rangeWeaponCode, $currentStrength);

        return $this->tables->getRangeWeaponSanctionsTable()->getFightNumberSanction($missingStrength);
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param int $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getRangeWeaponAttackNumberMalus(RangeWeaponCode $rangeWeaponCode, $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $missingStrength = $this->getMissingStrengthForRangeWeapon($rangeWeaponCode, $currentStrength);

        return $this->tables->getRangeWeaponSanctionsTable()->getAttackNumberSanction($missingStrength);
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param int $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getRangeWeaponLoadingInRounds(RangeWeaponCode $rangeWeaponCode, $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $missingStrength = $this->getMissingStrengthForRangeWeapon($rangeWeaponCode, $currentStrength);

        return $this->tables->getRangeWeaponSanctionsTable()->getLoadingInRounds($missingStrength);
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param int $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getRangeWeaponLoadingInRoundsMalus(RangeWeaponCode $rangeWeaponCode, $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $missingStrength = $this->getMissingStrengthForRangeWeapon($rangeWeaponCode, $currentStrength);

        return $this->tables->getRangeWeaponSanctionsTable()->getLoadingInRoundsSanction($missingStrength);
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param int $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getRangeWeaponEncounterRangeMalus(RangeWeaponCode $rangeWeaponCode, $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $missingStrength = $this->getMissingStrengthForRangeWeapon($rangeWeaponCode, $currentStrength);

        return $this->tables->getRangeWeaponSanctionsTable()->getEncounterRangeSanction($missingStrength);
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param int $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getRangeWeaponBaseOfWoundsMalus(RangeWeaponCode $rangeWeaponCode, $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $missingStrength = $this->getMissingStrengthForRangeWeapon($rangeWeaponCode, $currentStrength);

        return $this->tables->getRangeWeaponSanctionsTable()->getBaseOfWoundsSanction($missingStrength);
    }
}