<?php
namespace DrdPlus\Tests\Tables\Measurements\Time;

use DrdPlus\Codes\Units\TimeUnitCode;
use DrdPlus\Tables\Measurements\Time\Time;
use DrdPlus\Tables\Measurements\Time\TimeTable;
use DrdPlus\Tests\Tables\Measurements\AbstractTestOfMeasurement;

class TimeTest extends AbstractTestOfMeasurement
{

    protected function getDefaultUnit()
    {
        return TimeUnitCode::ROUND;
    }

    protected function getAllUnits(): array
    {
        return [
            TimeUnitCode::ROUND,
            TimeUnitCode::MINUTE,
            TimeUnitCode::HOUR,
            TimeUnitCode::DAY,
            TimeUnitCode::MONTH,
            TimeUnitCode::YEAR,
        ];
    }

    /**
     * @test
     */
    public function I_can_use_local_constants_instead_of_those_from_unit_code_class()
    {
        $timeConstants = (new \ReflectionClass(Time::class))->getConstants();
        $timeUnitConstants = (new \ReflectionClass(TimeUnitCode::class))->getConstants();
        self::assertCount(0, array_diff($timeUnitConstants, $timeConstants));
        self::assertCount(0, array_diff(array_keys($timeUnitConstants), array_keys($timeConstants)));
    }

    /**
     * @test
     * @dataProvider provideUnsupportedUnitToRoundsConversion
     * @expectedException \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     * @param $value
     * @param $unit
     */
    public function I_got_null_on_find_and_exception_on_get_of_unsupported_to_rounds_conversion($value, $unit)
    {
        $timeTable = new TimeTable();
        $time = new Time($value, $unit, $timeTable);
        try {
            self::assertNull($time->findRounds());
        } catch (\Exception $exception) {
            self::fail('No exception expected so far, got ' . $exception->getTraceAsString());
        }
        $time->getRounds();
    }

    public function provideUnsupportedUnitToRoundsConversion()
    {
        return [
            [10, TimeUnitCode::DAY],
            [100, TimeUnitCode::YEAR],
        ];
    }

    /**
     * @test
     * @dataProvider provideUnsupportedUnitToMinutesConversion
     * @expectedException \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     * @param $value
     * @param $unit
     */
    public function I_got_null_on_find_and_exception_on_get_of_unsupported_to_minutes_conversion($value, $unit)
    {
        $timeTable = new TimeTable();
        $time = new Time($value, $unit, $timeTable);
        try {
            self::assertNull($time->findMinutes());
        } catch (\Exception $exception) {
            self::fail('No exception expected so far, got ' . $exception->getTraceAsString());
        }
        $time->getMinutes();
    }

    public function provideUnsupportedUnitToMinutesConversion()
    {
        return [
            [10, TimeUnitCode::DAY],
            [100, TimeUnitCode::YEAR],
        ];
    }

    /**
     * @test
     * @dataProvider provideUnsupportedUnitToHoursConversion
     * @expectedException \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     * @param $value
     * @param $unit
     */
    public function I_got_null_on_find_and_exception_on_get_of_unsupported_to_hours_conversion($value, $unit)
    {
        $timeTable = new TimeTable();
        $time = new Time($value, $unit, $timeTable);
        try {
            self::assertNull($time->findHours());
        } catch (\Exception $exception) {
            self::fail('No exception expected so far, got ' . $exception->getTraceAsString());
        }
        $time->getHours();
    }

    public function provideUnsupportedUnitToHoursConversion()
    {
        return [
            [1, TimeUnitCode::ROUND],
            [100, TimeUnitCode::YEAR],
        ];
    }

    /**
     * @test
     * @dataProvider provideUnsupportedUnitToDaysConversion
     * @expectedException \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     * @param $value
     * @param $unit
     */
    public function I_got_null_on_find_and_exception_on_get_of_unsupported_to_days_conversion($value, $unit)
    {
        $timeTable = new TimeTable();
        $time = new Time($value, $unit, $timeTable);
        try {
            self::assertNull($time->findDays());
        } catch (\Exception $exception) {
            self::fail('No exception expected so far, got ' . $exception->getTraceAsString());
        }
        $time->getDays();
    }

    public function provideUnsupportedUnitToDaysConversion()
    {
        return [
            [1, TimeUnitCode::ROUND],
            [100, TimeUnitCode::YEAR],
        ];
    }

    /**
     * @test
     * @dataProvider provideUnsupportedUnitToMonthsConversion
     * @expectedException \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     * @param $value
     * @param $unit
     */
    public function I_got_null_on_find_and_exception_on_get_of_unsupported_to_months_conversion($value, $unit)
    {
        $timeTable = new TimeTable();
        $time = new Time($value, $unit, $timeTable);
        try {
            self::assertNull($time->findMonths());
        } catch (\Exception $exception) {
            self::fail('No exception expected so far, got ' . $exception->getTraceAsString());
        }
        $time->getMonths();
    }

    public function provideUnsupportedUnitToMonthsConversion()
    {
        return [
            [1, TimeUnitCode::ROUND],
            [20, TimeUnitCode::MINUTE],
            [100, TimeUnitCode::YEAR],
        ];
    }

    /**
     * @test
     * @dataProvider provideUnsupportedUnitToYearsConversion
     * @expectedException \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotConvertTimeToUnit
     * @param $value
     * @param $unit
     */
    public function I_got_null_on_find_and_exception_on_get_of_unsupported_to_years_conversion($value, $unit)
    {
        $timeTable = new TimeTable();
        $time = new Time($value, $unit, $timeTable);
        try {
            self::assertNull($time->findYears());
        } catch (\Exception $exception) {
            self::fail('No exception expected so far, got ' . $exception->getTraceAsString());
        }
        $time->getYears();
    }

    public function provideUnsupportedUnitToYearsConversion()
    {
        return [
            [1, TimeUnitCode::ROUND],
            [12, TimeUnitCode::MINUTE],
        ];
    }

    /**
     * @test
     */
    public function I_can_get_hours_per_day_as_constant()
    {
        self::assertSame((new Time(1, TimeUnitCode::DAY, new TimeTable()))->getHours()->getValue(), Time::HOURS_PER_DAY);
    }

    /**
     * This tests equals to that on PPH page 11 right column
     *
     * @test
     */
    public function I_get_zero_as_bonus_for_one_round()
    {
        self::assertSame(
            0,
            (new Time(1, TimeUnitCode::ROUND, new TimeTable()))->getBonus()->getValue(),
            'First available bonus should be taken if more than single one matches the value'
        );
    }

    /**
     * @test
     */
    public function I_can_get_unit_as_code()
    {
        $day = new Time(1, TimeUnitCode::DAY, new TimeTable());
        self::assertSame(TimeUnitCode::getIt(TimeUnitCode::DAY), $day->getUnitCode());
        $year = new Time(1, TimeUnitCode::YEAR, new TimeTable());
        self::assertSame(TimeUnitCode::getIt(TimeUnitCode::YEAR), $year->getUnitCode());
    }
}