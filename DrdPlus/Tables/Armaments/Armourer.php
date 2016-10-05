<?php
namespace DrdPlus\Tables\Armaments;

use DrdPlus\Codes\Armaments\ArmamentCode;
use DrdPlus\Codes\Armaments\ArmorCode;
use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\Armaments\ProtectiveArmamentCode;
use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Codes\Armaments\ShieldCode;
use DrdPlus\Codes\Armaments\WeaponlikeCode;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Body\Size;
use DrdPlus\Properties\Derived\Speed;
use DrdPlus\Tables\Armaments\Exceptions\CanNotUseArmorBecauseOfMissingStrength;
use DrdPlus\Tables\Armaments\Exceptions\UnknownArmament;
use DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeaponlike;
use DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon;
use DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength;
use DrdPlus\Tables\Armaments\Exceptions\UnknownWeaponlike;
use DrdPlus\Tables\Armaments\Weapons\Ranged\Exceptions\UnknownBow;
use DrdPlus\Tables\Tables;
use DrdPlus\Tools\Calculations\SumAndRound;
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
     * @throws Exceptions\UnknownWeaponlike
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

    /**
     * @param WeaponlikeCode $weaponlikeCode
     * @return bool
     * @throws Exceptions\UnknownWeaponlike
     */
    public function isTwoHandedOnly(WeaponlikeCode $weaponlikeCode)
    {
        return $this->tables->getWeaponlikeTableByWeaponlikeCode($weaponlikeCode)->getTwoHandedOf($weaponlikeCode);
    }

    /**
     * There are weapons so small so can not be hold by two hands
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @return bool
     * @throws Exceptions\UnknownWeaponlike
     */
    public function isOneHandedOnly(WeaponlikeCode $weaponlikeCode)
    {
        return !$this->canHoldItByTwoHands($weaponlikeCode);
    }

    /**
     * Not all weapons can be hold by two hands - some of them are simply so small so it is not possible or highly
     * ineffective.
     *
     * @param WeaponlikeCode $weaponToHoldByTwoHands
     * @return bool
     * @throws Exceptions\UnknownWeaponlike
     */
    public function canHoldItByTwoHands(WeaponlikeCode $weaponToHoldByTwoHands)
    {
        return
            // shooting weapons are two-handed (except minicrossbow), projectiles are not
            $this->isTwoHandedOnly($weaponToHoldByTwoHands) // the weapon is explicitly two-handed
            // or it is melee weapon with length at least 1 (see PPH page 92 right column)
            || ($weaponToHoldByTwoHands->isMelee()
                && $this->tables->getArmourer()->getLengthOfWeaponlike($weaponToHoldByTwoHands) >= 1
            );
    }

    /**
     * Some weapons are so specific so keeping them in a single hand would make them highly inefficient, like a halberd.
     *
     * @param WeaponlikeCode $weaponToHoldByTwoHands
     * @return bool
     * @throws Exceptions\UnknownWeaponlike
     */
    public function canHoldItByOneHand(WeaponlikeCode $weaponToHoldByTwoHands)
    {
        return !$this->isTwoHandedOnly($weaponToHoldByTwoHands); // shooting weapons are two-handed (except minicrossbow), projectiles are not
    }

    /**
     * Note about SHIELD: it has always length of 0 and therefore you can NOT hold it by both hands (but the last word
     * has DM).
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @return bool
     * @throws Exceptions\UnknownWeaponlike
     */
    public function canHoldItByOneHandAsWellAsTwoHands(WeaponlikeCode $weaponlikeCode)
    {
        return $this->canHoldItByOneHand($weaponlikeCode)
        && $this->canHoldItByTwoHands($weaponlikeCode);
    }

    /**
     * Even LEG and HOBNAILED BOOT are considered as empty hand.
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @return bool
     */
    public function hasEmptyHand(WeaponlikeCode $weaponlikeCode)
    {
        return
            ($weaponlikeCode instanceof ShieldCode && $weaponlikeCode->isWithoutShield())
            || ($weaponlikeCode instanceof MeleeWeaponCode && $weaponlikeCode->isUnarmed());
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
     * @param RangedWeaponCode $rangedWeaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    public function getRangeOfRangedWeapon(RangedWeaponCode $rangedWeaponCode)
    {
        return $this->tables->getRangedWeaponsTableByRangedWeaponCode($rangedWeaponCode)->getRangeOf($rangedWeaponCode);
    }

    // ARMAMENTS USAGE AFFECTED BY STRENGTH

    /**
     * @param WeaponlikeCode $weaponlikeCode
     * @param Strength $currentStrength
     * @return Strength
     * @throws UnknownBow
     */
    public function getApplicableStrength(WeaponlikeCode $weaponlikeCode, Strength $currentStrength)
    {
        if ((!$weaponlikeCode instanceof RangedWeaponCode) || !$weaponlikeCode->isBow()) {
            return $currentStrength;
        }
        $strengthValue = min(
            $currentStrength->getValue(),
            $this->tables->getBowsTable()->getMaximalApplicableStrengthOf($weaponlikeCode)
        );

        return Strength::getIt($strengthValue);
    }

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
        return $this->tables->getArmamentStrengthSanctionsTableByCode($armamentCode)->canUseIt(
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
        return $this->tables->getWeaponlikeStrengthSanctionsTableByCode($weaponlikeCode)->getFightNumberSanction(
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
        return $this->tables->getWeaponlikeStrengthSanctionsTableByCode($weaponlikeCode)->getAttackNumberSanction(
            $this->getMissingStrengthForArmament($weaponlikeCode, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * Using ranged weapon for defense is possible (it has always cover of 2) but there is 50% chance it will be
     * destroyed.
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
        if ($weaponlikeCode instanceof RangedWeaponCode && $weaponlikeCode->isMelee()) {
            // spear can be used more effectively to cover as a melee weapon
            $weaponlikeCode = $weaponlikeCode->convertToMeleeWeaponCodeEquivalent();
        }

        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getWeaponlikeStrengthSanctionsTableByCode($weaponlikeCode)->getDefenseNumberSanction(
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
        return $this->tables->getWeaponlikeStrengthSanctionsTableByCode($weaponlikeCode)->getBaseOfWoundsSanction(
            $this->getMissingStrengthForArmament($weaponlikeCode, $currentStrength, Size::getIt(0))
        );
    }

    // range-weapon-specific usage affected by properties

    /**
     * The final number of rounds needed to load a weapon.
     *
     * @param RangedWeaponCode $rangedWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getLoadingInRoundsByStrengthWithRangedWeapon(RangedWeaponCode $rangedWeaponCode, Strength $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getRangedWeaponStrengthSanctionsTable()->getLoadingInRounds(
            $this->getMissingStrengthForArmament($rangedWeaponCode, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * The relative number of rounds as a malus to standard number of rounds needed to load a weapon.
     *
     * @param RangedWeaponCode $rangedWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getLoadingInRoundsMalusByStrengthWithRangedWeapon(RangedWeaponCode $rangedWeaponCode, Strength $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getRangedWeaponStrengthSanctionsTable()->getLoadingInRoundsSanction(
            $this->getMissingStrengthForArmament($rangedWeaponCode, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * @param RangedWeaponCode $rangedWeaponCode
     * @param Strength $currentStrength
     * @param Speed $currentSpeed
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws UnknownArmament
     * @throws UnknownRangedWeapon
     * @throws UnknownBow
     */
    public function getEncounterRangeWithRangedWeapon(
        RangedWeaponCode $rangedWeaponCode,
        Strength $currentStrength,
        Speed $currentSpeed
    )
    {
        $encounterRange = $this->getRangeOfRangedWeapon($rangedWeaponCode);
        $encounterRange += $this->getEncounterRangeMalusByStrength($rangedWeaponCode, $currentStrength);
        $encounterRange += $this->getEncounterRangeBonusByStrength($rangedWeaponCode, $currentStrength);
        $encounterRange += $this->getEncounterRangeBonusBySpeed($rangedWeaponCode, $currentSpeed);

        return $encounterRange;
    }

    /**
     * @param RangedWeaponCode $rangedWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws UnknownArmament
     * @throws UnknownBow
     */
    private function getEncounterRangeMalusByStrength(
        RangedWeaponCode $rangedWeaponCode,
        Strength $currentStrength
    )
    {
        if (!$rangedWeaponCode->isBow() && !$rangedWeaponCode->isThrowingWeapon()) {
            return 0;
        }
        $currentStrength = $this->getApplicableStrength($rangedWeaponCode, $currentStrength);
        $missingStrength = $this->getMissingStrengthForArmament(
            $rangedWeaponCode,
            $currentStrength,
            Size::getIt(0) // size is irrelevant for this armament
        );

        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getRangedWeaponStrengthSanctionsTable()->getEncounterRangeSanction(
            $missingStrength
        );
    }

    /**
     * Bows get bonus to range from used strength (up to maximal strength applicable for given bow).
     * Other ranged weapons gets no range bonus (zero) from strength.
     *
     * @param RangedWeaponCode $rangedWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws UnknownBow
     */
    private function getEncounterRangeBonusByStrength(RangedWeaponCode $rangedWeaponCode, Strength $currentStrength)
    {
        if (!$rangedWeaponCode->isBow()) {
            return 0;
        }
        $currentStrength = $this->getApplicableStrength($rangedWeaponCode, $currentStrength);

        // the range bonus for bow is equal to strength applicable for it
        return min(
            $this->tables->getBowsTable()->getMaximalApplicableStrengthOf($rangedWeaponCode),
            $currentStrength->getValue()
        );
    }

    /**
     * @param RangedWeaponCode $rangedWeaponCode
     * @param Speed $speed
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     */
    private function getEncounterRangeBonusBySpeed(RangedWeaponCode $rangedWeaponCode, Speed $speed)
    {
        if (!$rangedWeaponCode->isThrowingWeapon()) {
            return 0;
        }

        return SumAndRound::half($speed->getValue());
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
        return $this->tables->getArmorStrengthSanctionsTable()->getAgilityMalus(
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
        return $this->tables->getArmorStrengthSanctionsTable()->getSanctionDescription(
            $this->getMissingStrengthForArmament($armorCode, $currentStrength, $bodySize)
        );
    }

    // MISSING WEAPON SKILL

    /**
     * Note about shields: there is no such skill as FightWithShields, any attempt to fight with shield results into
     * zero skill rank.
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
     * Note about shields: there is no such skill as FightWithShields, any attempt to fight with shield results into
     * zero skill rank.
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
     * Note about shields: there is no such skill as FightWithShields, any attempt to fight with shield results into
     * zero skill rank.
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