<?php
namespace DrdPlus\Tests\Tables\Measurements\BaseOfWounds;

use DrdPlus\Tables\Measurements\BaseOfWounds\BaseOfWoundsTable;
use Granam\Tests\Tools\TestWithMockery;

class BaseOfWoundsTableTest extends TestWithMockery
{

    /**
     * @test
     */
    public function I_get_empty_arrays_as_headers()
    {
        $baseOfWoundsTable = new BaseOfWoundsTable();

        self::assertEquals([], $baseOfWoundsTable->getHeader());
    }

    /**
     * @test
     */
    public function I_can_get_indexed_values_and_values_which_are_same()
    {
        $baseOfWoundsTable = new BaseOfWoundsTable();
        self::assertEquals(
            $baseOfWoundsTable->getValues(),
            $baseOfWoundsTable->getIndexedValues()
        );
        self::assertEquals(
            [
                ['⊕', -5, -4, -3, -2, -1, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
                [-5, -4, -3, -3, -2, -2, -1, 0, 0, 1, 2, 2, 3, 4, 5, 6, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 15],
                [-4, -3, -3, -2, -2, -1, -1, 0, 1, 1, 2, 3, 3, 4, 5, 6, 7, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                [-3, -3, -2, -2, -1, -1, 0, 0, 1, 2, 2, 3, 4, 4, 5, 6, 7, 8, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                [-2, -2, -2, -1, -1, 0, 0, 1, 1, 2, 3, 3, 4, 5, 5, 6, 7, 8, 9, 9, 10, 11, 12, 13, 14, 15, 16],
                [-1, -2, -1, -1, 0, 0, 1, 1, 2, 2, 3, 4, 4, 5, 6, 6, 7, 8, 9, 10, 10, 11, 12, 13, 14, 15, 16],
                [0, -1, -1, 0, 0, 1, 1, 2, 2, 3, 3, 4, 5, 5, 6, 7, 7, 8, 9, 10, 11, 11, 12, 13, 14, 15, 16],
                [1, 0, 0, 0, 1, 1, 2, 2, 3, 3, 4, 4, 5, 6, 6, 7, 8, 8, 9, 10, 11, 12, 12, 13, 14, 15, 16],
                [2, 0, 1, 1, 1, 2, 2, 3, 3, 4, 4, 5, 5, 6, 7, 7, 8, 9, 9, 10, 11, 12, 13, 13, 14, 15, 16],
                [3, 1, 1, 2, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 7, 8, 8, 9, 10, 10, 11, 12, 13, 14, 14, 15, 16],
                [4, 2, 2, 2, 3, 3, 3, 4, 4, 5, 5, 6, 6, 7, 7, 8, 9, 9, 10, 11, 11, 12, 13, 14, 15, 15, 16],
                [5, 2, 3, 3, 3, 4, 4, 4, 5, 5, 6, 6, 7, 7, 8, 8, 9, 10, 10, 11, 12, 12, 13, 14, 15, 16, 16],
                [6, 3, 3, 4, 4, 4, 5, 5, 5, 6, 6, 7, 7, 8, 8, 9, 9, 10, 11, 11, 12, 13, 13, 14, 15, 16, 17],
                [7, 4, 4, 4, 5, 5, 5, 6, 6, 6, 7, 7, 8, 8, 9, 9, 10, 10, 11, 12, 12, 13, 14, 14, 15, 16, 17],
                [8, 5, 5, 5, 5, 6, 6, 6, 7, 7, 7, 8, 8, 9, 9, 10, 10, 11, 11, 12, 13, 13, 14, 15, 15, 16, 17],
                [9, 6, 6, 6, 6, 6, 7, 7, 7, 8, 8, 8, 9, 9, 10, 10, 11, 11, 12, 12, 13, 14, 14, 15, 16, 16, 17],
                [10, 6, 7, 7, 7, 7, 7, 8, 8, 8, 9, 9, 9, 10, 10, 11, 11, 12, 12, 13, 13, 14, 15, 15, 16, 17, 17],
                [11, 7, 7, 8, 8, 8, 8, 8, 9, 9, 9, 10, 10, 10, 11, 11, 12, 12, 13, 13, 14, 14, 15, 16, 16, 17, 18],
                [12, 8, 8, 8, 9, 9, 9, 9, 9, 10, 10, 10, 11, 11, 11, 12, 12, 13, 13, 14, 14, 15, 15, 16, 17, 17, 18],
                [13, 9, 9, 9, 9, 10, 10, 10, 10, 10, 11, 11, 11, 12, 12, 12, 13, 13, 14, 14, 15, 15, 16, 16, 17, 18, 18],
                [14, 10, 10, 10, 10, 10, 11, 11, 11, 11, 11, 12, 12, 12, 13, 13, 13, 14, 14, 15, 15, 16, 16, 17, 17, 18, 19],
                [15, 11, 11, 11, 11, 11, 11, 12, 12, 12, 12, 12, 13, 13, 13, 14, 14, 14, 15, 15, 16, 16, 17, 17, 18, 18, 19],
                [16, 12, 12, 12, 12, 12, 12, 12, 13, 13, 13, 13, 13, 14, 14, 14, 15, 15, 15, 16, 16, 17, 17, 18, 18, 19, 19],
                [17, 13, 13, 13, 13, 13, 13, 13, 13, 14, 14, 14, 14, 14, 15, 15, 15, 16, 16, 16, 17, 17, 18, 18, 19, 19, 20],
                [18, 14, 14, 14, 14, 14, 14, 14, 14, 14, 15, 15, 15, 15, 15, 16, 16, 16, 17, 17, 17, 18, 18, 19, 19, 20, 20],
                [19, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 16, 16, 16, 16, 16, 17, 17, 17, 18, 18, 18, 19, 19, 20, 20, 21],
                [20, 15, 16, 16, 16, 16, 16, 16, 16, 16, 16, 16, 17, 17, 17, 17, 17, 18, 18, 18, 19, 19, 19, 20, 20, 21, 21],
            ],
            $baseOfWoundsTable->getIndexedValues()
        );
    }

    /**
     * @test
     */
    public function I_can_calculate_base_of_wounds()
    {
        $baseOfWoundsTable = new BaseOfWoundsTable();

        self::assertSame(-4, $baseOfWoundsTable->calculateBaseOfWounds(-5, -5));
        self::assertSame(1, $baseOfWoundsTable->calculateBaseOfWounds(0, 0));
        self::assertSame(21, $baseOfWoundsTable->calculateBaseOfWounds(20, 20));
        self::assertSame(15, $baseOfWoundsTable->calculateBaseOfWounds(-5, 20));
        self::assertSame(15, $baseOfWoundsTable->calculateBaseOfWounds(20, -5));
        self::assertSame(15, $baseOfWoundsTable->getBonusesIntersection([20, -5]));
        self::assertSame(7, $baseOfWoundsTable->getBonusesIntersection([-5, -4, -3, 10]));
        for ($bonus = -5; $bonus <= 20; $bonus++) {
            self::assertSame($bonus, $baseOfWoundsTable->getBonusesIntersection([$bonus]));
        }
    }

    /**
     * @test
     */
    public function I_can_sum_bonuses() // like weights
    {
        $baseOfWoundsTable = new BaseOfWoundsTable();

        self::assertNull($baseOfWoundsTable->sumBonuses([]));
        self::assertSame(123, $baseOfWoundsTable->sumBonuses([123]));
        self::assertSame(5, $baseOfWoundsTable->sumBonuses([-5, -5, -5]));
        self::assertSame(14, $baseOfWoundsTable->sumBonuses([-5, 0, 10]));
        self::assertSame(13, $baseOfWoundsTable->sumBonuses([-5, -4, -3, -2, -1, 0]));
    }

    /**
     * @test
     */
    public function I_can_double_bonus()
    {
        $baseOfWoundsTable = new BaseOfWoundsTable();

        self::assertSame(11, $baseOfWoundsTable->doubleBonus(5));
    }

    /**
     * @test
     */
    public function I_can_half_bonus()
    {
        $baseOfWoundsTable = new BaseOfWoundsTable();

        self::assertSame(-1, $baseOfWoundsTable->halfBonus(5));
    }

    /**
     * @test
     */
    public function I_can_ten_times_multiple_bonus()
    {
        $baseOfWoundsTable = new BaseOfWoundsTable();

        self::assertSame(25, $baseOfWoundsTable->tenMultipleBonus(5));
    }

    /**
     * @test
     */
    public function I_can_ten_times_divide_bonus()
    {
        $baseOfWoundsTable = new BaseOfWoundsTable();

        self::assertSame(-15, $baseOfWoundsTable->tenMinifyBonus(5));
    }

}
