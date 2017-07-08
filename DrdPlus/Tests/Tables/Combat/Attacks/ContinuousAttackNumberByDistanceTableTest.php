<?php
namespace DrdPlus\Tests\Tables\Combat\Attacks;

use DrdPlus\Codes\Units\DistanceUnitCode;
use DrdPlus\Tables\Combat\Attacks\ContinuousAttackNumberByDistanceTable;
use DrdPlus\Tables\Measurements\Distance\Distance;
use DrdPlus\Tables\Measurements\Distance\DistanceBonus;
use DrdPlus\Tables\Measurements\Distance\DistanceTable;
use DrdPlus\Tests\Tables\Combat\Attacks\Partials\AbstractAttackNumberByDistanceTableTest;
use DrdPlus\Calculations\SumAndRound;

class ContinuousAttackNumberByDistanceTableTest extends AbstractAttackNumberByDistanceTableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame(
            [
                ['distance_in_meters', 'distance_bonus', 'ranged_attack_number_modifier'],
            ],
            (new ContinuousAttackNumberByDistanceTable())->getHeader()
        );
    }

    public function provideDistanceAndExpectedModifier(): array
    {
        $testValues = [];
        $distanceTable = new DistanceTable();
        for ($distanceBonus = 1; $distanceBonus < 100; $distanceBonus++) {
            $distanceInMeters = (new DistanceBonus($distanceBonus, $distanceTable))->getDistance()->getMeters();
            $attackNumberModifier = -(SumAndRound::half($distanceBonus) - 9); // PPH page 104 left column
            $testValues[] = [$distanceInMeters, $attackNumberModifier];
        }

        return $testValues;
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Combat\Attacks\Exceptions\DistanceOutOfKnownValues
     * @expectedExceptionMessageRegExp ~999999 m~
     */
    public function I_can_not_get_attack_number_modifier_with_enormous_distance()
    {
        (new ContinuousAttackNumberByDistanceTable())
            ->getAttackNumberModifierByDistance(new Distance(999999, DistanceUnitCode::METER, new DistanceTable()));
    }

}