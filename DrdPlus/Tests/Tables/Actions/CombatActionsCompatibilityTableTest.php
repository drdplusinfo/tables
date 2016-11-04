<?php
namespace DrdPlus\Tables\Actions;

use DrdPlus\Codes\CombatActions\CombatActionCode;
use DrdPlus\Codes\CombatActions\MeleeCombatActionCode;
use DrdPlus\Codes\CombatActions\RangedCombatActionCode;
use DrdPlus\Tests\Tables\TableTestInterface;
use Granam\Tests\Tools\TestWithMockery;

class CombatActionsCompatibilityTableTest extends TestWithMockery implements TableTestInterface
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame(
            [
                [
                    'action',
                    'move',
                    'run',
                    'swap_weapons',
                    'concentration_on_defense',
                    'put_out_easily_accessible_item',
                    'put_out_hardly_accessible_item',
                    'laying',
                    'sitting_or_on_kneels',
                    'getting_up',
                    'putting_on_armor',
                    'putting_on_armor_with_help',
                    'helping_to_put_on_armor',
                    'attacked_from_behind',
                    'blindfold_fight',
                    'fight_in_reduced_visibility',
                    'attack_on_disabled_opponent',
                    'headless_attack',
                    'cover_of_ally',
                    'flat_attack',
                    'pressure',
                    'retreat',
                    'handover_item',
                    'aimed_shot',
                ],
            ],
            (new CombatActionsCompatibilityTable())->getHeader()
        );
    }

    /**
     * @test
     */
    public function I_can_get_compatibility_to_all_combat_actions()
    {
        $actions = CombatActionCode::getCombatActionCodes();
        $actions = array_merge($actions, MeleeCombatActionCode::getMeleeOnlyCombatActionCodes());
        $actions = array_merge($actions, RangedCombatActionCode::getRangedOnlyCombatActionCodes());
        sort($actions);
        $compatibilities = (new CombatActionsCompatibilityTable())->getHeader()[0];
        array_shift($compatibilities); // remove rows header
        sort($compatibilities);
        self::assertSame(
            $actions,
            $compatibilities,
            'missing: ' . implode(',', array_diff($actions, $compatibilities))
            . "\n" . 'redundant: ' . implode(',', array_diff($compatibilities, $actions))
        );
    }

    /**
     * @test
     * @depends I_can_get_compatibility_to_all_combat_actions
     */
    public function Combinations_are_same_from_both_sides()
    {
        $codes = CombatActionCode::getCombatActionCodes();
        $codes = array_merge($codes, MeleeCombatActionCode::getMeleeOnlyCombatActionCodes());
        $codes = array_merge($codes, RangedCombatActionCode::getRangedOnlyCombatActionCodes());
        $combatActionsCompatibilityTable = new CombatActionsCompatibilityTable();
        foreach ($codes as $someCode) {
            foreach ($codes as $anotherCode) {
                self::assertSame(
                    $combatActionsCompatibilityTable->getValue($someCode, $anotherCode),
                    $combatActionsCompatibilityTable->getValue($anotherCode, $someCode),
                    "'{$someCode}' x '{$anotherCode}' do not match from both sides"
                );
            }
        }
    }

    /**
     * @test
     */
    public function I_can_find_out_easily_if_two_actions_can_be_combined()
    {
        $combatActionsCompatibilityTable = new CombatActionsCompatibilityTable();
        self::assertTrue($combatActionsCompatibilityTable->canCombineTwoActions(
            CombatActionCode::FIGHT_IN_REDUCED_VISIBILITY,
            CombatActionCode::MOVE
        ));
        self::assertFalse($combatActionsCompatibilityTable->canCombineTwoActions(
            CombatActionCode::GETTING_UP,
            CombatActionCode::LAYING
        ));
    }

    /**
     * @test
     */
    public function I_can_find_out_easily_if_any_actions_can_be_combined()
    {
        $combatActionsCompatibilityTable = new CombatActionsCompatibilityTable();
        self::assertTrue($combatActionsCompatibilityTable->canCombineActions([MeleeCombatActionCode::COVER_OF_ALLY]));
        self::assertTrue($combatActionsCompatibilityTable->canCombineActions([
            CombatActionCode::MOVE,
            CombatActionCode::FIGHT_IN_REDUCED_VISIBILITY,
            MeleeCombatActionCode::RETREAT,
        ]));
        self::assertFalse($combatActionsCompatibilityTable->canCombineActions([
            CombatActionCode::MOVE,
            CombatActionCode::FIGHT_IN_REDUCED_VISIBILITY,
            MeleeCombatActionCode::RETREAT,
            RangedCombatActionCode::AIMED_SHOT,
        ]));
    }

}