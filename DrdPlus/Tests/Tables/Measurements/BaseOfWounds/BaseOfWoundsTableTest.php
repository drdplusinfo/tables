<?php
namespace DrdPlus\Tests\Tables\Measurements\BaseOfWounds;

use DrdPlus\Properties\Base\Strength;
use DrdPlus\Tables\Measurements\BaseOfWounds\BaseOfWoundsTable;
use DrdPlus\Tests\Tables\TableTest;
use Granam\Integer\IntegerObject;

class BaseOfWoundsTableTest extends TableTest
{

    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertEquals([], (new BaseOfWoundsTable())->getHeader());
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

        self::assertSame(-4, $baseOfWoundsTable->calculateBaseOfWounds(Strength::getIt(-5), -5));
        self::assertSame(1, $baseOfWoundsTable->calculateBaseOfWounds(Strength::getIt(0), new IntegerObject(0)));
        self::assertSame(21, $baseOfWoundsTable->calculateBaseOfWounds(Strength::getIt(20), 20));
        self::assertSame(15, $baseOfWoundsTable->calculateBaseOfWounds(Strength::getIt(-5), 20));
        self::assertSame(15, $baseOfWoundsTable->calculateBaseOfWounds(Strength::getIt(20), -5));
        self::assertSame(15, $baseOfWoundsTable->getBonusesIntersection([20, -5]));
        self::assertSame(7, $baseOfWoundsTable->getBonusesIntersection([-5, -4, new IntegerObject(-3), 10]));
        for ($bonus = -5; $bonus <= 20; $bonus++) {
            self::assertSame($bonus, $baseOfWoundsTable->getBonusesIntersection([$bonus]));
        }
    }

    /**
     * @test
     * @dataProvider provideNoBonuses
     * @expectedException \DrdPlus\Tables\Measurements\BaseOfWounds\Exceptions\SumOfBonusesResultsIntoNull
     * @param array $bonuses
     */
    public function I_can_not_intersect_nothing_or_null_as_first_bonus(array $bonuses)
    {
        (new BaseOfWoundsTable())->getBonusesIntersection($bonuses);
    }

    public function provideNoBonuses()
    {
        return [
            [[]],
            [[null]],
            [[null, 1]],
            [[null, 123, 456]],
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\BaseOfWounds\Exceptions\BonusToIntersectIsOutOfKnownValues
     * @expectedExceptionMessageRegExp ~9999~
     */
    public function I_can_not_intersect_bonuses_if_first_is_out_of_range()
    {
        (new BaseOfWoundsTable())->getBonusesIntersection([9999, 0]);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\BaseOfWounds\Exceptions\BonusToIntersectIsOutOfKnownValues
     * @expectedExceptionMessageRegExp ~8765~
     */
    public function I_can_not_intersect_bonuses_if_second_is_out_of_range()
    {
        (new BaseOfWoundsTable())->getBonusesIntersection([0, 8765]);
    }

    /**
     * @test
     */
    public function I_can_sum_bonuses() // like weights
    {
        $baseOfWoundsTable = new BaseOfWoundsTable();

        self::assertSame(123, $baseOfWoundsTable->sumBonuses([123]));
        self::assertSame(5, $baseOfWoundsTable->sumBonuses([-5, new IntegerObject(-5), -5]));
        self::assertSame(14, $baseOfWoundsTable->sumBonuses([new IntegerObject(-5), new IntegerObject(0), new IntegerObject(10)]));
        self::assertSame(13, $baseOfWoundsTable->sumBonuses([-5, -4, new IntegerObject(-3), -2, new IntegerObject(-1), 0]));
    }

    /**
     * @test
     * @dataProvider provideNoBonuses
     * @expectedException \DrdPlus\Tables\Measurements\BaseOfWounds\Exceptions\SumOfBonusesResultsIntoNull
     * @param array $bonuses
     */
    public function I_can_not_sum_nothing_or_null_as_first_bonus(array $bonuses)
    {
        (new BaseOfWoundsTable())->sumBonuses($bonuses);
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

        self::assertSame(25, $baseOfWoundsTable->tenMultipleBonus(new IntegerObject(5)));
    }

    /**
     * @test
     */
    public function I_can_ten_times_divide_bonus()
    {
        $baseOfWoundsTable = new BaseOfWoundsTable();

        self::assertSame(-15, $baseOfWoundsTable->tenMinifyBonus(new IntegerObject(5)));
    }

    /**
     * @test
     */
    public function I_can_get_single_value_by_its_indexes()
    {
        // value on indexes, not on coordinates-by-values
        self::assertSame(-1, (new BaseOfWoundsTable())->getValue(3, new IntegerObject(5)));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\BaseOfWounds\Exceptions\NoRowExistsOnProvidedIndex
     */
    public function I_can_not_get_single_value_by_invalid_row_index()
    {
        self::assertSame(-1, (new BaseOfWoundsTable())->getValue(new IntegerObject(999), new IntegerObject(5)));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\BaseOfWounds\Exceptions\NoColumnExistsOnProvidedIndex
     */
    public function I_can_not_get_single_value_by_invalid_column_index()
    {
        self::assertSame(-1, (new BaseOfWoundsTable())->getValue(6, 999));
    }

}