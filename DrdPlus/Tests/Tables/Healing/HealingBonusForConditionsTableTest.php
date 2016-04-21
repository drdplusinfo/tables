<?php
namespace DrdPlus\Tests\Tables\Healing;

use DrdPlus\Codes\EnvironmentConditionsTypeCodesTable;
use DrdPlus\Tables\Healing\HealingBonusForConditionsTable;
use DrdPlus\Tests\Tables\TableTest;

class HealingBonusForConditionsTableTest extends \PHPUnit_Framework_TestCase implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $healingBonusForConditionsTable = new HealingBonusForConditionsTable();
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
        $healingBonusForConditionsTable = new HealingBonusForConditionsTable();
        self::assertSame($expectedBonus, $healingBonusForConditionsTable->getHealingBonusForConditions($conditionsCode));
    }

    public function provideBonusWithConditionsCode()
    {
        return [
            [[-6], EnvironmentConditionsTypeCodesTable::FOUL_CONDITIONS],
            [[-5, -3], EnvironmentConditionsTypeCodesTable::BAD_CONDITIONS],
            [[-2, -1], EnvironmentConditionsTypeCodesTable::IMPAIRED_CONDITIONS],
            [[0], EnvironmentConditionsTypeCodesTable::GOOD_CONDITIONS],
        ];
    }
}