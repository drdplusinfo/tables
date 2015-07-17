<?php
namespace DrdPlus\Tests\Tables\Fatigue;

use DrdPlus\Tables\Fatigue\FatigueMeasurement;
use DrdPlus\Tables\Fatigue\FatigueTable;
use DrdPlus\Tests\Tables\TestWithMockery;

class FatigueTableTest extends TestWithMockery
{

    /**
     * @test
     */
    public function can_convert_bonus_to_fatigue()
    {
        $fatigueTable = new FatigueTable();
        do {
            $attempt = 1;
            $attempt++;
            $zeroOrOne = $fatigueTable->toFatigue(-20);
            if ($zeroOrOne === 1.0) {
                break;
            }
        } while ($attempt < 1000);
        $this->assertSame(1.0, $zeroOrOne);

        // for bonus -10 to -7 are the same fatigue
        $this->assertSame(1.0, $fatigueTable->toFatigue(-10));
        $this->assertSame(1.0, $fatigueTable->toFatigue(-9));
        $this->assertSame(1.0, $fatigueTable->toFatigue(-8));
        $this->assertSame(1.0, $fatigueTable->toFatigue(-7));

        $this->assertSame(3.0, $fatigueTable->toFatigue(0));
        $this->assertSame(28000.0, $fatigueTable->toFatigue(79));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_bonus_to_fatigue_cause_exception()
    {
        $fatigueTable = new FatigueTable();
        $fatigueTable->toFatigue(-21);
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_bonus_to_fatigue_cause_exception()
    {
        $fatigueTable = new FatigueTable();
        $fatigueTable->toFatigue(80);
    }

    /**
     * @test
     */
    public function can_convert_fatigue_to_bonus()
    {
        $fatigueTable = new FatigueTable();
        $this->assertSame(-10, $fatigueTable->toBonus(new FatigueMeasurement(1)));

        // there are more bonuses for wound 3, the lowest is taken
        $this->assertSame(-2, $fatigueTable->fatigueToBonus(3));

        $this->assertSame(30, $fatigueTable->fatigueToBonus(104)); // 30 is the closest bonus
        $this->assertSame(31, $fatigueTable->fatigueToBonus(105)); // 30 and 31 are closest bonuses, 31 is taken because higher
        $this->assertSame(31, $fatigueTable->fatigueToBonus(106)); // 31 is the closest bonus (higher in this case)

        $this->assertSame(79, $fatigueTable->toBonus(new FatigueMeasurement(28000)));
        $this->assertSame(79, $fatigueTable->fatigueToBonus(28000));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_value_to_bonus_cause_exception()
    {
        $fatigueTable = new FatigueTable();
        $fatigueTable->fatigueToBonus(0);
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_value_to_bonus_cause_exception()
    {
        $fatigueTable = new FatigueTable();
        $fatigueTable->fatigueToBonus(28001);
    }
}
