<?php
namespace DrdPlus\Tables\Armaments;

use DrdPlus\Codes\ArmamentCode;
use DrdPlus\Codes\ArmorCode;
use DrdPlus\Codes\BodyArmorCode;
use DrdPlus\Codes\HelmCode;
use DrdPlus\Codes\MeleeWeaponCode;
use DrdPlus\Codes\RangeWeaponCode;
use DrdPlus\Tables\Armaments\Armors\AbstractArmorsTable;
use DrdPlus\Tables\Armaments\Partials\AbstractArmamentsTable;
use DrdPlus\Tables\Armaments\Sanctions\MeleeWeaponSanctionsTable;
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
     * @param BodyArmorCode $bodyArmorCode
     * @param int $bodySize
     * @param int $strength
     * @return array|\mixed[]
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getSanctionValuesForBodyArmor(BodyArmorCode $bodyArmorCode, $bodySize, $strength)
    {
        return $this->tables->getArmorSanctionsTable()->getSanctionsForMissingStrength(
            $this->getMissingStrengthForBodyArmor($bodyArmorCode, $bodySize, $strength)
        );
    }

    /**
     * @param BodyArmorCode $bodyArmorCode
     * @param int $bodySize
     * @param int $strength
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getMissingStrengthForBodyArmor(BodyArmorCode $bodyArmorCode, $bodySize, $strength)
    {
        return $this->getMissingStrengthForArmor(
            $this->tables->getBodyArmorsTable(),
            $bodyArmorCode,
            $bodySize,
            $strength
        );
    }

    /**
     * See PPH page 91, right column
     * @param AbstractArmorsTable $armorsTable
     * @param ArmorCode $armorCode
     * @param int $bodySize
     * @param int $strength
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    private function getMissingStrengthForArmor(
        AbstractArmorsTable $armorsTable,
        ArmorCode $armorCode,
        $bodySize,
        $strength
    )
    {
        return max(
            0,
            $this->getMissingStrengthForArmament(
                $armorsTable,
                $armorCode,
                $strength,
                false // give as raw value, even negative
            ) + ToInteger::toInteger($bodySize)
        );
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
     * @param HelmCode $helmCode
     * @param int $bodySize
     * @param int $strength
     * @return array|\mixed[]
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getSanctionValuesForHelm(HelmCode $helmCode, $bodySize, $strength)
    {
        return $this->tables->getArmorSanctionsTable()->getSanctionsForMissingStrength(
            $this->getMissingStrengthForHelm($helmCode, $bodySize, $strength)
        );
    }

    /**
     * @param HelmCode $helmCode
     * @param int $bodySize
     * @param int $strength
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getMissingStrengthForHelm(HelmCode $helmCode, $bodySize, $strength)
    {
        return $this->getMissingStrengthForArmor($this->tables->getHelmsTable(), $helmCode, $bodySize, $strength);
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
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getMeleeWeaponFightNumberMalus(MeleeWeaponCode $meleeWeaponCode, $strength)
    {
        return $this->getSanctionValuesForMeleeWeapon($meleeWeaponCode, $strength)[MeleeWeaponSanctionsTable::FIGHT_NUMBER];
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
        return $this->getSanctionValuesForMeleeWeapon($meleeWeaponCode, $strength)[MeleeWeaponSanctionsTable::ATTACK_NUMBER];
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
        return $this->getSanctionValuesForMeleeWeapon($meleeWeaponCode, $strength)[MeleeWeaponSanctionsTable::DEFENSE_NUMBER];
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
        return $this->getSanctionValuesForMeleeWeapon($meleeWeaponCode, $strength)[MeleeWeaponSanctionsTable::BASE_OF_WOUNDS];
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
        return $this->getSanctionValuesForMeleeWeapon($meleeWeaponCode, $strength)[MeleeWeaponSanctionsTable::CAN_USE_WEAPON];
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

}