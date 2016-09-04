<?php
namespace DrdPlus\Tables\Armaments;

use DrdPlus\Codes\Armaments\ArmamentCode;
use DrdPlus\Codes\Armaments\ArmorCode;
use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\Armaments\ProtectiveArmamentCode;
use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Codes\Armaments\WeaponlikeCode;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Body\Size;
use DrdPlus\Tables\Armaments\Exceptions\CanNotUseArmorBecauseOfMissingStrength;
use DrdPlus\Tables\Armaments\Exceptions\UnknownArmament;
use DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeaponlike;
use DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength;
use DrdPlus\Tables\Armaments\Exceptions\UnknownWeaponlike;
use DrdPlus\Tables\Tables;
use Granam\Integer\PositiveInteger;
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

    // WEAPONS ONLY

    /**
     * @param ArmamentCode $armamentCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     */
    public function getRequiredStrengthForArmament(ArmamentCode $armamentCode)
    {
        return $this->tables->getArmamentsTableByArmamentCode($armamentCode)->getRequiredStrengthOf($armamentCode);
    }

    /**
     * Increases fight number.
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @return int
     * @throws Exceptions\UnknownMeleeWeaponlike
     */
    public function getLengthOfWeaponlike(WeaponlikeCode $weaponlikeCode)
    {
        if ($weaponlikeCode instanceof MeleeWeaponCode) {
            return $this->tables->getMeleeWeaponlikeTableByMeleeWeaponlikeCode($weaponlikeCode)
                ->getLengthOf($weaponlikeCode);
        }

        return 0; // ranged weapons do not have bonus to fight number for their length, surprisingly
    }

    /**
     * @param WeaponlikeCode $weaponlikeCode
     * @return int
     * @throws Exceptions\UnknownWeaponlike
     */
    public function getWoundsOfWeaponlike(WeaponlikeCode $weaponlikeCode)
    {
        return $this->tables->getWeaponlikeTableByWeaponlikeCode($weaponlikeCode)->getWoundsOf($weaponlikeCode);
    }

    /**
     * @param WeaponlikeCode $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownWeaponlike
     */
    public function getWoundsTypeOfWeaponlike(WeaponlikeCode $weaponlikeCode)
    {
        return $this->tables->getWeaponlikeTableByWeaponlikeCode($weaponlikeCode)->getWoundsTypeOf($weaponlikeCode);
    }

    /**
     * @param WeaponlikeCode $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownWeaponlike
     */
    public function getCoverOfWeaponlike(WeaponlikeCode $weaponlikeCode)
    {
        return $this->tables->getWeaponlikeTableByWeaponlikeCode($weaponlikeCode)->getCoverOf($weaponlikeCode);
    }

    /**
     * @param WeaponlikeCode $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownWeaponlike
     */
    public function getOffensivenessOfWeaponlike(WeaponlikeCode $weaponlikeCode)
    {
        return $this->tables->getWeaponlikeTableByWeaponlikeCode($weaponlikeCode)->getOffensivenessOf($weaponlikeCode);
    }

    /**
     * @param ArmamentCode $armamentCode
     * @return int
     * @throws Exceptions\UnknownArmament
     */
    public function getWeightOfArmament(ArmamentCode $armamentCode)
    {
        return $this->tables->getArmamentsTableByArmamentCode($armamentCode)->getWeightOf($armamentCode);
    }

    // shield-specific

    /**
     * Applicable to lower shield or armor Restriction (Fight number malus), but can not turn to positive (to bonus).
     *
     * @param ProtectiveArmamentCode $protectiveArmamentCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownProtectiveArmament
     */
    public function getRestrictionOfProtectiveArmament(ProtectiveArmamentCode $protectiveArmamentCode)
    {
        return $this->tables->getProtectiveArmamentsTable($protectiveArmamentCode)
            ->getRestrictionOf($protectiveArmamentCode);
    }

    // range-weapon-specific

    /**
     * @param RangedWeaponCode $rangeWeaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    public function getRangeOfRangedWeapon(RangedWeaponCode $rangeWeaponCode)
    {
        return $this->tables->getRangedWeaponsTableByRangedWeaponCode($rangeWeaponCode)->getRangeOf($rangeWeaponCode);
    }

    // ARMAMENTS USAGE AFFECTED BY STRENGTH

    /**
     * Note: spear can be both range and melee, but required strength is for melee and range usages the same
     *
     * @param ArmamentCode $armamentCode
     * @param Strength $currentStrength
     * @param Size $bodySize
     * @return bool
     * @throws Exceptions\UnknownArmament
     */
    public function canUseArmament(ArmamentCode $armamentCode, Strength $currentStrength, Size $bodySize)
    {
        return $this->tables->getArmamentSanctionsByMissingStrengthTableByCode($armamentCode)->canUseIt(
            $this->getMissingStrengthForArmament($armamentCode, $currentStrength, $bodySize)
        );
    }

    /**
     * See PPH page 91, right column
     *
     * @param ArmamentCode $armamentCode
     * @param Size $bodySize
     * @param Strength $currentStrength
     * @return int positive number
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     */
    public function getMissingStrengthForArmament(ArmamentCode $armamentCode, Strength $currentStrength, Size $bodySize)
    {
        $requiredStrength = $this->tables->getArmamentsTableByArmamentCode($armamentCode)->getRequiredStrengthOf($armamentCode);
        $missingStrength = $requiredStrength - $currentStrength->getValue();
        if ($armamentCode instanceof ArmorCode) {
            // only armor weight is related to body size
            $missingStrength += $bodySize->getValue();
        }
        if ($missingStrength < 0) {
            // missing strength can not be negative, of course
            return 0;
        }

        return $missingStrength;
    }

    /**
     * @param WeaponlikeCode $weaponlikeCode
     * @param Strength $currentStrength
     * @return int
     * @throws Exceptions\UnknownArmament
     * @throws Exceptions\UnknownMeleeWeaponlike
     * @throws Exceptions\UnknownWeaponlike
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getFightNumberMalusByStrengthWithWeaponlike(WeaponlikeCode $weaponlikeCode, Strength $currentStrength)
    {
        return $this->tables->getWeaponlikeSanctionsByMissingStrengthTableByCode($weaponlikeCode)->getFightNumberSanction(
            $this->getMissingStrengthForArmament($weaponlikeCode, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * @param WeaponlikeCode $weaponlikeCode
     * @param Strength $currentStrength
     * @return int
     * @throws Exceptions\UnknownWeaponlike
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeaponlike
     */
    public function getAttackNumberMalusByStrengthWithWeaponlike(WeaponlikeCode $weaponlikeCode, Strength $currentStrength)
    {
        return $this->tables->getWeaponlikeSanctionsByMissingStrengthTableByCode($weaponlikeCode)->getAttackNumberSanction(
            $this->getMissingStrengthForArmament($weaponlikeCode, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * Using ranged weapon for defense is possible (it has always cover of 2) but there is 50% chance it will be destroyed.
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @param Strength $currentStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeaponlike
     * @throws \DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getDefenseNumberMalusByStrengthWithWeaponlike(WeaponlikeCode $weaponlikeCode, Strength $currentStrength)
    {
        if ($weaponlikeCode instanceof RangedWeaponCode && $weaponlikeCode->isMeleeArmament()) {
            // spear can be used more effectively to cover as a melee weapon
            $weaponlikeCode = $weaponlikeCode->convertToMeleeWeaponCodeEquivalent();
        }

        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getWeaponlikeSanctionsByMissingStrengthTableByCode($weaponlikeCode)->getDefenseNumberSanction(
            $this->getMissingStrengthForArmament($weaponlikeCode, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * @param WeaponlikeCode $weaponlikeCode
     * @param Strength $currentStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownWeaponlike
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeaponlike
     */
    public function getBaseOfWoundsMalusByStrengthWithWeaponlike(WeaponlikeCode $weaponlikeCode, Strength $currentStrength)
    {
        return $this->tables->getWeaponlikeSanctionsByMissingStrengthTableByCode($weaponlikeCode)->getBaseOfWoundsSanction(
            $this->getMissingStrengthForArmament($weaponlikeCode, $currentStrength, Size::getIt(0))
        );
    }

    // range-weapon-specific usage affected by strength

    /**
     * @param RangedWeaponCode $rangeWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getLoadingInRoundsByStrengthWithRangedWeapon(RangedWeaponCode $rangeWeaponCode, Strength $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getRangedWeaponSanctionsByMissingStrengthTable()->getLoadingInRounds(
            $this->getMissingStrengthForArmament($rangeWeaponCode, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * @param RangedWeaponCode $rangeWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getLoadingInRoundsMalusByStrengthWithRangedWeapon(RangedWeaponCode $rangeWeaponCode, Strength $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getRangedWeaponSanctionsByMissingStrengthTable()->getLoadingInRoundsSanction(
            $this->getMissingStrengthForArmament($rangeWeaponCode, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * @param RangedWeaponCode $rangeWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getEncounterRangeMalusByStrengthWithRangedWeapon(RangedWeaponCode $rangeWeaponCode, Strength $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getRangedWeaponSanctionsByMissingStrengthTable()->getEncounterRangeSanction(
            $this->getMissingStrengthForArmament($rangeWeaponCode, $currentStrength, Size::getIt(0))
        );
    }

    // armor-specific usage affected by strength

    /**
     * @param ArmorCode $armorCode
     * @param Strength $currentStrength
     * @param Size $bodySize
     * @return int
     * @throws CanNotUseArmorBecauseOfMissingStrength
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     */
    public function getAgilityMalusByStrengthWithArmor(ArmorCode $armorCode, Strength $currentStrength, Size $bodySize)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getArmorSanctionsByMissingStrengthTable()->getAgilityMalus(
            $this->getMissingStrengthForArmament($armorCode, $currentStrength, $bodySize)
        );
    }

    /**
     * @param ArmorCode $armorCode
     * @param Strength $currentStrength
     * @param Size $bodySize
     * @return int
     * @throws CanNotUseArmorBecauseOfMissingStrength
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getSanctionDescriptionByStrengthWithArmor(ArmorCode $armorCode, Strength $currentStrength, Size $bodySize)
    {
        return $this->tables->getArmorSanctionsByMissingStrengthTable()->getSanctionDescription(
            $this->getMissingStrengthForArmament($armorCode, $currentStrength, $bodySize)
        );
    }

    // MISSING WEAPON SKILL

    /**
     * Note about shields: there is no such skill as FightWithShields, any attempt to fight with shield results into zero skill rank.
     *
     * @param PositiveInteger $weaponTypeSkillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function getFightNumberMalusForSkill(PositiveInteger $weaponTypeSkillRank)
    {
        return $this->tables->getMissingWeaponSkillTable()->getFightNumberMalusForSkill($weaponTypeSkillRank->getValue());
    }

    /**
     * Note about shields: there is no such skill as FightWithShields, any attempt to fight with shield results into zero skill rank.
     *
     * @param PositiveInteger $weaponTypeSkillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function getAttackNumberMalusForSkill(PositiveInteger $weaponTypeSkillRank)
    {
        return $this->tables->getMissingWeaponSkillTable()->getAttackNumberMalusForSkill($weaponTypeSkillRank->getValue());
    }

    /**
     * @param PositiveInteger $weaponTypeSkillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function getCoverMalusForSkill(PositiveInteger $weaponTypeSkillRank)
    {
        return $this->tables->getMissingWeaponSkillTable()->getCoverMalusForSkill($weaponTypeSkillRank->getValue());
    }

    /**
     * Note about shields: there is no such skill as FightWithShields, any attempt to fight with shield results into zero skill rank.
     *
     * @param PositiveInteger $weaponTypeSkillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function getBaseOfWoundsMalusForSkill(PositiveInteger $weaponTypeSkillRank)
    {
        return $this->tables->getMissingWeaponSkillTable()->getBaseOfWoundsMalusForSkill($weaponTypeSkillRank->getValue());
    }

    // missing shield-specific skill

    /**
     * Applicable to lower shield or armor Restriction (Fight number malus), but can not make it positive.
     *
     * @param ProtectiveArmamentCode $protectiveArmamentCode
     * @param PositiveInteger $protectiveArmamentSkillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function getProtectiveArmamentRestrictionBonusForSkill(
        ProtectiveArmamentCode $protectiveArmamentCode,
        PositiveInteger $protectiveArmamentSkillRank
    )
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getProtectiveArmamentMissingSkillTableByCode($protectiveArmamentCode)
            ->getRestrictionBonusForSkill($protectiveArmamentSkillRank->getValue());
    }

    /**
     * Restriction is Fight number malus.
     *
     * @param ProtectiveArmamentCode $protectiveArmamentCode
     * @param PositiveInteger $protectiveArmamentSkillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownProtectiveArmament
     */
    public function getProtectiveArmamentRestrictionForSkill(
        ProtectiveArmamentCode $protectiveArmamentCode,
        PositiveInteger $protectiveArmamentSkillRank
    )
    {
        $restriction = $this->getRestrictionOfProtectiveArmament($protectiveArmamentCode)
            + $this->getProtectiveArmamentRestrictionBonusForSkill($protectiveArmamentCode, $protectiveArmamentSkillRank);
        if ($restriction > 0) {
            return 0; // can not turn into bonus
        }

        return $restriction;
    }

}