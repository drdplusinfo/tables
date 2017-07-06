<?php
namespace DrdPlus\Tables\Armaments\Weapons\Ranged;

use DrdPlus\Tables\Armaments\Partials\AbstractStrengthSanctionsTable;
use DrdPlus\Tables\Armaments\Partials\WeaponStrengthSanctionsInterface;
use DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength;
use Granam\Integer\IntegerInterface;

/**
 * See PPH page 95 right column, @link https://pph.drdplus.info/#tabulka_postihu_za_strelne_zbrane
 */
class RangedWeaponStrengthSanctionsTable extends AbstractStrengthSanctionsTable
    implements WeaponStrengthSanctionsInterface
{
    /**
     * @return string
     */
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/range_weapon_strength_sanctions.csv';
    }

    const FIGHT_NUMBER = 'fight_number';
    const LOADING_IN_ROUNDS = 'loading_in_rounds';
    const ATTACK_NUMBER = 'attack_number';
    const DEFENSE_NUMBER = 'defense_number';
    const ENCOUNTER_RANGE = 'encounter_range';
    const BASE_OF_WOUNDS = 'base_of_wounds';
    const CAN_USE_WEAPON = 'can_use_weapon';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes(): array
    {
        return [
            self::MISSING_STRENGTH => self::POSITIVE_INTEGER,
            self::FIGHT_NUMBER => self::NEGATIVE_INTEGER,
            self::LOADING_IN_ROUNDS => self::POSITIVE_INTEGER,
            self::ATTACK_NUMBER => self::NEGATIVE_INTEGER,
            self::DEFENSE_NUMBER => self::NEGATIVE_INTEGER,
            self::ENCOUNTER_RANGE => self::NEGATIVE_INTEGER,
            self::BASE_OF_WOUNDS => self::NEGATIVE_INTEGER,
            self::CAN_USE_WEAPON => self::BOOLEAN,
        ];
    }

    /**
     * @param int|IntegerInterface $missingStrength
     * @return bool
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function canUseIt($missingStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getSanctionOf(
            $missingStrength,
            self::CAN_USE_WEAPON,
            false /* do NOT check missing strength before value determination */
        );
    }

    /**
     * @param int|IntegerInterface $missingStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getFightNumberSanction($missingStrength)
    {
        return $this->getSanctionOf($missingStrength, self::FIGHT_NUMBER);
    }

    /**
     * @param int|IntegerInterface $missingStrength
     * @param string $columnName
     * @param bool $guardMaximumMissingStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    private function getSanctionOf($missingStrength, $columnName, $guardMaximumMissingStrength = true)
    {
        if ($guardMaximumMissingStrength && !$this->canUseIt($missingStrength)) {
            throw new CanNotUseWeaponBecauseOfMissingStrength(
                "Too much missing strength {$missingStrength} to use a range weapon"
            );
        }

        return $this->getSanctionsForMissingStrength($missingStrength)[$columnName];
    }

    /**
     * @param int|IntegerInterface $missingStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getDefenseNumberSanction($missingStrength)
    {
        return $this->getSanctionOf($missingStrength, self::DEFENSE_NUMBER);
    }

    /**
     * @param int|IntegerInterface $missingStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getLoadingInRounds($missingStrength)
    {
        return $this->getSanctionOf($missingStrength, self::LOADING_IN_ROUNDS);
    }

    /**
     * @param int|IntegerInterface $missingStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getLoadingInRoundsSanction($missingStrength)
    {
        return max($this->getLoadingInRounds($missingStrength) - 1, 0);
    }

    /**
     * @param int|IntegerInterface $missingStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getAttackNumberSanction($missingStrength)
    {
        return $this->getSanctionOf($missingStrength, self::ATTACK_NUMBER);
    }

    /**
     * @param int|IntegerInterface $missingStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getEncounterRangeSanction($missingStrength)
    {
        return $this->getSanctionOf($missingStrength, self::ENCOUNTER_RANGE);
    }

    /**
     * @param int|IntegerInterface $missingStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getBaseOfWoundsSanction($missingStrength)
    {
        return $this->getSanctionOf($missingStrength, self::BASE_OF_WOUNDS);
    }

}