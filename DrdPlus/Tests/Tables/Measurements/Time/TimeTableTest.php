<?php
namespace DrdPlus\Tests\Tables\Measurements\Time;

use DrdPlus\Tables\Measurements\Time\Time;
use DrdPlus\Tables\Measurements\Time\TimeBonus;
use DrdPlus\Tables\Measurements\Time\TimeTable;
use DrdPlus\Tests\Tools\TestWithMockery;

class TimeTableTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_get_headers()
    {
        $timeTable = new TimeTable();

        $this->assertEquals(['round', 'minute', 'hour', 'day', 'month', 'year'], $timeTable->getColumnsHeader());
        $this->assertEquals(['bonus'], $timeTable->getRowsHeader());
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function I_can_not_convert_too_low_bonus()
    {
        $timeTable = new TimeTable();
        $timeTable->toTime(new TimeBonus(-1, $timeTable))->getRounds();
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_bonus_to_rounds_cause_exception()
    {
        $timeTable = new TimeTable();
        $timeTable->toTime(new TimeBonus(40, $timeTable))->getRounds();
    }

    /**
     * @test
     */
    public function can_convert_time_to_bonus()
    {
        $timeTable = new TimeTable();

        $this->assertSame(0, $timeTable->toBonus(new Time(1, Time::ROUND, $timeTable))->getValue());
        $this->assertSame(4, $timeTable->toBonus(new Time(2, Time::ROUND, $timeTable))->getValue());
        $this->assertSame(39, $timeTable->toBonus(new Time(90, Time::ROUND, $timeTable))->getValue());

        $this->assertSame(16, $timeTable->toBonus(new Time(1, Time::MINUTE, $timeTable))->getValue());
        $this->assertSame(51, $timeTable->toBonus(new Time(1, Time::HOUR, $timeTable))->getValue());
        $this->assertSame(73, $timeTable->toBonus(new Time(1, Time::DAY, $timeTable))->getValue());
        $this->assertSame(102, $timeTable->toBonus(new Time(1, Time::MONTH, $timeTable))->getValue());
        $this->assertSame(124, $timeTable->toBonus(new Time(1, Time::YEAR, $timeTable))->getValue());
    }

    /**
     * @test
     */
    public function I_can_convert_bonus_to_time()
    {
        $timeTable = new TimeTable();

        $this->assertSame(1, $timeTable->toTime(new TimeBonus(0, $timeTable))->getRounds()->getValue());
        $this->assertSame(1, $timeTable->toTime(new TimeBonus(3, $timeTable))->getRounds()->getValue());

        $this->assertSame(
            number_format(1.1, 5),
            number_format($timeTable->toTime(new TimeBonus(17, $timeTable))->getMinutes()->getValue(), 5)
        );
        $this->assertSame(28.0, $timeTable->toTime(new TimeBonus(45, $timeTable))->getMinutes()->getValue());
        $this->assertSame(0.5, $timeTable->toTime(new TimeBonus(45, $timeTable))->getHours()->getValue());
        $this->assertSame(2.5, $timeTable->toTime(new TimeBonus(59, $timeTable))->getHours()->getValue());
        $this->assertSame(1.0, $timeTable->toTime(new TimeBonus(73, $timeTable))->getDays()->getValue());
        $this->assertSame(1.0, $timeTable->toTime(new TimeBonus(102, $timeTable))->getMonths()->getValue());
        $this->assertSame(1.0, $timeTable->toTime(new TimeBonus(124, $timeTable))->getYears()->getValue());
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_value_to_bonus_cause_exception()
    {
        $timeTable = new TimeTable();
        $timeTable->toBonus(new Time(0, Time::ROUND, $timeTable))->getValue();
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_value_to_bonus_cause_exception()
    {
        $timeTable = new TimeTable();
        $timeTable->toBonus(new Time(91, Time::ROUND, $timeTable))->getValue();
    }
}
