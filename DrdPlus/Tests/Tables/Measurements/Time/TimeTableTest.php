<?php
namespace DrdPlus\Tests\Tables\Measurements\Time;

use DrdPlus\Tables\Measurements\Time\Time;
use DrdPlus\Tables\Measurements\Time\TimeBonus;
use DrdPlus\Tables\Measurements\Time\TimeTable;
use DrdPlus\Tests\Tables\Measurements\MeasurementTableTest;
use Granam\Tests\Tools\TestWithMockery;

class TimeTableTest extends TestWithMockery implements MeasurementTableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $timeTable = new TimeTable();

        self::assertEquals(
            [['bonus', 'round', 'minute', 'hour', 'day', 'month', 'year']],
            $timeTable->getHeader()
        );
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function I_can_not_use_too_low_bonus_to_value()
    {
        $timeTable = new TimeTable();
        $timeTable->toTime(new TimeBonus(-1, $timeTable))->getRounds();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     */
    public function I_can_not_convert_too_high_bonus_to_too_detailed_unit()
    {
        $timeTable = new TimeTable();
        $timeTable->toTime(new TimeBonus(40, $timeTable))->getRounds();
    }

    /**
     * @test
     */
    public function I_can_convert_value_to_bonus()
    {
        $timeTable = new TimeTable();

        self::assertSame(0, $timeTable->toBonus(new Time(1, Time::ROUND, $timeTable))->getValue());
        self::assertSame(4, $timeTable->toBonus(new Time(2, Time::ROUND, $timeTable))->getValue());
        self::assertSame(39, $timeTable->toBonus(new Time(90, Time::ROUND, $timeTable))->getValue());

        self::assertSame(16, $timeTable->toBonus(new Time(1, Time::MINUTE, $timeTable))->getValue());
        self::assertSame(51, $timeTable->toBonus(new Time(1, Time::HOUR, $timeTable))->getValue());
        self::assertSame(73, $timeTable->toBonus(new Time(1, Time::DAY, $timeTable))->getValue());
        self::assertSame(102, $timeTable->toBonus(new Time(1, Time::MONTH, $timeTable))->getValue());
        self::assertSame(124, $timeTable->toBonus(new Time(1, Time::YEAR, $timeTable))->getValue());
    }

    /**
     * @test
     */
    public function I_can_convert_bonus_to_value()
    {
        $timeTable = new TimeTable();

        self::assertSame(1, $timeTable->toTime(new TimeBonus(0, $timeTable))->getRounds()->getValue());
        self::assertSame(1, $timeTable->toTime(new TimeBonus(3, $timeTable))->getRounds()->getValue());

        self::assertSame(
            number_format(1.1, 5),
            number_format($timeTable->toTime(new TimeBonus(17, $timeTable))->getMinutes()->getValue(), 5)
        );
        self::assertSame(28.0, $timeTable->toTime(new TimeBonus(45, $timeTable))->getMinutes()->getValue());
        self::assertSame(0.5, $timeTable->toTime(new TimeBonus(45, $timeTable))->getHours()->getValue());
        self::assertSame(2.5, $timeTable->toTime(new TimeBonus(59, $timeTable))->getHours()->getValue());
        self::assertSame(1.0, $timeTable->toTime(new TimeBonus(73, $timeTable))->getDays()->getValue());
        self::assertSame(1.0, $timeTable->toTime(new TimeBonus(102, $timeTable))->getMonths()->getValue());
        self::assertSame(1.0, $timeTable->toTime(new TimeBonus(124, $timeTable))->getYears()->getValue());
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function I_can_not_convert_too_low_value_to_bonus()
    {
        $timeTable = new TimeTable();
        $timeTable->toBonus(new Time(0, Time::ROUND, $timeTable))->getValue();
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function I_can_not_convert_too_high_value_to_bonus()
    {
        $timeTable = new TimeTable();
        $timeTable->toBonus(new Time(91, Time::ROUND, $timeTable))->getValue();
    }
}
