<?php
namespace DrdPlus\Tests\Tables\Healing;

use DrdPlus\Codes\ActivityTypeCodes;
use DrdPlus\Tables\Healing\HealingBonusByActivityTable;
use DrdPlus\Tests\Tables\TableTest;

class HealingBonusByActivityTableTest extends \PHPUnit_Framework_TestCase implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $healingBonusByPersonActionsTable = new HealingBonusByActivityTable();
        self::assertSame([['situation', 'bonus']], $healingBonusByPersonActionsTable->getHeader());
    }

    /**
     * @test
     * @dataProvider provideActivityNameWithBonus
     * @param int $expectedBonus
     * @param string $activityName
     */
    public function I_can_get_healing_bonus_for_every_activity($expectedBonus, $activityName)
    {
        $healingBonusByPersonActionsTable = new HealingBonusByActivityTable();
        self::assertSame($expectedBonus, $healingBonusByPersonActionsTable->getHealingBonusForActivity($activityName));
    }

    public function provideActivityNameWithBonus()
    {
        return [
            [0, ActivityTypeCodes::SLEEPING_OR_REST_IN_BED],
            [-2, ActivityTypeCodes::LOUNGING_AND_RESTING],
            [-4, ActivityTypeCodes::LIGHT_ACTIVITY],
            [-6, ActivityTypeCodes::NORMAL_ACTIVITY],
            [-8, ActivityTypeCodes::TOILSOME_ACTIVITY],
            [-10, ActivityTypeCodes::VERY_HARD_ACTIVITY]
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Healing\Exceptions\UnknownActivityOnHealing
     * @expectedExceptionMessageRegExp ~swimming_with_dolphins~
     */
    public function I_can_not_get_healing_bonus_for_unknown_activity()
    {
        (new HealingBonusByActivityTable())->getHealingBonusForActivity('swimming_with_dolphins');
    }

}
