<?php
namespace DrdPlus\Tests\Tables\History;

use DrdPlus\Codes\PlayerDecisionCode;
use DrdPlus\Tables\History\BackgroundPointsTable;
use DrdPlus\Tests\Tables\TableTestInterface;
use Granam\Tests\Tools\TestWithMockery;

class BackgroundPointsTableTest extends TestWithMockery implements TableTestInterface
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame([['player_decision', 'background_points']], (new BackgroundPointsTable())->getHeader());
    }

    /**
     * @test
     * @dataProvider providePlayerDecisionAndExpectedBackgroundPoints
     * @param string $playerDecision
     * @param int $expectedBackgroundPoints
     */
    public function I_can_get_background_points_for_player_decision($playerDecision, $expectedBackgroundPoints)
    {
        $backgroundPointsTable = new BackgroundPointsTable();
        self::assertSame(
            $expectedBackgroundPoints,
            $backgroundPointsTable->getBackgroundPointsByPlayerDecision(PlayerDecisionCode::getIt($playerDecision))
        );
    }

    public function providePlayerDecisionAndExpectedBackgroundPoints()
    {
        return [
            [PlayerDecisionCode::EXCEPTIONAL_PROPERTIES, 5],
            [PlayerDecisionCode::COMBINATION_OF_PROPERTIES_AND_BACKGROUND, 10],
            [PlayerDecisionCode::GOOD_BACKGROUND, 15],
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\History\Exceptions\UnknownFate
     * @expectedExceptionMessageRegExp ~homeless~
     */
    public function I_can_not_get_background_points_for_unknown_player_decision()
    {
        (new BackgroundPointsTable())->getBackgroundPointsByPlayerDecision($this->createPlayerDecision('homeless'));
    }

    /**
     * @param string $value
     * @return \Mockery\MockInterface|PlayerDecisionCode
     */
    private function createPlayerDecision($value)
    {
        $fate = $this->mockery(PlayerDecisionCode::class);
        $fate->shouldReceive('getValue')
            ->andReturn($value);
        $fate->shouldReceive('__toString')
            ->andReturn((string)$value);

        return $fate;
    }
}