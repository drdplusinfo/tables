<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Tables\Armaments\Weapons\Melee\MeleeWeaponSanctionsByMissingStrengthTable;
use DrdPlus\Tests\Tables\Armaments\Partials\AbstractMeleeWeaponlikeSanctionsByMissingStrengthTableTest;

class MeleeWeaponSanctionsByMissingStrengthTableTest extends AbstractMeleeWeaponlikeSanctionsByMissingStrengthTableTest
{
    /**
     * @test
     */
    public function I_can_ask_it_if_can_use_weapon()
    {
        self::assertTrue((new MeleeWeaponSanctionsByMissingStrengthTable())->canUseIt(-999));
        self::assertTrue((new MeleeWeaponSanctionsByMissingStrengthTable())->canUseIt(10));
        self::assertFalse((new MeleeWeaponSanctionsByMissingStrengthTable())->canUseIt(11));
    }
}