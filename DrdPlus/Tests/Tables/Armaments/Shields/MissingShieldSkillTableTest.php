<?php
namespace DrdPlus\Tests\Tables\Armaments\Shields;

use DrdPlus\Tables\Armaments\Shields\MissingShieldSkillTable;
use DrdPlus\Tests\Tables\Armaments\Partials\AbstractMissingArmamentSkillTableTest;

class MissingShieldSkillTableTest extends AbstractMissingArmamentSkillTableTest
{
    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function I_can_not_use_negative_rank()
    {
        (new MissingShieldSkillTable())->getCoverMalusForSkill(-2);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function I_can_not_use_higher_rank_than_three()
    {
        (new MissingShieldSkillTable())->getRestrictionBonusForSkill(8);
    }

    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame([['skill_rank', 'restriction_bonus', 'cover']], (new MissingShieldSkillTable())->getHeader());
    }

    /**
     * @test
     */
    public function I_can_get_restriction_bonus_for_skill_rank()
    {
        self::assertSame(1, (new MissingShieldSkillTable())->getRestrictionBonusForSkill(1));
    }

    /**
     * @test
     */
    public function I_can_get_cover_for_skill_rank()
    {
        self::assertSame(0, (new MissingShieldSkillTable())->getCoverMalusForSkill(3));
    }
}