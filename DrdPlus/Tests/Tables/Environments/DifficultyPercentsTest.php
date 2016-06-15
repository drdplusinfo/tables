<?php
namespace DrdPlus\Tests\Tables\Environments;

use DrdPlus\Tables\Environments\DifficultyPercents;

class DifficultyPercentsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $difficultyPercents = new DifficultyPercents(12);
        self::assertSame(12, $difficultyPercents->getValue());
    }

    /**
     * @test
     */
    public function I_can_turn_it_into_percents_string()
    {
        $difficultyPercents = new DifficultyPercents(56);
        self::assertSame('56 %', (string)$difficultyPercents);
    }

    /**
     * @test
     */
    public function I_can_get_rate()
    {
        $difficultyPercents = new DifficultyPercents(99);
        self::assertSame(0.99, $difficultyPercents->getRate());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Environments\Exceptions\UnexpectedDifficultyPercents
     * @expectedExceptionMessageRegExp ~half of quarter~
     */
    public function I_can_not_create_it_from_non_integer()
    {
        new DifficultyPercents('half of quarter');
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Environments\Exceptions\UnexpectedDifficultyPercents
     * @expectedExceptionMessageRegExp ~101~
     */
    public function I_can_not_create_more_than_hundred_of_percents()
    {
        try {
            new DifficultyPercents(100);
        } catch (\Exception $exception) {
            self::fail('No exception expected so far: ' . $exception->getTraceAsString());
        }
        new DifficultyPercents(101);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Environments\Exceptions\UnexpectedDifficultyPercents
     * @expectedExceptionMessageRegExp ~-1~
     */
    public function I_can_not_create_negative_percents()
    {
        try {
            new DifficultyPercents(0);
        } catch (\Exception $exception) {
            self::fail('No exception expected so far: ' . $exception->getTraceAsString());
        }
        new DifficultyPercents(-1);
    }
}
