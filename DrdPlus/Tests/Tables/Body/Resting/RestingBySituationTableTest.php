<?php
namespace DrdPlus\Tests\Tables\Body\Resting;

use DrdPlus\Tables\Body\Resting\RestingBySituationTable;
use DrdPlus\Tables\Body\Resting\RestingSituationPercents;
use DrdPlus\Tests\Tables\TableTest;
use Granam\Tests\Tools\TestWithMockery;

class RestingBySituationTableTest extends TestWithMockery implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $restingBySituationTable = new RestingBySituationTable();
        self::assertSame(
            [['situation', 'bonus_from', 'bonus_to', 'can_be_more']],
            $restingBySituationTable->getHeader()
        );
    }

    /**
     * @test
     */
    public function I_can_get_values()
    {
        $restingBySituationTable = new RestingBySituationTable();
        self::assertSame(
            [
                'half_time_of_rest_or_sleep' => ['bonus_from' => -6, 'bonus_to' => -6, 'can_be_more' => false],
                'quarter_time_of_rest_or_sleep' => ['bonus_from' => -12, 'bonus_to' => -12, 'can_be_more' => false],
                'foul_conditions' => ['bonus_from' => -12, 'bonus_to' => -6, 'can_be_more' => true],
                'bad_conditions' => ['bonus_from' => -5, 'bonus_to' => -3, 'can_be_more' => false],
                'impaired_conditions' => ['bonus_from' => -2, 'bonus_to' => -1, 'can_be_more' => false],
                'good_conditions' => ['bonus_from' => 0, 'bonus_to' => 0, 'can_be_more' => false],
            ],
            $restingBySituationTable->getIndexedValues()
        );
    }

    /**
     * @test
     * @dataProvider provideSituationAndExpectedBonus
     * @param string $situationCode
     * @param int $percentsOfSituation
     * @param int $expectedRestingBonus
     */
    public function I_can_get_resting_bonus_by_situation($situationCode, $percentsOfSituation, $expectedRestingBonus)
    {
        $restingBySituationTable = new RestingBySituationTable();
        self::assertSame(
            $expectedRestingBonus,
            $restingBySituationTable->getRestingBonusBySituation(
                $situationCode,
                $this->createRestingSituationPercents($percentsOfSituation)
            )
        );
    }

    public function provideSituationAndExpectedBonus()
    {
        return [
            ['half_time_of_rest_or_sleep', 100, -6],
            ['half_time_of_rest_or_sleep', 0, -6],
            ['foul_conditions', 0, -6],
            ['foul_conditions', 100, -12],
            ['foul_conditions', 150, -15],
            ['bad_conditions', 0, -3],
            ['bad_conditions', 50, -4],
            ['bad_conditions', 80, -5],
            ['good_conditions', 12, 0],
        ];
    }

    /**
     * @param int $percents
     * @return \Mockery\MockInterface|RestingSituationPercents
     */
    private function createRestingSituationPercents($percents)
    {
        $healingConditionsPercents = $this->mockery(RestingSituationPercents::class);
        $healingConditionsPercents->shouldReceive('getValue')
            ->andReturn($percents);
        $healingConditionsPercents->shouldReceive('getRate')
            ->andReturn($percents / 100);

        return $healingConditionsPercents;
    }
}
