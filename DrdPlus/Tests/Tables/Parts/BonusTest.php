<?php
namespace DrdPlus\Tests\Tables\Parts;

use DrdPlus\Tables\Parts\AbstractBonus;
use DrdPlus\Tests\Tables\TestWithMockery;
use Granam\Integer\IntegerInterface;

class BonusTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_create_bonus()
    {
        $bonus = new DeAbstractedBonus($value = 123);
        $this->assertSame($value, $bonus->getValue());
    }

    /**
     * @test
     */
    public function I_can_create_bonus_from_float_without_decimal()
    {
        $bonus = new DeAbstractedBonus($value = 123.0);
        $this->assertSame(intval($value), $bonus->getValue());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Parts\Exceptions\BonusRequiresInteger
     */
    public function I_cannot_create_bonus_from_number_with_decimal()
    {
        new DeAbstractedBonus($value = 123.456);
    }

    /**
     * @test
     */
    public function I_can_use_bonus_as_an_integer_object()
    {
        $bonus = new DeAbstractedBonus($value = 123456);
        $this->assertInstanceOf(IntegerInterface::class, $bonus);
    }

}

/** inner */
class DeAbstractedBonus extends AbstractBonus
{
    public function __construct($value)
    {
        parent::__construct($value);
    }
}
