<?php
namespace DrdPlus\Tests\Tables\Environments;

use DrdPlus\Tables\Environments\TerrainDifficultyPercents;

class TerrainDifficultyPercentsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $difficultyPercents = new TerrainDifficultyPercents(12);
        self::assertSame(12, $difficultyPercents->getValue());
    }

    /**
     * @test
     */
    public function I_can_turn_it_into_percents_string()
    {
        $difficultyPercents = new TerrainDifficultyPercents(56);
        self::assertSame('56 %', (string)$difficultyPercents);
    }

    /**
     * @test
     */
    public function I_can_get_rate()
    {
        self::assertSame(0.99, (new TerrainDifficultyPercents(99))->getRate());
        self::assertSame(0.42, (new TerrainDifficultyPercents(42))->getRate());
        self::assertSame(0.0, (new TerrainDifficultyPercents(0))->getRate());
        self::assertSame(1.0, (new TerrainDifficultyPercents(100))->getRate());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Environments\Exceptions\UnexpectedDifficultyPercents
     * @expectedExceptionMessageRegExp ~half of quarter~
     */
    public function I_can_not_create_it_from_non_integer()
    {
        new TerrainDifficultyPercents('half of quarter');
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Environments\Exceptions\UnexpectedDifficultyPercents
     * @expectedExceptionMessageRegExp ~101~
     */
    public function I_can_not_create_more_than_hundred_of_percents()
    {
        try {
            new TerrainDifficultyPercents(100);
        } catch (\Exception $exception) {
            self::fail('No exception expected so far: ' . $exception->getTraceAsString());
        }
        new TerrainDifficultyPercents(101);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Environments\Exceptions\UnexpectedDifficultyPercents
     * @expectedExceptionMessageRegExp ~-1~
     */
    public function I_can_not_create_negative_percents()
    {
        try {
            new TerrainDifficultyPercents(0);
        } catch (\Exception $exception) {
            self::fail('No exception expected so far: ' . $exception->getTraceAsString());
        }
        new TerrainDifficultyPercents(-1);
    }
}
