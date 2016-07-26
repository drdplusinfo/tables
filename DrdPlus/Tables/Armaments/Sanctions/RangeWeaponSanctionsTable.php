<?php
namespace DrdPlus\Tables\Armaments\Sanctions;

class RangeWeaponSanctionsTable extends AbstractSanctionsForMissingStrengthTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/range_weapon_sanctions.csv';
    }

    const FIGHT_NUMBER = 'fight_number';
    const LOADING = 'loading';
    const ATTACK_NUMBER = 'attack_number';
    const ENCOUNTER_RANGE = 'encounter_range';
    const BASE_OF_WOUNDS = 'base_of_wounds';
    const CAN_USE_WEAPON = 'can_use_weapon';

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::MISSING_STRENGTH => self::POSITIVE_INTEGER,
            self::FIGHT_NUMBER => self::NEGATIVE_INTEGER,
            self::LOADING => self::POSITIVE_INTEGER,
            self::ATTACK_NUMBER => self::NEGATIVE_INTEGER,
            self::ENCOUNTER_RANGE => self::NEGATIVE_INTEGER,
            self::BASE_OF_WOUNDS => self::NEGATIVE_INTEGER,
            self::CAN_USE_WEAPON => self::BOOLEAN,
        ];
    }

    /**
     * @param int $missingStrength
     * @return bool
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function canUseWeapon($missingStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getSanctionOf(
            $missingStrength,
            self::CAN_USE_WEAPON,
            false /* do not check missing strength before value determination */
        );
    }

    /**
     * @param int $missingStrength
     * @return int
     * @throws Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getFightNumberSanction($missingStrength)
    {
        return $this->getSanctionOf($missingStrength, self::FIGHT_NUMBER);
    }

    /**
     * @param int $missingStrength
     * @param string $columnName
     * @param bool $guardMaximumMissingStrength
     * @return int
     * @throws Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    private function getSanctionOf($missingStrength, $columnName, $guardMaximumMissingStrength = true)
    {
        if ($guardMaximumMissingStrength && !$this->canUseWeapon($missingStrength)) {
            throw new Exceptions\CanNotUseWeaponBecauseOfMissingStrength(
                "Too much missing strength {$missingStrength} to bear a shooting weapon"
            );
        }

        return $this->getSanctionsForMissingStrength($missingStrength)[$columnName];
    }

    /**
     * @param int $missingStrength
     * @return int
     * @throws Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getLoadingSanction($missingStrength)
    {
        return $this->getSanctionOf($missingStrength, self::LOADING);
    }

    /**
     * @param int $missingStrength
     * @return int
     * @throws Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getAttackNumberSanction($missingStrength)
    {
        return $this->getSanctionOf($missingStrength, self::ATTACK_NUMBER);
    }

    /**
     * @param int $missingStrength
     * @return int
     * @throws Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getEncounterRangeSanction($missingStrength)
    {
        return $this->getSanctionOf($missingStrength, self::ENCOUNTER_RANGE);
    }

    /**
     * @param int $missingStrength
     * @return int
     * @throws Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getBaseOfWoundsSanction($missingStrength)
    {
        return $this->getSanctionOf($missingStrength, self::BASE_OF_WOUNDS);
    }

}