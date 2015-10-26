<?php
namespace DrdPlus\Tests\Tables\Measurements\Derived\Fatigue;

use DrdPlus\Tables\Measurements\Fatigue\Fatigue;
use DrdPlus\Tables\Measurements\Fatigue\FatigueBonus;
use DrdPlus\Tables\Measurements\Fatigue\FatigueTable;
use DrdPlus\Tables\Measurements\Wounds\WoundsTable;
use DrdPlus\Tools\Tests\TestWithMockery;

class FatigueTableTest extends TestWithMockery
{
    /** @var  WoundsTable */
    private $woundsTable;

    protected function setUp()
    {
        $this->woundsTable = new WoundsTable();
    }

    /**
     * @test
     */
    public function can_convert_bonus_to_fatigue()
    {
        $fatigueTable = new FatigueTable($this->woundsTable);
        $attempt = 1;
        $maxAttempts = 10000;
        do {
            $zeroOrOne = $fatigueTable->toFatigue(new FatigueBonus(-20, $fatigueTable))->getValue();
            if ($zeroOrOne === 1) {
                break;
            }
        } while ($attempt++ < $maxAttempts);
        $this->assertLessThan($maxAttempts, $attempt);
        $this->assertSame(1, $zeroOrOne);

        // for bonus -10 to -7 are the same fatigue
        $this->assertSame(
            1,
            $fatigueTable->toFatigue(new FatigueBonus(-10, $fatigueTable))->getValue()
        );
        $this->assertSame(
            1,
            $fatigueTable->toFatigue(new FatigueBonus(-9, $fatigueTable))->getValue()
        );
        $this->assertSame(
            1,
            $fatigueTable->toFatigue(new FatigueBonus(-8, $fatigueTable))->getValue()
        );
        $this->assertSame(
            1,
            $fatigueTable->toFatigue(new FatigueBonus(-7, $fatigueTable))->getValue()
        );
        $this->assertSame(
            3,
            $fatigueTable->toFatigue(new FatigueBonus(0, $fatigueTable))->getValue()
        );
        $this->assertSame(
            28000,
            $fatigueTable->toFatigue(new FatigueBonus(79, $fatigueTable))->getValue()
        );
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_bonus_to_fatigue_cause_exception()
    {
        $fatigueTable = new FatigueTable($this->woundsTable);
        $fatigueTable->toFatigue(new FatigueBonus(-21, $fatigueTable));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_bonus_to_fatigue_cause_exception()
    {
        $fatigueTable = new FatigueTable($this->woundsTable);
        $fatigueTable->toFatigue(new FatigueBonus(80, $fatigueTable));
    }

    /**
     * @test
     */
    public function can_convert_fatigue_to_bonus()
    {
        $fatigueTable = new FatigueTable($this->woundsTable);
        $this->assertSame(
            -10,
            $fatigueTable->toBonus(new Fatigue(1, Fatigue::FATIGUE, $fatigueTable))->getValue()
        );

        // there are more bonuses for wound 3, the lowest is taken
        $this->assertSame(
            -2,
            $fatigueTable->toBonus(new Fatigue(3, Fatigue::FATIGUE, $fatigueTable))->getValue()
        );

        $this->assertSame(
            30,
            $fatigueTable->toBonus(new Fatigue(104, Fatigue::FATIGUE, $fatigueTable))->getValue()
        ); // 30 is the closest bonus
        $this->assertSame(
            31,
            $fatigueTable->toBonus(new Fatigue(105, Fatigue::FATIGUE, $fatigueTable))->getValue()
        ); // 30 and 31 are closest bonuses, 31 is taken because higher
        $this->assertSame(
            31,
            $fatigueTable->toBonus(new Fatigue(106, Fatigue::FATIGUE, $fatigueTable))->getValue()
        ); // 31 is the closest bonus (higher in this case)

        $this->assertSame(
            79,
            $fatigueTable->toBonus(new Fatigue(28000, Fatigue::FATIGUE, $fatigueTable))->getValue()
        );
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_value_to_bonus_cause_exception()
    {
        $fatigueTable = new FatigueTable($this->woundsTable);
        $fatigueTable->toBonus(new Fatigue(0, Fatigue::FATIGUE, $fatigueTable));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_value_to_bonus_cause_exception()
    {
        $fatigueTable = new FatigueTable($this->woundsTable);
        $fatigueTable->toBonus(new Fatigue(28001, Fatigue::FATIGUE, $fatigueTable));
    }
}
