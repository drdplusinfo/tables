<?php
namespace DrdPlus\Tests\Tables\Wounds;

use DrdPlus\Tables\Wounds\WoundsMeasurement;
use DrdPlus\Tables\Wounds\WoundsTable;
use DrdPlus\Tests\Tables\TestWithMockery;

class WoundsTableTest extends TestWithMockery
{

    /**
     * @test
     */
    public function can_convert_bonus_to_wounds()
    {
        $woundsTable = new WoundsTable();
        do {
            $attempt = 1;
            $attempt++;
            $zeroOrOne = $woundsTable->toWounds(-20);
            if ($zeroOrOne === 1.0) {
                break;
            }
        } while ($attempt < 1000);
        $this->assertSame(1.0, $zeroOrOne);

        // for bonus -10 to -7 are the same wounds
        $this->assertSame(1.0, $woundsTable->toWounds(-10));
        $this->assertSame(1.0, $woundsTable->toWounds(-9));
        $this->assertSame(1.0, $woundsTable->toWounds(-8));
        $this->assertSame(1.0, $woundsTable->toWounds(-7));

        $this->assertSame(3.0, $woundsTable->toWounds(0));
        $this->assertSame(28000.0, $woundsTable->toWounds(79));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_bonus_to_wounds_cause_exception()
    {
        $woundsTable = new WoundsTable();
        $woundsTable->toWounds(-21);
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_bonus_to_wounds_cause_exception()
    {
        $woundsTable = new WoundsTable();
        $woundsTable->toWounds(80);
    }

    /**
     * @test
     */
    public function can_convert_wounds_to_bonus()
    {
        $woundsTable = new WoundsTable();
        $this->assertSame(-10, $woundsTable->toBonus(new WoundsMeasurement(1)));

        // there are more bonuses for wound 3, the lowest is taken
        $this->assertSame(-2, $woundsTable->woundsToBonus(3));

        $this->assertSame(30, $woundsTable->woundsToBonus(104)); // 30 is the closest bonus
        $this->assertSame(31, $woundsTable->woundsToBonus(105)); // 30 and 31 are closest bonuses, 31 is taken because higher
        $this->assertSame(31, $woundsTable->woundsToBonus(106)); // 31 is the closest bonus (higher in this case)

        $this->assertSame(79, $woundsTable->toBonus(new WoundsMeasurement(28000)));
        $this->assertSame(79, $woundsTable->woundsToBonus(28000));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_value_to_bonus_cause_exception()
    {
        $woundsTable = new WoundsTable();
        $woundsTable->woundsToBonus(0);
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_value_to_bonus_cause_exception()
    {
        $woundsTable = new WoundsTable();
        $woundsTable->woundsToBonus(28001);
    }
}
