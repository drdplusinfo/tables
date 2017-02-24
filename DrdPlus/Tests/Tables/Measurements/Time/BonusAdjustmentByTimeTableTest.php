<?php
namespace DrdPlus\Tests\Tables\Measurements\Time;

use DrdPlus\Tables\Measurements\Time\BonusAdjustmentByTimeTable;
use DrdPlus\Tables\Measurements\Time\Time;
use DrdPlus\Tables\Measurements\Time\TimeTable;
use DrdPlus\Tests\Tables\TableTest;

class BonusAdjustmentByTimeTableTest extends TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $bonusAdjustmentByTimeTable = new BonusAdjustmentByTimeTable(new TimeTable());
        self::assertSame([['hours_of_activity_per_day', 'adjustment']], $bonusAdjustmentByTimeTable->getHeader());
    }

    /**
     * @test
     * @dataProvider provideOriginalActivityTime
     * @param Time $originalActivityTime
     * @param int $hoursPerDay
     * @param Time $expectedAdjusted
     */
    public function I_can_use_it(Time $originalActivityTime, $hoursPerDay, Time $expectedAdjusted)
    {
        $bonusAdjustmentByTimeTable = new BonusAdjustmentByTimeTable(new TimeTable());
        $originalActivityTimeBonusValue = $originalActivityTime->getBonus()->getValue();
        $adjustedTime = $bonusAdjustmentByTimeTable->adjustBy($originalActivityTime, $hoursPerDay, true /* unlimited duration */);
        self::assertSame(
            $originalActivityTimeBonusValue,
            $originalActivityTime->getBonus()->getValue(),
            'Original activity should remains untouched'
        );
        self::assertSame(
            $expectedAdjusted->getIn($adjustedTime->getUnit())->getValue(),
            $adjustedTime->getValue(),
            'Was checking ' . $originalActivityTime->getValue() . ' ' . $originalActivityTime->getUnit() . '(s)'
            . ' adjusted by ' . $hoursPerDay . ' hour(s) per day'
        );
    }

    public function provideOriginalActivityTime()
    {
        $timeTable = new TimeTable();

        return [
            [new Time(1, Time::DAY, $timeTable), 1 /* hour of activity per day */, new Time(12, Time::DAY, $timeTable) /* expected duration */],
            [new Time(5, Time::DAY, $timeTable), 12 /* hour of activity per day */, new Time(5, Time::DAY, $timeTable) /* expected duration */],
            [new Time(100, Time::DAY, $timeTable), 24 /* hour of activity per day */, new Time(50, Time::DAY, $timeTable) /* expected duration */],

            [new Time(1, Time::MONTH, $timeTable), 1 /* hour of activity per day */, new Time(12, Time::MONTH, $timeTable) /* expected duration */],
            [new Time(2, Time::MONTH, $timeTable), 10 /* hour of activity per day */, new Time(2.5, Time::MONTH, $timeTable) /* expected duration */],
            [new Time(5, Time::MONTH, $timeTable), 5 /* hour of activity per day */, new Time(12, Time::MONTH, $timeTable) /* expected duration */],
            [new Time(12, Time::MONTH, $timeTable), 2 /* hour of activity per day */, new Time(6.3, Time::YEAR, $timeTable) /* expected duration */],
            [new Time(120, Time::MONTH, $timeTable), 10 /* hour of activity per day */, new Time(12, Time::YEAR, $timeTable) /* expected duration */],

            [new Time(1, Time::YEAR, $timeTable), 1 /* hour of activity per day */, new Time(12, Time::YEAR, $timeTable) /* expected duration */],
            [new Time(10, Time::YEAR, $timeTable), 20 /* hour of activity per day */, new Time(80, Time::MONTH, $timeTable) /* expected duration */],
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Time\Exceptions\NotApplicableOnShorterThanDay
     * @expectedExceptionMessageRegExp ~at least one day~
     */
    public function I_can_not_adjust_less_than_a_day()
    {
        $bonusAdjustmentByTimeTable = new BonusAdjustmentByTimeTable(new TimeTable());
        $bonusAdjustmentByTimeTable->adjustBy(new Time(0.9, Time::DAY, new TimeTable()), 15, false);
    }

    /**
     * @test
     * @dataProvider provideNonSenseHours
     * @expectedException \DrdPlus\Tables\Measurements\Time\Exceptions\UnexpectedHoursPerDayForTimeBonusAdjustment
     * @param int $nonSenseHours
     */
    public function I_can_not_adjust_by_non_sense_hours_of_daily_activity($nonSenseHours)
    {
        $bonusAdjustmentByTimeTable = new BonusAdjustmentByTimeTable(new TimeTable());
        $bonusAdjustmentByTimeTable->adjustBy(new Time(10, Time::DAY, new TimeTable()), $nonSenseHours, true);
    }

    public function provideNonSenseHours()
    {
        return [
            [0],
            [25],
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Time\Exceptions\CanNotProlongActivityPerDayWithLimitedTime
     */
    public function I_can_hasten_but_not_prolong_activity_with_limited_time()
    {
        $timeTable = new TimeTable();
        $bonusAdjustmentByTimeTable = new BonusAdjustmentByTimeTable($timeTable);
        $original = new Time(10, Time::DAY, $timeTable);
        try {
            $lessTimePerDay = $bonusAdjustmentByTimeTable->adjustBy($original, 10, false);
            self::assertGreaterThan($original->getValue(), $lessTimePerDay->getValue());

            $same = $bonusAdjustmentByTimeTable->adjustBy($original, 12, false);
            self::assertSame($original->getValue(), $same->getValue());

            $moreTimePerDay = $bonusAdjustmentByTimeTable->adjustBy($original, 20, true /* unlimited */);
            self::assertLessThan($original->getValue(), $moreTimePerDay->getValue());
        } catch (\Exception $exception) {
            self::fail('No exceptions has been expected so far: ' . $exception->getTraceAsString());
        }
        $bonusAdjustmentByTimeTable->adjustBy($original, 13, false);
    }
}