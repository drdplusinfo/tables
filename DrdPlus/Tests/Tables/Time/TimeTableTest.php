<?php
namespace DrdPlus\Tests\Tables\Time;

use DrdPlus\Tables\Time\TimeTable;
use DrdPlus\Tests\Tables\TestWithMockery;

class TimeTableTest extends TestWithMockery
{

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_bonus_to_rounds_cause_exception()
    {
        $timeTable = new TimeTable();
        $timeTable->toRounds(-1);
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_bonus_to_rounds_cause_exception()
    {
        $timeTable = new TimeTable();
        $timeTable->toRounds(40);
    }

    /**
     * @test
     */
    public function can_convert_time_to_bonus()
    {
        $timeTable = new TimeTable();

        $this->assertSame(0, $timeTable->roundsToBonus(1));
        $this->assertSame(4, $timeTable->roundsToBonus(2));
        $this->assertSame(39, $timeTable->roundsToBonus(90));

        $this->assertSame(16, $timeTable->minutesToBonus(1));
        $this->assertSame(51, $timeTable->hoursToBonus(1));
        $this->assertSame(73, $timeTable->daysToBonus(1));
        $this->assertSame(102, $timeTable->monthsToBonus(1));
        $this->assertSame(124, $timeTable->yearsToBonus(1));
    }

    /**
     * @test
     */
    public function I_can_convert_bonus_to_time()
    {
        $timeTable = new TimeTable();

        $this->assertSame(1, $timeTable->toRounds(0));
        $this->assertSame(1, $timeTable->toRounds(3));

        $this->assertSame(1, $timeTable->toMinutes(16));
        $this->assertSame(28, $timeTable->toMinutes(45));
        $this->assertSame(0.5, $timeTable->toHours(45));
        $this->assertSame(2.5, $timeTable->toHours(59));
        $this->assertSame(1.0, $timeTable->toDays(73));
        $this->assertSame(1.0, $timeTable->toMonths(102));
        $this->assertSame(1.0, $timeTable->toYears(124));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_value_to_bonus_cause_exception()
    {
        $timeTable = new TimeTable();
        $timeTable->roundsToBonus(0);
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_value_to_bonus_cause_exception()
    {
        $timeTable = new TimeTable();
        $timeTable->roundsToBonus(91);
    }
}
