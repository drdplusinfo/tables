<?php
namespace DrdPlus\Tests\Tables\Amount;

use DrdPlus\Tables\Amount\Amount;
use DrdPlus\Tables\Amount\AmountBonus;
use DrdPlus\Tables\Amount\AmountTable;
use DrdPlus\Tests\Tables\TestWithMockery;

class AmountTableTest extends TestWithMockery
{

    /**
     * @test
     */
    public function can_convert_bonus_to_amount()
    {
        $amountTable = new AmountTable();
        $maxAttempts = 10000;
        $attempt = 1;
        do {
            $zeroOrOne = $amountTable->toAmount(new AmountBonus(-20, $amountTable));
            if ($zeroOrOne->getValue() === 1.0) {
                break;
            }
        } while ($attempt++ < $maxAttempts);
        $this->assertLessThan($maxAttempts, $attempt);
        $this->assertSame(1.0, $zeroOrOne->getValue());
        $this->assertSame(
            1.0,
            $amountTable->toAmount(new AmountBonus(0, $amountTable))->getValue()
        );
        $this->assertSame(
            90000.0,
            $amountTable->toAmount(new AmountBonus(99, $amountTable))->getValue()
        );
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_bonus_to_amount_cause_exception()
    {
        $amountTable = new AmountTable();
        $amountTable->toAmount(new AmountBonus(-21, $amountTable));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_bonus_to_amount_cause_exception()
    {
        $amountTable = new AmountTable();
        $amountTable->toAmount(new AmountBonus(100, $amountTable));
    }

    /**
     * @test
     */
    public function can_convert_amount_to_bonus()
    {
        $amountTable = new AmountTable();
        $this->assertSame(
            0,
            $amountTable->toBonus(new Amount(1, Amount::AMOUNT, $amountTable))->getValue()
        );

        $this->assertSame(
            40,
            $amountTable->toBonus(new Amount(104, Amount::AMOUNT, $amountTable))->getValue()
        ); // 40 is the closest bonus (lower in this case)
        $this->assertSame(
            41,
            $amountTable->toBonus(new Amount(105, Amount::AMOUNT, $amountTable))->getValue()
        ); // 40 and 41 are closest bonuses, 41 is taken because higher
        $this->assertSame(
            41,
            $amountTable->toBonus(new Amount(106, Amount::AMOUNT, $amountTable))->getValue()
        ); // 41 is the closest bonus (higher in this case)

        $this->assertSame(
            99,
            $amountTable->toBonus(new Amount(90000, Amount::AMOUNT, $amountTable))->getValue()
        );
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_value_to_bonus_cause_exception()
    {
        $amountTable = new AmountTable();
        $amountTable->toBonus(new Amount(0, Amount::AMOUNT, $amountTable));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_value_to_bonus_cause_exception()
    {
        $amountTable = new AmountTable();
        $amountTable->toBonus(new Amount(90001, Amount::AMOUNT, $amountTable));
    }
}
