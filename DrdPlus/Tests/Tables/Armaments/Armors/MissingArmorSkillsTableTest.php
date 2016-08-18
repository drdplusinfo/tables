<?php
namespace DrdPlus\Tests\Tables\Armaments\Armors;

use DrdPlus\Tables\Armaments\Armors\MissingArmorSkillsTable;
use DrdPlus\Tests\Tables\Armaments\Partials\AbstractMissingArmamentSkillsTableTest;

class MissingArmorSkillsTableTest extends AbstractMissingArmamentSkillsTableTest
{
    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function I_can_not_use_negative_rank()
    {
        (new MissingArmorSkillsTable())->gotBonusForSkillRank(-1);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function I_can_not_use_higher_rank_than_three()
    {
        (new MissingArmorSkillsTable())->gotBonusForSkillRank(4);
    }

    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame([['skill_rank', 'bonus']], (new MissingArmorSkillsTable())->getHeader());
    }

}