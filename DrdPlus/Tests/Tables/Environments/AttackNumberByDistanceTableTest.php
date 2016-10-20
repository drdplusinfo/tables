<?php
namespace DrdPlus\Tests\Tables\Environments;

use DrdPlus\Tables\Environments\AttackNumberByDistanceTable;
use DrdPlus\Tests\Tables\Environments\Partials\AbstractAttackNumberByDistanceTableTest;

class AttackNumberByDistanceTableTest extends AbstractAttackNumberByDistanceTableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame(
            [
                ['distance_in_meters_up_to', 'distance_bonus', 'ranged_attack_number_modification'],
            ],
            (new AttackNumberByDistanceTable())->getHeader()
        );
    }

    public function provideDistanceAndExpectedModifier()
    {
        return [
            [0, 3],
            [1, 3],
            [2, 3],
            [3.1, 3],
            [3.2, 0],
            [4, 0],
            [5.5, 0],
            [5.6, -3],
            [5.7, -3],
            [10.9, -3],
            [11, -6],
            [21.9, -6],
            [22, -9],
            [44.9, -9],
            [45, -12],
            [90, -12],
            [350, -12],
        ];
    }

}