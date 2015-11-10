<?php
namespace DrdPlus\Tests\Tables\Measurements\BaseOfWounds;

use DrdPlus\Tables\Measurements\BaseOfWounds\BaseOfWoundsTable;
use DrdPlus\Tests\Tables\Measurements\TestWithMockery;

class BaseOfWoundsTableTest extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_calculate_base_of_wounds()
    {
        $baseOfWoundsTable = new BaseOfWoundsTable();

        $this->assertSame(-4, $baseOfWoundsTable->calculateBaseOfWounds(-5, -5));
        $this->assertSame(1, $baseOfWoundsTable->calculateBaseOfWounds(0, 0));
        $this->assertSame(21, $baseOfWoundsTable->calculateBaseOfWounds(20, 20));
        $this->assertSame(15, $baseOfWoundsTable->calculateBaseOfWounds(-5, 20));
        $this->assertSame(15, $baseOfWoundsTable->calculateBaseOfWounds(20, -5));
        $this->assertSame(15, $baseOfWoundsTable->getBonusesIntersection([20, -5]));
        $this->assertSame(7, $baseOfWoundsTable->getBonusesIntersection([-5, -4, -3, 10]));
        for ($bonus = -5; $bonus <= 20; $bonus++) {
            $this->assertSame($bonus, $baseOfWoundsTable->getBonusesIntersection([$bonus]));
        }
    }

    /**
     * @test
     */
    public function I_can_sum_bonuses() // like weights
    {
        $baseOfWoundsTable = new BaseOfWoundsTable();

        $this->assertSame(null, $baseOfWoundsTable->sumBonuses([]));
        $this->assertSame(123, $baseOfWoundsTable->sumBonuses([123]));
        $this->assertSame(5, $baseOfWoundsTable->sumBonuses([-5, -5, -5]));
        $this->assertSame(14, $baseOfWoundsTable->sumBonuses([-5, 0, 10]));
        $this->assertSame(13, $baseOfWoundsTable->sumBonuses([-5, -4, -3, -2, -1, 0]));
    }

    /**
     * @test
     */
    public function I_can_double_bonus()
    {
        $baseOfWoundsTable = new BaseOfWoundsTable();

        $this->assertSame(11, $baseOfWoundsTable->doubleBonus(5));
    }

    /**
     * @test
     */
    public function I_can_half_bonus()
    {
        $baseOfWoundsTable = new BaseOfWoundsTable();

        $this->assertSame(-1, $baseOfWoundsTable->halfBonus(5));
    }

    /**
     * @test
     */
    public function I_can_ten_times_multiple_bonus()
    {
        $baseOfWoundsTable = new BaseOfWoundsTable();

        $this->assertSame(25, $baseOfWoundsTable->tenMultipleBonus(5));
    }

    /**
     * @test
     */
    public function I_can_ten_times_divide_bonus()
    {
        $baseOfWoundsTable = new BaseOfWoundsTable();

        $this->assertSame(-15, $baseOfWoundsTable->tenMinifyBonus(5));
    }

}
