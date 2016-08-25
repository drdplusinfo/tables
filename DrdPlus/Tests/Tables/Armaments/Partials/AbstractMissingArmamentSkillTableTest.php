<?php
namespace DrdPlus\Tests\Tables\Armaments\Partials;

use DrdPlus\Tests\Tables\TableTestInterface;
use Granam\Tests\Tools\TestWithMockery;

abstract class AbstractMissingArmamentSkillTableTest extends TestWithMockery implements TableTestInterface
{
    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    abstract public function I_can_not_use_negative_rank();

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    abstract public function I_can_not_use_higher_rank_than_three();
}