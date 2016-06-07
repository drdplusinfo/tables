<?php
namespace DrdPlus\Tests\Tables\Body\Healing;

use DrdPlus\Codes\EnvironmentConditionsTypeCodes;
use DrdPlus\Tables\Body\Healing\HealingByConditionsTable;
use DrdPlus\Tests\Tables\TableTest;

class HealingByConditionsTableTest extends \PHPUnit_Framework_TestCase implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $healingBonusForConditionsTable = new HealingByConditionsTable();
        self::assertSame([['situation', 'bonus']], $healingBonusForConditionsTable->getHeader());
    }

    /**
     * @test
     * @dataProvider provideBonusWithConditionsCode
     * @param int $expectedBonus
     * @param string $conditionsCode
     */
    public function I_can_get_bonus_for_every_conditions($expectedBonus, $conditionsCode)
    {
        $healingBonusForConditionsTable = new HealingByConditionsTable();
        self::assertSame($expectedBonus, $healingBonusForConditionsTable->getHealingBonusByConditions($conditionsCode));
    }

    public function provideBonusWithConditionsCode()
    {
        return [
            [[-6], EnvironmentConditionsTypeCodes::FOUL_CONDITIONS],
            [[-5, -3], EnvironmentConditionsTypeCodes::BAD_CONDITIONS],
            [[-2, -1], EnvironmentConditionsTypeCodes::IMPAIRED_CONDITIONS],
            [[0], EnvironmentConditionsTypeCodes::GOOD_CONDITIONS],
        ];
    }
}