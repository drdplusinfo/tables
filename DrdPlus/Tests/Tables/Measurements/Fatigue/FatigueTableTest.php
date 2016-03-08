<?php
namespace DrdPlus\Tests\Tables\Measurements\Derived\Fatigue;

use DrdPlus\Tables\Measurements\Fatigue\Fatigue;
use DrdPlus\Tables\Measurements\Fatigue\FatigueBonus;
use DrdPlus\Tables\Measurements\Fatigue\FatigueTable;
use DrdPlus\Tables\Measurements\Wounds\WoundsTable;
use Granam\Tests\Tools\TestWithMockery;

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
    public function I_can_get_headers_same_as_from_wounds_table()
    {
        $experiencesTable = new FatigueTable($this->woundsTable);

        self::assertEquals($this->woundsTable->getHeader(), $experiencesTable->getHeader());
    }

    /**
     * @test
     */
    public function I_can_get_values_same_as_from_wounds_table()
    {
        $experiencesTable = new FatigueTable($woundsTable = new WoundsTable());

        self::assertEquals($woundsTable->getValues(), $experiencesTable->getValues());
        self::assertEquals($woundsTable->getIndexedValues(), $experiencesTable->getIndexedValues());
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
        self::assertLessThan($maxAttempts, $attempt);
        self::assertSame(1, $zeroOrOne);

        // for bonus -10 to -7 are the same fatigue
        self::assertSame(
            1,
            $fatigueTable->toFatigue(new FatigueBonus(-10, $fatigueTable))->getValue()
        );
        self::assertSame(
            1,
            $fatigueTable->toFatigue(new FatigueBonus(-9, $fatigueTable))->getValue()
        );
        self::assertSame(
            1,
            $fatigueTable->toFatigue(new FatigueBonus(-8, $fatigueTable))->getValue()
        );
        self::assertSame(
            1,
            $fatigueTable->toFatigue(new FatigueBonus(-7, $fatigueTable))->getValue()
        );
        self::assertSame(
            3,
            $fatigueTable->toFatigue(new FatigueBonus(0, $fatigueTable))->getValue()
        );
        self::assertSame(
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
        $fatigueTable->toFatigue(new FatigueBonus(-22, $fatigueTable));
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
        self::assertSame(
            -10,
            $fatigueTable->toBonus(new Fatigue(1, Fatigue::FATIGUE, $fatigueTable))->getValue()
        );

        // there are more bonuses for wound 3, the lowest is taken
        self::assertSame(
            -2,
            $fatigueTable->toBonus(new Fatigue(3, Fatigue::FATIGUE, $fatigueTable))->getValue()
        );

        self::assertSame(
            30,
            $fatigueTable->toBonus(new Fatigue(104, Fatigue::FATIGUE, $fatigueTable))->getValue()
        ); // 30 is the closest bonus
        self::assertSame(
            31,
            $fatigueTable->toBonus(new Fatigue(105, Fatigue::FATIGUE, $fatigueTable))->getValue()
        ); // 30 and 31 are closest bonuses, 31 is taken because higher
        self::assertSame(
            31,
            $fatigueTable->toBonus(new Fatigue(106, Fatigue::FATIGUE, $fatigueTable))->getValue()
        ); // 31 is the closest bonus (higher in this case)

        self::assertSame(
            79,
            $fatigueTable->toBonus(new Fatigue(28000, Fatigue::FATIGUE, $fatigueTable))->getValue()
        );
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Parts\Exceptions\RequestedDataOutOfTableRange
     */
    public function I_can_not_use_negative_fatigue_bonus()
    {
        $fatigueTable = new FatigueTable($this->woundsTable);
        $fatigueTable->toBonus(new Fatigue(-1, Fatigue::FATIGUE, $fatigueTable));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Parts\Exceptions\RequestedDataOutOfTableRange
     */
    public function too_high_value_to_bonus_cause_exception()
    {
        $fatigueTable = new FatigueTable($this->woundsTable);
        $fatigueTable->toBonus(new Fatigue(28001, Fatigue::FATIGUE, $fatigueTable));
    }
}
