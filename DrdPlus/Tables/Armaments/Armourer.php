<?php
namespace DrdPlus\Tables\Armaments;

use DrdPlus\Codes\ArmamentCode;
use DrdPlus\Codes\ArmorCode;
use DrdPlus\Codes\MeleeWeaponlikeCode;
use DrdPlus\Codes\RangeWeaponCode;
use DrdPlus\Codes\WeaponlikeCode;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Body\Size;
use DrdPlus\Tables\Armaments\Exceptions\CanNotUseArmorBecauseOfMissingStrength;
use DrdPlus\Tables\Armaments\Exceptions\UnknownArmament;
use DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeaponlike;
use DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength;
use DrdPlus\Tables\Armaments\Exceptions\UnknownWeapon;
use DrdPlus\Tables\Tables;
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
     * @param MeleeWeaponlikeCode $meleeWeaponlikeCode
     * @return int
     * @throws Exceptions\UnknownMeleeWeaponlike
     */
    public function getLengthOfWeaponlikeCode(MeleeWeaponlikeCode $meleeWeaponlikeCode)
    {
        return $this->tables->getWeaponlikeCodesTableByMeleeWeaponlikeCode($meleeWeaponlikeCode)
            ->getLengthOf($meleeWeaponlikeCode);
    }

    /**
     * @param WeaponlikeCode $weaponCode
     * @return int
     * @throws Exceptions\UnknownWeapon
     */
    public function getWoundsOfWeapon(WeaponlikeCode $weaponCode)
    {
        return $this->tables->getWeaponsTableByWeaponCode($weaponCode)->getWoundsOf($weaponCode);
    }

    /**
     * @param WeaponlikeCode $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownWeapon
     */
    public function getWoundsTypeOfWeapon(WeaponlikeCode $weaponCode)
    {
        return $this->tables->getWeaponsTableByWeaponCode($weaponCode)->getWoundsTypeOf($weaponCode);
    }

    /**
     * @param MeleeWeaponlikeCode $meleeWeaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownWeapon
     */
    public function getCoverOfWeaponlikeCode(MeleeWeaponlikeCode $meleeWeaponlikeCode)
    {
        return $this->tables->getWeaponlikeCodesTableByMeleeWeaponlikeCode($meleeWeaponlikeCode)->getCoverOf($meleeWeaponlikeCode);
    }

    /**
     * @param WeaponlikeCode $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownWeapon
     */
    public function getOffensivenessOfWeapon(WeaponlikeCode $weaponCode)
    {
        return $this->tables->getWeaponsTableByWeaponCode($weaponCode)->getOffensivenessOf($weaponCode);
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
     * @param RangeWeaponCode $rangeWeaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangeWeapon
     */
    public function getRangeOfRangeWeapon(RangeWeaponCode $rangeWeaponCode)
    {
        return $this->tables->getRangeWeaponsTableByRangeWeaponCode($rangeWeaponCode)->getRangeOf($rangeWeaponCode);
    }

    // USING WEAPONS

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
        return $this->tables->getArmamentSanctionsByMissingStrengthTableByWeaponCode($armamentCode)->canUseArmament(
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
     * @param WeaponlikeCode $weaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws Exceptions\UnknownArmament
     * @throws Exceptions\UnknownWeapon
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getFightNumberMalusByStrengthWithWeapon(WeaponlikeCode $weaponCode, Strength $currentStrength)
    {
        return $this->tables->getWeaponSanctionsByMissingStrengthTableByWeaponCode($weaponCode)->getFightNumberSanction(
            $this->getMissingStrengthForArmament($weaponCode, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * @param WeaponlikeCode $weaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws Exceptions\UnknownWeapon
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeapon
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getAttackNumberByStrengthWithWeapon(WeaponlikeCode $weaponCode, Strength $currentStrength)
    {
        return
            $this->getOffensivenessOfWeapon($weaponCode)
            + $this->getAttackNumberMalusByStrengthWithWeapon($weaponCode, $currentStrength);
    }

    /**
     * @param WeaponlikeCode $weaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws Exceptions\UnknownWeapon
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeapon
     */
    public function getAttackNumberMalusByStrengthWithWeapon(WeaponlikeCode $weaponCode, Strength $currentStrength)
    {
        return $this->tables->getWeaponSanctionsByMissingStrengthTableByWeaponCode($weaponCode)->getAttackNumberSanction(
            $this->getMissingStrengthForArmament($weaponCode, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * @param MeleeWeaponlikeCode $meleeWeaponlikeCode
     * @param Strength $currentStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeaponlike
     * @throws \DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getDefenseNumberMalusByStrengthWithWeaponlikeCode(MeleeWeaponlikeCode $meleeWeaponlikeCode, Strength $currentStrength)
    {
        return $this->tables->getWeaponlikeCodeSanctionsByMissingStrengthTableByCode($meleeWeaponlikeCode)->getDefenseNumberSanction(
            $this->getMissingStrengthForArmament($meleeWeaponlikeCode, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * @param WeaponlikeCode $weaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownWeapon
     */
    public function getBaseOfWoundsMalusByStrengthWithWeapon(WeaponlikeCode $weaponCode, Strength $currentStrength)
    {
        return $this->tables->getWeaponSanctionsByMissingStrengthTableByWeaponCode($weaponCode)->getBaseOfWoundsSanction(
            $this->getMissingStrengthForArmament($weaponCode, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getLoadingInRoundsByStrengthWithRangeWeapon(RangeWeaponCode $rangeWeaponCode, Strength $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getRangeWeaponSanctionsByMissingStrengthTable()->getLoadingInRounds(
            $this->getMissingStrengthForArmament($rangeWeaponCode, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getLoadingInRoundsMalusByStrengthWithRangeWeapon(RangeWeaponCode $rangeWeaponCode, Strength $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getRangeWeaponSanctionsByMissingStrengthTable()->getLoadingInRoundsSanction(
            $this->getMissingStrengthForArmament($rangeWeaponCode, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getEncounterRangeMalusByStrengthWithRangeWeapon(RangeWeaponCode $rangeWeaponCode, Strength $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getRangeWeaponSanctionsByMissingStrengthTable()->getEncounterRangeSanction(
            $this->getMissingStrengthForArmament($rangeWeaponCode, $currentStrength, Size::getIt(0))
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
}