<?php
namespace DrdPlus\Tables\Actions;

use DrdPlus\Codes\CombatActions\CombatActionCode;
use DrdPlus\Codes\CombatActions\MeleeCombatActionCode;
use DrdPlus\Codes\CombatActions\RangedCombatActionCode;
use DrdPlus\Tables\Partials\AbstractFileTable;

/**
 * See PPH page 102 @link https://pph.drdplus.jaroslavtyc.com/#bojove_akce
 * and PPH page 107 @link https://pph.drdplus.jaroslavtyc.com/#dalsi_bojove_akce
 */
class CombatActionsCompatibilityTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/combat_actions_compatibility.csv';
    }

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            CombatActionCode::MOVE => self::BOOLEAN,
            CombatActionCode::RUN => self::BOOLEAN,
            CombatActionCode::SWAP_WEAPONS => self::BOOLEAN,
            CombatActionCode::CONCENTRATION_ON_DEFENSE => self::BOOLEAN,
            CombatActionCode::PUT_OUT_EASILY_ACCESSIBLE_ITEM => self::BOOLEAN,
            CombatActionCode::PUT_OUT_HARDLY_ACCESSIBLE_ITEM => self::BOOLEAN,
            CombatActionCode::LAYING => self::BOOLEAN,
            CombatActionCode::SITTING_OR_ON_KNEELS => self::BOOLEAN,
            CombatActionCode::GETTING_UP => self::BOOLEAN,
            CombatActionCode::PUTTING_ON_ARMOR => self::BOOLEAN,
            CombatActionCode::PUTTING_ON_ARMOR_WITH_HELP => self::BOOLEAN,
            CombatActionCode::HELPING_TO_PUT_ON_ARMOR => self::BOOLEAN,
            CombatActionCode::ATTACKED_FROM_BEHIND => self::BOOLEAN,
            CombatActionCode::BLINDFOLD_FIGHT => self::BOOLEAN,
            CombatActionCode::FIGHT_IN_REDUCED_VISIBILITY => self::BOOLEAN,
            CombatActionCode::ATTACK_ON_DISABLED_OPPONENT => self::BOOLEAN,
            MeleeCombatActionCode::HEADLESS_ATTACK => self::BOOLEAN,
            MeleeCombatActionCode::COVER_OF_ALLY => self::BOOLEAN,
            MeleeCombatActionCode::FLAT_ATTACK => self::BOOLEAN,
            MeleeCombatActionCode::PRESSURE => self::BOOLEAN,
            MeleeCombatActionCode::RETREAT => self::BOOLEAN,
            MeleeCombatActionCode::HANDOVER_ITEM => self::BOOLEAN,
            RangedCombatActionCode::AIMED_SHOT => self::BOOLEAN,
        ];
    }

    const ACTION = 'action';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [self::ACTION];
    }

    /**
     * @param string $someAction
     * @param string $anotherAction
     * @return bool
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function canCombineTwoActions($someAction, $anotherAction)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue($someAction, $anotherAction);
    }

    /**
     * @param array|string[] $actions
     * @return bool
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredColumnNotFound
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function canCombineActions(array $actions)
    {
        if (count($actions) < 2) {
            return true;
        }
        foreach ($actions as $someAction) {
            foreach ($actions as $anotherAction) {
                /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
                if (!$this->getValue($someAction, $anotherAction)) {
                    return false;
                }
            }
        }

        return true;
    }

}