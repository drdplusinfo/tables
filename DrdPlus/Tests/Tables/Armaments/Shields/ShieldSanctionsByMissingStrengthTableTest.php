<?php
namespace DrdPlus\Tests\Tables\Armaments\Shields;

use DrdPlus\Tables\Armaments\Shields\ShieldSanctionsByMissingStrengthTable;
use DrdPlus\Tests\Tables\Armaments\Partials\AbstractMeleeArmamentSanctionsByMissingStrengthTableTest;

class ShieldSanctionsByMissingStrengthTableTest extends AbstractMeleeArmamentSanctionsByMissingStrengthTableTest
{
    /**
     * @test
     */
    public function I_can_ask_it_if_can_use_shield()
    {
        self::assertTrue((new ShieldSanctionsByMissingStrengthTable())->canUseShield(-999));
        self::assertTrue((new ShieldSanctionsByMissingStrengthTable())->canUseShield(10));
        self::assertFalse((new ShieldSanctionsByMissingStrengthTable())->canUseShield(11));
    }
}