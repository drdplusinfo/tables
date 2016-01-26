<?php
namespace DrdPlus\Tests\Tables\Measurements\Wounds;

use DrdPlus\Tables\Measurements\Wounds\Wounds;
use DrdPlus\Tables\Measurements\Wounds\WoundsBonus;
use DrdPlus\Tables\Measurements\Wounds\WoundsTable;
use DrdPlus\Tests\Tools\TestWithMockery;

class WoundsTableTest extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_get_headers()
    {
        $woundsTable = new WoundsTable();

        $this->assertEquals([['bonus', 'wounds']], $woundsTable->getHeader());
    }

    /**
     * @test
     */
    public function I_can_convert_bonus_to_wounds()
    {
        $woundsTable = new WoundsTable();
        $attempt = 1;
        $maxAttempts = 10000;
        do {
            $zeroOrOne = $woundsTable->toWounds(new WoundsBonus(-20, $woundsTable))->getValue();
            if ($zeroOrOne === 1) {
                break;
            }
        } while ($attempt++ < $maxAttempts);
        $this->assertLessThan($maxAttempts, $attempt);
        $this->assertSame(1, $zeroOrOne);

        // for bonus -10 to -7 are the same wounds
        $this->assertSame(1, $woundsTable->toWounds(new WoundsBonus(-10, $woundsTable))->getValue());
        $this->assertSame(1, $woundsTable->toWounds(new WoundsBonus(-9, $woundsTable))->getValue());
        $this->assertSame(1, $woundsTable->toWounds(new WoundsBonus(-8, $woundsTable))->getValue());
        $this->assertSame(1, $woundsTable->toWounds(new WoundsBonus(-7, $woundsTable))->getValue());

        $this->assertSame(3, $woundsTable->toWounds(new WoundsBonus(0, $woundsTable))->getValue());
        $this->assertSame(28000, $woundsTable->toWounds(new WoundsBonus(79, $woundsTable))->getValue());
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_bonus_to_wounds_cause_exception()
    {
        $woundsTable = new WoundsTable();
        $woundsTable->toWounds(new WoundsBonus(-21, $woundsTable));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_bonus_to_wounds_cause_exception()
    {
        $woundsTable = new WoundsTable();
        $woundsTable->toWounds(new WoundsBonus(80, $woundsTable));
    }

    /**
     * @test
     */
    public function I_can_convert_wounds_to_bonus()
    {
        $woundsTable = new WoundsTable();
        $this->assertSame(-10, $woundsTable->toBonus(new Wounds(1, Wounds::WOUNDS, $woundsTable))->getValue());

        // there are more bonuses for wound 3, the lowest is taken
        $this->assertSame(-2, $woundsTable->toBonus(new Wounds(3, Wounds::WOUNDS, $woundsTable))->getValue());

        $this->assertSame(30, $woundsTable->toBonus(new Wounds(104, Wounds::WOUNDS, $woundsTable))->getValue()); // 30 is the closest bonus
        $this->assertSame(31, $woundsTable->toBonus(new Wounds(105, Wounds::WOUNDS, $woundsTable))->getValue()); // 30 and 31 are closest bonuses, 31 is taken because higher
        $this->assertSame(31, $woundsTable->toBonus(new Wounds(106, Wounds::WOUNDS, $woundsTable))->getValue()); // 31 is the closest bonus (higher in this case)

        $this->assertSame(79, $woundsTable->toBonus(new Wounds(28000, Wounds::WOUNDS, $woundsTable))->getValue());
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_value_to_bonus_cause_exception()
    {
        $woundsTable = new WoundsTable();
        $woundsTable->toBonus(new Wounds(0, Wounds::WOUNDS, $woundsTable));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_value_to_bonus_cause_exception()
    {
        $woundsTable = new WoundsTable();
        $woundsTable->toBonus(new Wounds(28001, Wounds::WOUNDS, $woundsTable));
    }
}
