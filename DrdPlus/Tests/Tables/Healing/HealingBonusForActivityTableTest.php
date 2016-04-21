<?php
namespace DrdPlus\Tests\Tables\Healing;

use DrdPlus\Codes\ActivityDifficultyTypeCodes;
use DrdPlus\Tables\Healing\HealingBonusForActivityTable;
use DrdPlus\Tests\Tables\TableTest;

class HealingBonusForActivityTableTest extends \PHPUnit_Framework_TestCase implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $healingBonusByPersonActionsTable = new HealingBonusForActivityTable();
        self::assertSame([['situation', 'bonus']], $healingBonusByPersonActionsTable->getHeader());
    }

    /**
     * @test
     * @dataProvider provideBonusWithActivityName
     * @param int $expectedBonus
     * @param string $activityName
     */
    public function I_can_get_healing_bonus_for_every_activity($expectedBonus, $activityName)
    {
        $healingBonusByPersonActionsTable = new HealingBonusForActivityTable();
        self::assertSame($expectedBonus, $healingBonusByPersonActionsTable->getHealingBonusForActivity($activityName));
    }

    public function provideBonusWithActivityName()
    {
        return [
            [0, ActivityDifficultyTypeCodes::SLEEPING_OR_REST_IN_BED],
            [-2, ActivityDifficultyTypeCodes::LOUNGING_AND_RESTING],
            [-4, ActivityDifficultyTypeCodes::LIGHT_ACTIVITY],
            [-6, ActivityDifficultyTypeCodes::NORMAL_ACTIVITY],
            [-8, ActivityDifficultyTypeCodes::TOILSOME_ACTIVITY],
            [-10, ActivityDifficultyTypeCodes::VERY_HARD_ACTIVITY]
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Healing\Exceptions\UnknownInfluenceOnHealingCode
     * @expectedExceptionMessageRegExp ~swimming_with_dolphins~
     */
    public function I_can_not_get_healing_bonus_for_unknown_activity()
    {
        (new HealingBonusForActivityTable())->getHealingBonusForActivity('swimming_with_dolphins');
    }

}
