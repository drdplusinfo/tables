<?php
namespace DrdPlus\Tables\Armaments;

use DrdPlus\Codes\Armaments\ArmamentCode;
use DrdPlus\Codes\Armaments\ArmorCode;
use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\Armaments\MeleeWeaponlikeCode;
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
use DrdPlus\Tables\Measurements\Distance\Distance;
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
     * Note about shield: every shield is considered as a weapon of length 0 if used for attack.
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @return int
     * @throws Exceptions\UnknownMeleeWeaponlike
     */
    public function getLengthOfWeaponlike(WeaponlikeCode $weaponlikeCode)
    {
        if ($weaponlikeCode instanceof MeleeWeaponlikeCode) {
            return $this->tables->getMeleeWeaponlikeTableByMeleeWeaponlikeCode($weaponlikeCode)
                ->getLengthOf($weaponlikeCode);
        }

        return 0; // ranged weapons do not have bonus to fight number for their length, surprisingly
    }

    /**
     * Even shield can ba used as weapon, just quite ineffective.
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @return int
     * @throws Exceptions\UnknownWeaponlike
     */
    public function getWoundsOfWeaponlike(WeaponlikeCode $weaponlikeCode)
    {
        return $this->tables->getWeaponlikeTableByWeaponlikeCode($weaponlikeCode)->getWoundsOf($weaponlikeCode);
    }

    /**
     * Even shield can ba used as weapon, just quite ineffective.
     *
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
    public function getCoverOfWeaponOrShield(WeaponlikeCode $weaponlikeCode)
    {
        return $this->tables->getWeaponlikeTableByWeaponlikeCode($weaponlikeCode)->getCoverOf($weaponlikeCode);
    }

    /**
     * Even shield can ba used as weapon, just quite ineffective.
     *
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


    // shield-and-armor-specific

    /**
     * Restriction affects fight number (Fight number malus).
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
     * Note about shield: this malus is applied by the same way if used shield as a protective item as well as a weapon.
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @param Strength $currentStrength
     * @return int
     * @throws Exceptions\UnknownArmament
     * @throws Exceptions\UnknownMeleeWeaponlike
     * @throws Exceptions\UnknownWeaponlike
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getFightNumberMalusByStrengthWithWeaponOrShield(WeaponlikeCode $weaponlikeCode, Strength $currentStrength)
    {
        return $this->tables->getWeaponlikeStrengthSanctionsTableByCode($weaponlikeCode)->getFightNumberSanction(
            $this->getMissingStrengthForArmament($weaponlikeCode, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * Even shield can ba used as weapon, just quite ineffective.
     *
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
    public function getDefenseNumberMalusByStrengthWithWeaponOrShield(WeaponlikeCode $weaponlikeCode, Strength $currentStrength)
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
     * Even shield can ba used as weapon, just quite ineffective.
     *
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
     * Gives bonus to range of a weapon, which can be turned into meters.
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @param Strength $currentStrength
     * @param Speed $currentSpeed
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws UnknownArmament
     * @throws UnknownRangedWeapon
     * @throws UnknownBow
     */
    public function getEncounterRangeWithWeaponlike(
        WeaponlikeCode $weaponlikeCode,
        Strength $currentStrength,
        Speed $currentSpeed
    )
    {
        if (!($weaponlikeCode instanceof RangedWeaponCode)) {
            /** see melee weapon Length in PPH page 85 right column (length in meters is half of weapon length) */
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $weaponLengthInMeters = SumAndRound::half($this->getLengthOfWeaponlike($weaponlikeCode));
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $distance = new Distance($weaponLengthInMeters, Distance::M, $this->tables->getDistanceTable());

            return $distance->getBonus()->getValue();
        }
        $encounterRange = $this->getRangeOfRangedWeapon($weaponlikeCode);
        $encounterRange += $this->getEncounterRangeMalusByStrength($weaponlikeCode, $currentStrength);
        $encounterRange += $this->getEncounterRangeBonusByStrength($weaponlikeCode, $currentStrength);
        $encounterRange += $this->getEncounterRangeBonusBySpeed($weaponlikeCode, $currentSpeed);

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
    public function getFightNumberMalusForSkillRank(PositiveInteger $weaponTypeSkillRank)
    {
        return $this->tables->getMissingWeaponSkillTable()->getFightNumberMalusForSkillRank($weaponTypeSkillRank->getValue());
    }

    /**
     * Note about shields: there is no such skill as FightWithShields, any attempt to fight with shield results into
     * zero skill rank.
     *
     * @param PositiveInteger $weaponTypeSkillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function getAttackNumberMalusForSkillRank(PositiveInteger $weaponTypeSkillRank)
    {
        return $this->tables->getMissingWeaponSkillTable()->getAttackNumberMalusForSkillRank($weaponTypeSkillRank->getValue());
    }

    /**
     * Gives malus to cover with a weapon or a shield according to given skill rank.
     * Warning: PPH gives you invalid info about cover with shield malus on PPH page 86 right column (-2 if you do not
     * have maximal skill). Correct is @see \DrdPlus\Tables\Armaments\Shields\MissingShieldSkillTable
     *
     * @param PositiveInteger $weaponTypeSkillRank
     * @param WeaponlikeCode $weaponOrShield
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function getCoverMalusForSkillRank(PositiveInteger $weaponTypeSkillRank, WeaponlikeCode $weaponOrShield)
    {
        if ($weaponOrShield->isWeapon()) {
            return $this->tables->getMissingWeaponSkillTable()->getCoverMalusForSkillRank($weaponTypeSkillRank->getValue());
        }
        assert($weaponOrShield->isShield());

        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getMissingShieldSkillTable()->getCoverMalusForSkillRank($weaponTypeSkillRank->getValue());
    }

    /**
     * Note about shields: there is no such skill as FightWithShields, any attempt to fight with shield results into
     * zero skill rank.
     *
     * @param PositiveInteger $weaponTypeSkillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function getBaseOfWoundsMalusForSkillRank(PositiveInteger $weaponTypeSkillRank)
    {
        return $this->tables->getMissingWeaponSkillTable()->getBaseOfWoundsMalusForSkillRank($weaponTypeSkillRank->getValue());
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
    public function getProtectiveArmamentRestrictionBonusForSkillRank(
        ProtectiveArmamentCode $protectiveArmamentCode,
        PositiveInteger $protectiveArmamentSkillRank
    )
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getProtectiveArmamentMissingSkillTableByCode($protectiveArmamentCode)
            ->getRestrictionBonusForSkillRank($protectiveArmamentSkillRank->getValue());
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
    public function getProtectiveArmamentRestrictionForSkillRank(
        ProtectiveArmamentCode $protectiveArmamentCode,
        PositiveInteger $protectiveArmamentSkillRank
    )
    {
        $restriction = $this->getRestrictionOfProtectiveArmament($protectiveArmamentCode)
            + $this->getProtectiveArmamentRestrictionBonusForSkillRank($protectiveArmamentCode, $protectiveArmamentSkillRank);
        if ($restriction > 0) {
            return 0; // can not turn into bonus
        }

        return $restriction;
    }

}