<?php
namespace DrdPlus\Tables\Armaments;

use DrdPlus\Codes\ArmamentCode;
use DrdPlus\Codes\ArmorCode;
use DrdPlus\Codes\BodyArmorCode;
use DrdPlus\Codes\HelmCode;
use DrdPlus\Codes\MeleeArmamentCode;
use DrdPlus\Codes\MeleeWeaponCode;
use DrdPlus\Codes\RangeWeaponCode;
use DrdPlus\Codes\ShieldCode;
use DrdPlus\Codes\WeaponCode;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Body\Size;
use DrdPlus\Tables\Armaments\Exceptions\CanNotUseArmorBecauseOfMissingStrength;
use DrdPlus\Tables\Armaments\Exceptions\UnknownArmor;
use DrdPlus\Tables\Armaments\Exceptions\UnknownArmament;
use DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeArmament;
use DrdPlus\Tables\Armaments\Partials\AbstractArmamentsTable;
use DrdPlus\Tables\Armaments\Exceptions\UnknownShield;
use DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength;
use DrdPlus\Tables\Armaments\Exceptions\UnknownWeapon;
use DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeapon;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode;
use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTable;
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

    /**
     * Note: spear can be both range and melee, but required strength is for melee and range usages the same
     *
     * @param ArmamentCode $armamentCode
     * @param Strength $currentStrength
     * @param Size $bodySize
     * @return bool
     * @throws UnknownArmament
     */
    public function canUseArmament(ArmamentCode $armamentCode, Strength $currentStrength, Size $bodySize)
    {
        $missingStrength = $this->getMissingStrengthForArmament($armamentCode, $currentStrength, $bodySize);
        if ($armamentCode instanceof MeleeWeaponCode) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->tables->getMeleeWeaponSanctionsByMissingStrengthTable()->canUseWeapon($missingStrength);
        }
        if ($armamentCode instanceof RangeWeaponCode) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->tables->getRangeWeaponSanctionsByMissingStrengthTable()->canUseWeapon($missingStrength);
        }
        if ($armamentCode instanceof ShieldCode) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->tables->getShieldSanctionsByMissingStrengthTable()->canUseShield($missingStrength);
        }
        if ($armamentCode instanceof ArmorCode) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->tables->getArmorSanctionsByMissingStrengthTable()->canMove($missingStrength);
        }

        throw new UnknownArmament("Unknown type of armament '{$armamentCode}'");
    }

    /**
     * @param ArmamentCode $armamentCode
     * @param Size $bodySize
     * @param Strength $currentStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     */
    public function getMissingStrengthForArmament(ArmamentCode $armamentCode, Strength $currentStrength, Size $bodySize)
    {
        if ($armamentCode instanceof MeleeWeaponCode) {
            return $this->calculateMissingStrengthForArmament(
                $this->getTableByMeleeWeaponCode($armamentCode),
                $armamentCode,
                $currentStrength
            );
        }
        if ($armamentCode instanceof RangeWeaponCode) {
            return $this->calculateMissingStrengthForArmament(
                $this->getTableByRangeWeaponCode($armamentCode),
                $armamentCode,
                $currentStrength
            );
        }
        if ($armamentCode instanceof ShieldCode) {
            return $this->calculateMissingStrengthForArmament(
                $this->tables->getShieldsTable(),
                $armamentCode,
                $currentStrength
            );
        }
        if ($armamentCode instanceof ArmorCode) {
            /** See PPH page 91, right column */
            return $this->calculateMissingStrengthForArmament(
                $this->getArmorsTableByArmorCode($armamentCode),
                $armamentCode,
                $currentStrength,
                $bodySize
            );
        }
        throw new UnknownArmament("Unknown type of armament '{$armamentCode}'");
    }

    /**
     * See PPH page 91, right column
     *
     * @param AbstractArmamentsTable $abstractArmamentsTable
     * @param ArmamentCode $armamentCode
     * @param Strength $currentStrength
     * @param Size $size
     * @return int
     */
    private function calculateMissingStrengthForArmament(
        AbstractArmamentsTable $abstractArmamentsTable,
        ArmamentCode $armamentCode,
        Strength $currentStrength,
        Size $size = null
    )
    {
        $requiredStrength = $abstractArmamentsTable->getRequiredStrengthOf($armamentCode);
        $missingStrength = $requiredStrength - $currentStrength->getValue();
        if ($size !== null) {
            $missingStrength += $size->getValue();
        }
        if ($missingStrength < 0) {
            return 0;
        }

        return $missingStrength;
    }

    /**
     * @param ArmorCode $armorCode
     * @return Armors\BodyArmorsTable|Armors\HelmsTable
     * @throws UnknownArmor
     */
    private function getArmorsTableByArmorCode(ArmorCode $armorCode)
    {
        if ($armorCode instanceof BodyArmorCode) {
            return $this->tables->getBodyArmorsTable();
        }
        if ($armorCode instanceof HelmCode) {
            return $this->tables->getHelmsTable();
        }

        throw new UnknownArmor();
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
    public function getSanctionDescriptionWithArmor(ArmorCode $armorCode, Strength $currentStrength, Size $bodySize)
    {
        return $this->tables->getArmorSanctionsByMissingStrengthTable()->getSanctionDescription(
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
    public function getAgilityMalusWithArmor(ArmorCode $armorCode, Strength $currentStrength, Size $bodySize)
    {
        return $this->tables->getArmorSanctionsByMissingStrengthTable()->getAgilityMalus(
            $this->getMissingStrengthForArmament($armorCode, $currentStrength, $bodySize)
        );
    }

    /**
     * @param MeleeWeaponCode $meleeWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeapon
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    private function getMissingStrengthForMeleeWeapon(MeleeWeaponCode $meleeWeaponCode, Strength $currentStrength)
    {
        return $this->calculateMissingStrengthForArmament(
            $this->getTableByMeleeWeaponCode($meleeWeaponCode),
            $meleeWeaponCode,
            $currentStrength
        );
    }

    /**
     * @param MeleeWeaponCode $meleeWeaponCode
     * @return MeleeWeaponsTable
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeapon
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
        if ($meleeWeaponCode->isMorningstarOrMorgenstern()) {
            return $this->tables->getMorningstarsAndMorgensternsTable();
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
        throw new UnknownMeleeWeapon(
            "Given melee weapon of code '{$meleeWeaponCode}' does not belongs to any known type"
        );
    }

    /**
     * @param WeaponCode $weaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws UnknownArmament
     * @throws Exceptions\UnknownWeapon
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getFightNumberMalusWithWeapon(WeaponCode $weaponCode, Strength $currentStrength)
    {
        try {
            $missingStrength = $this->getMissingStrengthForArmament($weaponCode, $currentStrength, Size::getIt(0));
        } catch (UnknownArmament $unknownArmament) {
            throw new Exceptions\UnknownWeapon("Unknown type of weapon '{$weaponCode}'");
        }
        if ($weaponCode instanceof MeleeWeaponCode) {
            return $this->tables->getMeleeWeaponSanctionsByMissingStrengthTable()->getFightNumberSanction($missingStrength);
        }
        if ($weaponCode instanceof RangeWeaponCode) {
            return $this->tables->getRangeWeaponSanctionsByMissingStrengthTable()->getFightNumberSanction($missingStrength);
        }
        if ($weaponCode instanceof ShieldCode) {
            return $this->tables->getShieldSanctionsByMissingStrengthTable()->getFightNumberSanction($missingStrength);
        }
        throw new Exceptions\UnknownWeapon("Unknown type of weapon '{$weaponCode}'");
    }

    /**
     * @param WeaponCode $weaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws UnknownWeapon
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeapon
     */
    public function getAttackNumberMalusWithWeapon(WeaponCode $weaponCode, Strength $currentStrength)
    {
        if ($weaponCode instanceof MeleeWeaponCode) {
            return $this->getMeleeWeaponAttackNumberMalus($weaponCode, $currentStrength);
        }
        if ($weaponCode instanceof RangeWeaponCode) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->getRangeWeaponAttackNumberMalus($weaponCode, $currentStrength);
        }
        if ($weaponCode instanceof ShieldCode) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->tables->getShieldSanctionsByMissingStrengthTable()
                ->getAttackNumberSanction($currentStrength->getValue());
        }
        throw new UnknownWeapon("Unknown type of weapon '{$weaponCode}'");
    }

    /**
     * @param MeleeWeaponCode $meleeWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeapon
     */
    private function getMeleeWeaponAttackNumberMalus(MeleeWeaponCode $meleeWeaponCode, Strength $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getMeleeWeaponSanctionsByMissingStrengthTable()->getAttackNumberSanction(
            $this->getMissingStrengthForMeleeWeapon($meleeWeaponCode, $currentStrength)
        );
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    private function getRangeWeaponAttackNumberMalus(RangeWeaponCode $rangeWeaponCode, Strength $currentStrength)
    {
        return $this->tables->getRangeWeaponSanctionsByMissingStrengthTable()->getAttackNumberSanction(
            $this->getMissingStrengthForArmament($rangeWeaponCode, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * @param MeleeArmamentCode $meleeArmamentCode
     * @param Strength $currentStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeArmament
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     * @throws \DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getDefenseNumberMalusWithMeleeArmament(MeleeArmamentCode $meleeArmamentCode, Strength $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        try {
            $missingStrength = $this->getMissingStrengthForArmament($meleeArmamentCode, $currentStrength, Size::getIt(0));
        } catch (UnknownArmament $unknownArmament) {
            throw new Exceptions\UnknownMeleeArmament("Unknown type of melee armament '{$meleeArmamentCode}'");
        }
        if ($meleeArmamentCode instanceof MeleeWeaponCode) {
            return $this->tables->getMeleeWeaponSanctionsByMissingStrengthTable()->getDefenseNumberSanction($missingStrength);
        }
        if ($meleeArmamentCode instanceof ShieldCode) {
            return $this->tables->getShieldSanctionsByMissingStrengthTable()->getDefenseNumberSanction($missingStrength);
        }
        throw new Exceptions\UnknownMeleeArmament("Unknown type of melee armament '{$meleeArmamentCode}'");
    }

    /**
     * @param WeaponCode $weaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws UnknownWeapon
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getBaseOfWoundsMalusWithWeapon(WeaponCode $weaponCode, Strength $currentStrength)
    {
        try {
            $missingStrength = $this->getMissingStrengthForArmament($weaponCode, $currentStrength, Size::getIt(0));
        } catch (UnknownArmament $unknownArmament) {
            throw new UnknownWeapon("Unknown type of weapon '{$weaponCode}'");
        }
        if ($weaponCode instanceof MeleeWeaponCode) {
            return $this->tables->getMeleeWeaponSanctionsByMissingStrengthTable()->getBaseOfWoundsSanction($missingStrength);
        }
        if ($weaponCode instanceof RangeWeaponCode) {
            return $this->tables->getRangeWeaponSanctionsByMissingStrengthTable()->getBaseOfWoundsSanction($missingStrength);
        }
        if ($weaponCode instanceof ShieldCode) {
            return $this->tables->getShieldSanctionsByMissingStrengthTable()->getBaseOfWoundsSanction($missingStrength);
        }
        throw new UnknownWeapon("Unknown type of weapon '{$weaponCode}'");
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @return RangeWeaponsTable
     * @throws \DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode
     */
    private function getTableByRangeWeaponCode(RangeWeaponCode $rangeWeaponCode)
    {
        if ($rangeWeaponCode->isArrow()) {
            return $this->tables->getArrowsTable();
        }
        if ($rangeWeaponCode->isBow()) {
            return $this->tables->getBowsTable();
        }
        if ($rangeWeaponCode->isCrossbow()) {
            return $this->tables->getCrossbowsTable();
        }
        if ($rangeWeaponCode->isDart()) {
            return $this->tables->getDartsTable();
        }
        if ($rangeWeaponCode->isSlingStone()) {
            return $this->tables->getSlingStonesTable();
        }
        if ($rangeWeaponCode->isThrowingWeapon()) {
            return $this->tables->getThrowingWeaponsTable();
        }
        throw new UnknownRangeWeaponCode(
            "Given range weapon of code '{$rangeWeaponCode}' does not belongs to any known type"
        );
    }

    /**
     * @param WeaponCode $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownWeapon
     */
    public function getRequiredStrengthForWeapon(WeaponCode $weaponCode)
    {
        if ($weaponCode instanceof MeleeWeaponCode) {
            return $this->getTableByMeleeWeaponCode($weaponCode)->getRequiredStrengthOf($weaponCode);
        }
        /* note: bow gives the minimal strength needed to be used without a malus, not the maximal applicable strength
           which usable only for result damage */
        if ($weaponCode instanceof RangeWeaponCode) {
            return $this->getTableByRangeWeaponCode($weaponCode)->getRequiredStrengthOf($weaponCode);
        }
        if ($weaponCode instanceof ShieldCode) {
            return $this->tables->getShieldsTable()->getRequiredStrengthOf($weaponCode);
        }
        throw new Exceptions\UnknownWeapon("Unknown type of weapon '{$weaponCode}'");
    }

    /**
     * @param MeleeArmamentCode $meleeArmamentCode
     * @return int
     * @throws Exceptions\UnknownMeleeArmament
     */
    public function getLengthOfMeleeArmament(MeleeArmamentCode $meleeArmamentCode)
    {
        if ($meleeArmamentCode instanceof MeleeWeaponCode) {
            return $this->getTableByMeleeWeaponCode($meleeArmamentCode)->getLengthOf($meleeArmamentCode);
        }
        if ($meleeArmamentCode instanceof ShieldCode) {
            return 0;
        }
        throw new Exceptions\UnknownMeleeArmament("Unknown type of weapon '{$meleeArmamentCode}'");
    }

    /**
     * @param WeaponCode $weaponCode
     * @return int
     * @throws Exceptions\UnknownWeapon
     */
    public function getOffensivenessOfWeapon(WeaponCode $weaponCode)
    {
        if ($weaponCode instanceof MeleeWeaponCode) {
            return $this->getTableByMeleeWeaponCode($weaponCode)->getOffensivenessOf($weaponCode);
        }
        if ($weaponCode instanceof RangeWeaponCode) {
            return $this->getTableByRangeWeaponCode($weaponCode)->getOffensivenessOf($weaponCode);
        }
        if ($weaponCode instanceof ShieldCode) {
            return $this->tables->getShieldsTable()->getOffensivenessOf($weaponCode);
        }
        throw new Exceptions\UnknownWeapon("Unknown type of weapon '{$weaponCode}'");
    }

    /**
     * @param WeaponCode $weaponCode
     * @return int
     * @throws Exceptions\UnknownWeapon
     */
    public function getWoundsOfWeapon(WeaponCode $weaponCode)
    {
        if ($weaponCode instanceof MeleeWeaponCode) {
            return $this->getTableByMeleeWeaponCode($weaponCode)->getWoundsOf($weaponCode);
        }
        if ($weaponCode instanceof RangeWeaponCode) {
            return $this->getTableByRangeWeaponCode($weaponCode)->getWoundsOf($weaponCode);
        }
        if ($weaponCode instanceof ShieldCode) {
            return $this->tables->getShieldsTable()->getWoundsOf($weaponCode);
        }
        throw new Exceptions\UnknownWeapon("Unknown type of weapon '{$weaponCode}'");
    }

    /**
     * @param WeaponCode $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownWeapon
     */
    public function getWoundsTypeOfWeapon(WeaponCode $weaponCode)
    {
        if ($weaponCode instanceof MeleeWeaponCode) {
            return $this->getTableByMeleeWeaponCode($weaponCode)->getWoundsTypeOf($weaponCode);
        }
        if ($weaponCode instanceof RangeWeaponCode) {
            return $this->getTableByRangeWeaponCode($weaponCode)->getWoundsTypeOf($weaponCode);
        }
        if ($weaponCode instanceof ShieldCode) {
            return $this->tables->getShieldsTable()->getWoundsTypeOf($weaponCode);
        }
        throw new Exceptions\UnknownWeapon("Unknown type of weapon '{$weaponCode}'");
    }

    /**
     * @param MeleeArmamentCode $meleeArmamentCode
     * @return int
     * @throws UnknownMeleeWeapon
     * @throws UnknownShield
     * @throws UnknownMeleeArmament
     */
    public function getCoverOfMeleeArmament(MeleeArmamentCode $meleeArmamentCode)
    {
        if ($meleeArmamentCode instanceof MeleeWeaponCode) {
            return $this->getTableByMeleeWeaponCode($meleeArmamentCode)->getCoverOf($meleeArmamentCode);
        }
        if ($meleeArmamentCode instanceof ShieldCode) {
            return $this->tables->getShieldsTable()->getCoverOf($meleeArmamentCode);
        }
        throw new Exceptions\UnknownMeleeArmament("Unknown type of melee armament {$meleeArmamentCode}");
    }

    /**
     * @param ArmamentCode $armamentCode
     * @return int
     * @throws Exceptions\UnknownArmament
     */
    public function getWeightOfArmament(ArmamentCode $armamentCode)
    {
        if ($armamentCode instanceof MeleeWeaponCode) {
            return $this->getTableByMeleeWeaponCode($armamentCode)->getWeightOf($armamentCode);
        }
        if ($armamentCode instanceof RangeWeaponCode) {
            return $this->getTableByRangeWeaponCode($armamentCode)->getWeightOf($armamentCode);
        }
        if ($armamentCode instanceof ShieldCode) {
            return $this->tables->getShieldsTable()->getWeightOf($armamentCode);
        }
        if ($armamentCode instanceof ArmorCode) {
            return $this->getArmorsTableByArmorCode($armamentCode)->getWeightOf($armamentCode);
        }
        throw new Exceptions\UnknownArmament("Unknown type of armament '{$armamentCode}'");
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getLoadingInRoundsWithRangeWeapon(RangeWeaponCode $rangeWeaponCode, Strength $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $missingStrength = $this->getMissingStrengthForArmament($rangeWeaponCode, $currentStrength, Size::getIt(0));

        return $this->tables->getRangeWeaponSanctionsByMissingStrengthTable()->getLoadingInRounds($missingStrength);
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getLoadingInRoundsMalusWithRangeWeapon(RangeWeaponCode $rangeWeaponCode, Strength $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $missingStrength = $this->getMissingStrengthForArmament($rangeWeaponCode, $currentStrength, Size::getIt(0));

        return $this->tables->getRangeWeaponSanctionsByMissingStrengthTable()->getLoadingInRoundsSanction($missingStrength);
    }

    /**
     * @param RangeWeaponCode $rangeWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getEncounterRangeMalusWithRangeWeapon(RangeWeaponCode $rangeWeaponCode, Strength $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $missingStrength = $this->getMissingStrengthForArmament($rangeWeaponCode, $currentStrength, Size::getIt(0));

        return $this->tables->getRangeWeaponSanctionsByMissingStrengthTable()->getEncounterRangeSanction($missingStrength);
    }

    /**
     * @param WeaponCode $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownWeapon
     */
    public function getRangeOfRangeWeapon(WeaponCode $weaponCode)
    {
        if ($weaponCode instanceof MeleeWeaponCode) {
            return 0;
        }
        if ($weaponCode instanceof RangeWeaponCode) {
            return $this->getTableByRangeWeaponCode($weaponCode)->getRangeOf($weaponCode);
        }
        throw new UnknownWeapon('Unknown type of weapon code ' . $weaponCode);
    }
}