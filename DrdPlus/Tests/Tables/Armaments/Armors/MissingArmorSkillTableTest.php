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
        (new MissingArmorSkillTable())->getRestrictionBonusForSkillRank(-1);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function I_can_not_use_higher_rank_than_three()
    {
        (new MissingArmorSkillTable())->getRestrictionBonusForSkillRank(4);
    }

    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame([['skill_rank', 'restriction_bonus']], (new MissingArmorSkillTable())->getHeader());
    }

    /**
     * @test
     */
    public function I_can_get_bonus_for_skill_rank()
    {
        self::assertSame(2, (new MissingArmorSkillTable())->getRestrictionBonusForSkillRank(2));
    }
}