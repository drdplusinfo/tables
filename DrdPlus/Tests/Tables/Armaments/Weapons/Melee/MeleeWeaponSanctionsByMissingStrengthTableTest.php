<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons;

use DrdPlus\Tables\Armaments\Weapons\Melee\MeleeWeaponSanctionsByMissingStrengthTable;
use DrdPlus\Tests\Tables\Armaments\Partials\AbstractMeleeArmamentSanctionsByMissingStrengthTableTest;

class MeleeWeaponSanctionsByMissingStrengthTableTest extends AbstractMeleeArmamentSanctionsByMissingStrengthTableTest
{
    /**
     * @test
     */
    public function I_can_ask_it_if_can_use_weapon()
    {
        self::assertTrue((new MeleeWeaponSanctionsByMissingStrengthTable())->canUseWeapon(-999));
        self::assertTrue((new MeleeWeaponSanctionsByMissingStrengthTable())->canUseWeapon(10));
        self::assertFalse((new MeleeWeaponSanctionsByMissingStrengthTable())->canUseWeapon(11));
    }
}