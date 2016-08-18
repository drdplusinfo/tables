<?php
namespace DrdPlus\Tests\Tables\Armaments\Shields;

use DrdPlus\Tables\Armaments\Shields\MissingShieldSkillsTable;
use DrdPlus\Tests\Tables\Armaments\Partials\AbstractMissingArmamentSkillsTableTest;

class MissingShieldSkillsTableTest extends AbstractMissingArmamentSkillsTableTest
{
    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function I_can_not_use_negative_rank()
    {
        (new MissingShieldSkillsTable())->getCoverForSkillRank(-2);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function I_can_not_use_higher_rank_than_three()
    {
        (new MissingShieldSkillsTable())->getRestrictionBonusForSkillRank(8);
    }

    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame([['skill_rank', 'restriction_bonus', 'cover']], (new MissingShieldSkillsTable())->getHeader());
    }

}