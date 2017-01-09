<?php
namespace DrdPlus\Tables\History;

use DrdPlus\Codes\PlayerDecisionCode;
use DrdPlus\Tests\Tables\TableTestInterface;

class PlayerDecisionsTableTest extends \PHPUnit_Framework_TestCase implements TableTestInterface
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame(
            [['decision', 'points_to_primary_properties', 'points_to_secondary_properties', 'maximum_to_single_property']],
            (new PlayerDecisionsTable())->getHeader()
        );
    }

    /**
     * @test
     * @dataProvider provideDecisionAndExpectedPointsToPrimaryProperties
     * @param string $decisionValue
     * @param int $expectedPoints
     */
    public function I_can_get_points_to_primary_properties($decisionValue, $expectedPoints)
    {
        self::assertSame(
            $expectedPoints,
            (new PlayerDecisionsTable())->getPointsToPrimaryProperties(PlayerDecisionCode::getIt($decisionValue))
        );
    }

    public function provideDecisionAndExpectedPointsToPrimaryProperties()
    {
        return [
            [PlayerDecisionCode::EXCEPTIONAL_PROPERTIES, 3],
            [PlayerDecisionCode::COMBINATION_OF_PROPERTIES_AND_BACKGROUND, 2],
            [PlayerDecisionCode::GOOD_REAR, 1],
        ];
    }

    /**
     * @test
     * @dataProvider provideDecisionAndExpectedPointsToSecondaryProperties
     * @param string $decisionValue
     * @param int $expectedPoints
     */
    public function I_can_get_points_to_secondary_properties($decisionValue, $expectedPoints)
    {
        self::assertSame(
            $expectedPoints,
            (new PlayerDecisionsTable())->getPointsToSecondaryProperties(PlayerDecisionCode::getIt($decisionValue))
        );
    }

    public function provideDecisionAndExpectedPointsToSecondaryProperties()
    {
        return [
            [PlayerDecisionCode::EXCEPTIONAL_PROPERTIES, 6],
            [PlayerDecisionCode::COMBINATION_OF_PROPERTIES_AND_BACKGROUND, 4],
            [PlayerDecisionCode::GOOD_REAR, 2],
        ];
    }

    /**
     * @test
     * @dataProvider provideDecisionAndExpectedMaximumPointsToSingleProperty
     * @param string $decisionValue
     * @param int $expectedPoints
     */
    public function I_can_get_maximum_points_to_single_property($decisionValue, $expectedPoints)
    {
        self::assertSame(
            $expectedPoints,
            (new PlayerDecisionsTable())->getMaximumToSingleProperty(PlayerDecisionCode::getIt($decisionValue))
        );
    }

    public function provideDecisionAndExpectedMaximumPointsToSingleProperty()
    {
        return [
            [PlayerDecisionCode::EXCEPTIONAL_PROPERTIES, 3],
            [PlayerDecisionCode::COMBINATION_OF_PROPERTIES_AND_BACKGROUND, 2],
            [PlayerDecisionCode::GOOD_REAR, 1],
        ];
    }
}