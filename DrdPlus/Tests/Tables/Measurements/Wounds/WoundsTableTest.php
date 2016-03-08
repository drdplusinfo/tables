<?php
namespace DrdPlus\Tests\Tables\Measurements\Wounds;

use DrdPlus\Tables\Measurements\Wounds\Wounds;
use DrdPlus\Tables\Measurements\Wounds\WoundsBonus;
use DrdPlus\Tables\Measurements\Wounds\WoundsTable;
use Granam\Tests\Tools\TestWithMockery;

class WoundsTableTest extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_get_headers()
    {
        $woundsTable = new WoundsTable();

        self::assertEquals([['bonus', 'wounds']], $woundsTable->getHeader());
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
        self::assertLessThan($maxAttempts, $attempt);
        self::assertSame(1, $zeroOrOne);

        // for bonus -10 to -7 are the same wounds
        self::assertSame(1, $woundsTable->toWounds(new WoundsBonus(-10, $woundsTable))->getValue());
        self::assertSame(1, $woundsTable->toWounds(new WoundsBonus(-9, $woundsTable))->getValue());
        self::assertSame(1, $woundsTable->toWounds(new WoundsBonus(-8, $woundsTable))->getValue());
        self::assertSame(1, $woundsTable->toWounds(new WoundsBonus(-7, $woundsTable))->getValue());

        self::assertSame(3, $woundsTable->toWounds(new WoundsBonus(0, $woundsTable))->getValue());
        self::assertSame(28000, $woundsTable->toWounds(new WoundsBonus(79, $woundsTable))->getValue());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Parts\Exceptions\MissingDataForBonus
     */
    public function I_can_not_use_too_low_bonus()
    {
        $woundsTable = new WoundsTable();
        $woundsTable->toWounds(new WoundsBonus(-22, $woundsTable));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function I_can_use_too_high_bonus()
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
        self::assertSame(-10, $woundsTable->toBonus(new Wounds(1, $woundsTable))->getValue());

        // there are more bonuses for wound 3, the lowest is taken
        self::assertSame(-2, $woundsTable->toBonus(new Wounds(3, $woundsTable))->getValue());

        self::assertSame(30, $woundsTable->toBonus(new Wounds(104, $woundsTable))->getValue()); // 30 is the closest bonus
        self::assertSame(31, $woundsTable->toBonus(new Wounds(105, $woundsTable))->getValue()); // 30 and 31 are closest bonuses, 31 is taken because higher
        self::assertSame(31, $woundsTable->toBonus(new Wounds(106, $woundsTable))->getValue()); // 31 is the closest bonus (higher in this case)

        self::assertSame(79, $woundsTable->toBonus(new Wounds(28000, $woundsTable))->getValue());
    }

    /**
     * @test
     */
    public function I_can_convert_zero_value_to_bonus()
    {
        $woundsTable = new WoundsTable();
        $bonus = $woundsTable->toBonus(new Wounds(0, $woundsTable));
        self::assertSame(-21, $bonus->getValue());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Parts\Exceptions\RequestedDataOutOfTableRange
     */
    public function I_can_not_convert_negative_wounds_to_bonus()
    {
        $woundsTable = new WoundsTable();
        $woundsTable->toBonus(new Wounds(-1, $woundsTable));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Parts\Exceptions\RequestedDataOutOfTableRange
     */
    public function I_can_not_convert_too_high_value_to_bonus()
    {
        $woundsTable = new WoundsTable();
        $woundsTable->toBonus(new Wounds(28001, $woundsTable));
    }
}
