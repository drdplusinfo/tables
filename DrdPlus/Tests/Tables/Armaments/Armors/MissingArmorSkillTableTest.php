<?php
namespace DrdPlus\Tests\Tables\Armaments\Armors;

use DrdPlus\Tables\Armaments\Armors\MissingArmorSkillTable;
use DrdPlus\Tests\Tables\Armaments\Partials\AbstractMissingArmamentSkillTableTest;

class MissingArmorSkillTableTest extends AbstractMissingArmamentSkillTableTest
{
    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function I_can_not_use_negative_rank()
    {
        (new MissingArmorSkillTable())->gotBonusForSkillRank(-1);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function I_can_not_use_higher_rank_than_three()
    {
        (new MissingArmorSkillTable())->gotBonusForSkillRank(4);
    }

    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame([['skill_rank', 'bonus']], (new MissingArmorSkillTable())->getHeader());
    }

}