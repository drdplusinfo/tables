<?php
namespace DrdPlus\Tests\Tables\Activities;

use DrdPlus\Codes\CombatActions\CombatActionCode;
use DrdPlus\Tables\Activities\PossibleActionsAccordingToContrastTable;
use DrdPlus\Tests\Tables\TableTest;
use Granam\Integer\PositiveIntegerObject;

class PossibleActionsAccordingToContrastTableTest extends TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame(
            [[
                PossibleActionsAccordingToContrastTable::CONTRAST,
                PossibleActionsAccordingToContrastTable::POSSIBLE_ACTIONS_EXAMPLE,
                PossibleActionsAccordingToContrastTable::FIGHT_TYPE_BY_CONTRAST,
            ]],
            (new PossibleActionsAccordingToContrastTable())->getHeader()
        );
    }

    /**
     * @test
     * @dataProvider provideContrastAndExpectedActionsExample
     * @param int $contrastValue
     * @param array|string[] $expectedActionExamples
     */
    public function I_can_get_possible_actions_example($contrastValue, array $expectedActionExamples)
    {
        $possibleActionsAccordingToLighting = new PossibleActionsAccordingToContrastTable();
        $possibleActionsExample = $possibleActionsAccordingToLighting
            ->getPossibleActionsExample(new PositiveIntegerObject($contrastValue));
        foreach ($expectedActionExamples as $expectedActionExample) {
            self::assertRegExp(
                '~(^|\W)' . $expectedActionExample . '(\W|$)~',
                $possibleActionsExample
            );
        }
    }

    public function provideContrastAndExpectedActionsExample()
    {
        return [
            [0, ['all']],
            [1, ['reading', 'sewing']],
            [2, ['very problematic reading', 'can not recognize a color']],
            [3, ['work without needs to see details']],
            [4, ['fast march in hills']],
            [5, ['walk in hills', 'run on road']],
            [6, ['walk on road']],
        ];
    }

    /**
     * @test
     * @dataProvider provideContrastAndExpectedFightType
     * @param int $contrastValue
     * @param string $expectedFightType
     */
    public function I_can_get_light_type_by_contrast($contrastValue, $expectedFightType)
    {
        $possibleActionsAccordingToLighting = new PossibleActionsAccordingToContrastTable();
        self::assertSame(
            $expectedFightType,
            $possibleActionsAccordingToLighting->getFightTypeByContrast(new PositiveIntegerObject($contrastValue))
        );
    }

    public function provideContrastAndExpectedFightType()
    {
        return [
            [0, 'common'],
            [1, CombatActionCode::FIGHT_IN_REDUCED_VISIBILITY],
            [2, CombatActionCode::FIGHT_IN_REDUCED_VISIBILITY],
            [3, CombatActionCode::FIGHT_IN_REDUCED_VISIBILITY],
            [4, CombatActionCode::FIGHT_IN_REDUCED_VISIBILITY],
            [5, CombatActionCode::FIGHT_IN_REDUCED_VISIBILITY],
            [6, CombatActionCode::BLINDFOLD_FIGHT],
        ];
    }
}