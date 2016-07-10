<?php
namespace DrdPlus\Tests\Tables\Partials;

use DrdPlus\Tables\Partials\Percents;

abstract class PercentsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $sutClass = $this->getSutClass();
        /** @var Percents $percents */
        $percents = new $sutClass(12);
        self::assertSame(12, $percents->getValue());
    }

    /**
     * @return string|Percents
     */
    protected function getSutClass()
    {
        return preg_replace('~[\\\]Tests(.+)Test$~', '$1', static::class);
    }

    /**
     * @test
     */
    public function I_can_turn_it_into_percents_string()
    {
        $sutClass = $this->getSutClass();
        /** @var Percents $percents */
        $percents = new $sutClass(56);
        self::assertSame('56 %', (string)$percents);
    }

    /**
     * @test
     */
    public function I_can_get_rate()
    {
        $sutClass = $this->getSutClass();
        /** @var Percents $percents */
        $percents = new $sutClass(99);
        self::assertSame(0.99, $percents->getRate());
        $percents = new $sutClass(42);
        self::assertSame(0.42, $percents->getRate());
        $percents = new $sutClass(0);
        self::assertSame(0.0, $percents->getRate());
        $percents = new $sutClass(100);
        self::assertSame(1.0, $percents->getRate());
    }

    /**
     * @test
     */
    public function I_can_create_more_than_hundred_of_percents()
    {
        $sutClass = $this->getSutClass();
        /** @var Percents $percents */
        $percents = new $sutClass(101);
        self::assertSame(101, $percents->getValue());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Partials\Exceptions\UnexpectedPercents
     * @expectedExceptionMessageRegExp ~-1~
     */
    public function I_can_not_create_negative_percents()
    {
        $sutClass = $this->getSutClass();
        new $sutClass(-1);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Partials\Exceptions\UnexpectedPercents
     * @expectedExceptionMessageRegExp ~half of quarter~
     */
    public function I_can_not_create_it_from_non_integer()
    {
        $sutClass = $this->getSutClass();
        new $sutClass('half of quarter');
    }

}
