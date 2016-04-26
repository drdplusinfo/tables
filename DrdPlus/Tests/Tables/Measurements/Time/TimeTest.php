<?php
namespace DrdPlus\Tests\Tables\Measurements\Time;

use DrdPlus\Tables\Measurements\Time\Time;
use DrdPlus\Tables\Measurements\Time\TimeTable;
use DrdPlus\Tests\Tables\Measurements\AbstractTestOfMeasurement;

class TimeTest extends AbstractTestOfMeasurement
{

    protected function getDefaultUnit()
    {
        return Time::ROUND;
    }

    protected function getAllUnits()
    {
        return [
            Time::ROUND,
            Time::MINUTE,
            Time::HOUR,
            Time::DAY,
            Time::MONTH,
            Time::YEAR,
        ];
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
            [10, Time::DAY],
            [100, Time::YEAR],
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
            [10, Time::DAY],
            [100, Time::YEAR],
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
            [1, Time::ROUND],
            [100, Time::YEAR],
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
            [1, Time::ROUND],
            [100, Time::YEAR],
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
            [1, Time::ROUND],
            [20, Time::MINUTE],
            [100, Time::YEAR],
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
            [1, Time::ROUND],
            [12, Time::MINUTE],
        ];
    }
}
