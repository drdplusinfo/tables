<?php
namespace DrdPlus\Tables\Armaments\Sanctions;

class MeleeWeaponSanctionsTable extends AbstractSanctionsForMissingStrengthTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/melee_weapon_sanctions.csv';
    }

    const FIGHT_NUMBER = 'fight_number';
    const ATTACK_NUMBER = 'attack_number';
    const DEFENSE_NUMBER = 'defense_number';
    const BASE_OF_WOUNDS = 'base_of_wounds';
    const CAN_USE_WEAPON = 'can_use_weapon';

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::MISSING_STRENGTH => self::POSITIVE_INTEGER,
            self::FIGHT_NUMBER => self::NEGATIVE_INTEGER,
            self::ATTACK_NUMBER => self::NEGATIVE_INTEGER,
            self::DEFENSE_NUMBER => self::NEGATIVE_INTEGER,
            self::BASE_OF_WOUNDS => self::NEGATIVE_INTEGER,
            self::CAN_USE_WEAPON => self::BOOLEAN,
        ];
    }

}