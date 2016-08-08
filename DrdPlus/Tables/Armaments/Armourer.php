<?php
namespace DrdPlus\Tables\Armaments;

use DrdPlus\Codes\ArmamentCode;
use DrdPlus\Codes\ArmorCode;
use DrdPlus\Codes\BodyArmorCode;
use DrdPlus\Codes\HelmCode;
use DrdPlus\Codes\MeleeWeaponCode;
use DrdPlus\Codes\RangeWeaponCode;
use DrdPlus\Tables\Armaments\Armors\Exceptions\CanNotUseArmorBecauseOfMissingStrength;
use DrdPlus\Tables\Armaments\Armors\Exceptions\UnknownArmorCode;
use DrdPlus\Tables\Armaments\Partials\AbstractArmamentsTable;
use DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength;
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
     * @param int $strength
     * @return array|\mixed[]
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getSanctionValuesForArmor(ArmorCode $armorCode, $bodySize, $strength)
    {
        return $this->tables->getArmorSanctionsTable()->getSanctionsForMissingStrength(
            $this->getMissingStrengthForArmor($armorCode, $bodySize, $strength)
        );
    }

    /**
     * See PPH page 91, right column
     * @param ArmorCode $armorCode
     * @param int $bodySize
     * @param int $strength
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getMissingStrengthForArmor(ArmorCode $armorCode, $bodySize, $strength)
    {
        return max(
            0,
            $this->getMissingStrengthForArmament(
                $this->getArmorsTableByArmorCode($armorCode),
                $armorCode,
                $strength,
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
     * @param int $strength
     * @param bool $isFinalValue
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    private function getMissingStrengthForArmament(
        AbstractArmamentsTable $abstractArmamentsTable,
        ArmamentCode $armamentCode,
        $strength,
        $isFinalValue
    )
    {
        $requiredStrength = $abstractArmamentsTable->getRequiredStrengthOf($armamentCode->getValue());
        $missingStrength = $requiredStrength - ToInteger::toInteger($strength);
        if ($isFinalValue && $missingStrength < 0) {
            return 0;
        }

        return $missingStrength;
    }

    /**
     * @param ArmorCode $armorCode
     * @param int $bodySize
     * @param int $strength
     * @return int
     * @throws CanNotUseArmorBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getSanctionDescriptionForArmor(ArmorCode $armorCode, $bodySize, $strength)
    {
        $missingStrength = $this->getMissingStrengthForArmor($armorCode, $bodySize, $strength);

        return $this->tables->getArmorSanctionsTable()->getSanctionDescription($missingStrength);
    }

    /**
     * @param ArmorCode $armorCode
     * @param int $bodySize
     * @param int $strength
     * @return int
     * @throws CanNotUseArmorBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getAgilityMalusForArmor(ArmorCode $armorCode, $bodySize, $strength)
    {
        $missingStrength = $this->getMissingStrengthForArmor($armorCode, $bodySize, $strength);

        return $this->tables->getArmorSanctionsTable()->getAgilityMalus($missingStrength);
    }

    /**
     * @param MeleeWeaponCode $meleeWeaponCode
     * @param int $strength
     * @return array|\mixed[]
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getSanctionValuesForMeleeWeapon(MeleeWeaponCode $meleeWeaponCode, $strength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $missingStrength = $this->getMissingStrengthForMeleeWeapon($meleeWeaponCode, $strength);

        return $this->tables->getMeleeWeaponSanctionsTable()->getSanctionsForMissingStrength($missingStrength);
    }

    /**
     * @param MeleeWeaponCode $meleeWeaponCode
     * @param int $strength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeaponCode
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getMissingStrengthForMeleeWeapon(MeleeWeaponCode $meleeWeaponCode, $strength)
    {
        return $this->getMissingStrengthForArmament(
            $this->getTableByMeleeWeaponCode($meleeWeaponCode),
            $meleeWeaponCode,
            $strength,
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
     * @param int $strength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getMeleeWeaponFightNumberMalus(MeleeWeaponCode $meleeWeaponCode, $strength)
    {
        $missingStrength = $this->getMissingStrengthForMeleeWeapon($meleeWeaponCode, $strength);

        return $this->tables->getMeleeWeaponSanctionsTable()->getFightNumberSanction($missingStrength);
    }

    /**
     * @param MeleeWeaponCode $meleeWeaponCode
     * @param int $strength
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getMeleeWeaponAttackNumberMalus(MeleeWeaponCode $meleeWeaponCode, $strength)
    {
        $missingStrength = $this->getMissingStrengthForMeleeWeapon($meleeWeaponCode, $strength);

        return $this->tables->getMeleeWeaponSanctionsTable()->getAttackNumberSanction($missingStrength);
    }

    /**
     * @param MeleeWeaponCode $meleeWeaponCode
     * @param int $strength
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getMeleeWeaponDefenseNumberMalus(MeleeWeaponCode $meleeWeaponCode, $strength)
    {
        $missingStrength = $this->getMissingStrengthForMeleeWeapon($meleeWeaponCode, $strength);

        return $this->tables->getMeleeWeaponSanctionsTable()->getDefenseNumberSanction($missingStrength);
    }

    /**
     * @param MeleeWeaponCode $meleeWeaponCode
     * @param int $strength
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getMeleeWeaponBaseOfWoundsMalus(MeleeWeaponCode $meleeWeaponCode, $strength)
    {
        $missingStrength = $this->getMissingStrengthForMeleeWeapon($meleeWeaponCode, $strength);

        return $this->tables->getMeleeWeaponSanctionsTable()->getBaseOfWoundsSanction($missingStrength);
    }

    /**
     * @param MeleeWeaponCode $meleeWeaponCode
     * @param int $strength
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function canUseMeleeWeapon(MeleeWeaponCode $meleeWeaponCode, $strength)
    {
        $missingStrength = $this->getMissingStrengthForMeleeWeapon($meleeWeaponCode, $strength);

        return $this->tables->getMeleeWeaponSanctionsTable()->canUseWeapon($missingStrength);
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param int $strength
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function canUseRangeWeapon(RangeWeaponCode $rangeWeaponCode, $strength)
    {
        $missingStrength = $this->getMissingStrengthForRangeWeapon($rangeWeaponCode, $strength);

        return $this->tables->getRangeWeaponSanctionsTable()->canUseWeapon($missingStrength);
    }

    /**
     * @param RangeWeaponCode $shootingWeaponCode
     * @param int $strength
     * @return array|\mixed[]
     * @throws \DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getSanctionValuesForRangeWeapon(RangeWeaponCode $shootingWeaponCode, $strength)
    {
        $missingStrength = $this->getMissingStrengthForRangeWeapon($shootingWeaponCode, $strength);

        return $this->tables->getRangeWeaponSanctionsTable()->getSanctionsForMissingStrength($missingStrength);
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param int $strength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getMissingStrengthForRangeWeapon(RangeWeaponCode $rangeWeaponCode, $strength)
    {
        return $this->getMissingStrengthForArmament(
            $this->getTableByRangeWeaponCode($rangeWeaponCode),
            $rangeWeaponCode,
            $strength,
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
     * @param int $strength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getRangeWeaponFightNumberMalus(RangeWeaponCode $rangeWeaponCode, $strength)
    {
        $missingStrength = $this->getMissingStrengthForRangeWeapon($rangeWeaponCode, $strength);

        return $this->tables->getRangeWeaponSanctionsTable()->getFightNumberSanction($missingStrength);
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param int $strength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getRangeWeaponAttackNumberMalus(RangeWeaponCode $rangeWeaponCode, $strength)
    {
        $missingStrength = $this->getMissingStrengthForRangeWeapon($rangeWeaponCode, $strength);

        return $this->tables->getRangeWeaponSanctionsTable()->getAttackNumberSanction($missingStrength);
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param int $strength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getRangeWeaponLoadingInRounds(RangeWeaponCode $rangeWeaponCode, $strength)
    {
        $missingStrength = $this->getMissingStrengthForRangeWeapon($rangeWeaponCode, $strength);

        return $this->tables->getRangeWeaponSanctionsTable()->getLoadingInRounds($missingStrength);
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param int $strength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getRangeWeaponLoadingInRoundsMalus(RangeWeaponCode $rangeWeaponCode, $strength)
    {
        $missingStrength = $this->getMissingStrengthForRangeWeapon($rangeWeaponCode, $strength);

        return $this->tables->getRangeWeaponSanctionsTable()->getLoadingInRoundsSanction($missingStrength);
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param int $strength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getRangeWeaponEncounterRangeMalus(RangeWeaponCode $rangeWeaponCode, $strength)
    {
        $missingStrength = $this->getMissingStrengthForRangeWeapon($rangeWeaponCode, $strength);

        return $this->tables->getRangeWeaponSanctionsTable()->getEncounterRangeSanction($missingStrength);
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param int $strength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getRangeWeaponBaseOfWoundsMalus(RangeWeaponCode $rangeWeaponCode, $strength)
    {
        $missingStrength = $this->getMissingStrengthForRangeWeapon($rangeWeaponCode, $strength);

        return $this->tables->getRangeWeaponSanctionsTable()->getBaseOfWoundsSanction($missingStrength);
    }
}