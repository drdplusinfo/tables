<?php
namespace DrdPlus\Tables\Actions;

use DrdPlus\Codes\Armaments\WeaponlikeCode;
use DrdPlus\Codes\CombatActions\CombatActionCode;
use DrdPlus\Codes\CombatActions\MeleeCombatActionCode;
use DrdPlus\Codes\CombatActions\RangedCombatActionCode;
use DrdPlus\Tables\Armaments\Armourer;
use DrdPlus\Tables\Partials\AbstractFileTable;

class CombatActionsWithWeaponTypeCompatibilityTable extends AbstractFileTable
{
    /**
     * @var Armourer
     */
    private $armourer;

    /**
     * @param Armourer $armourer
     */
    public function __construct(Armourer $armourer)
    {
        $this->armourer = $armourer;
    }

    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/combat_actions_with_weapon_type_compatibility_table.csv';
    }

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            CombatActionCode::MOVE => self::BOOLEAN,
            CombatActionCode::RUN => self::BOOLEAN,
            CombatActionCode::MAIN_HAND_ONLY_MELEE_ATTACK => self::BOOLEAN,
            CombatActionCode::OFFHAND_ONLY_MELEE_ATTACK => self::BOOLEAN,
            CombatActionCode::TWO_HANDS_MELEE_ATTACK => self::BOOLEAN,
            CombatActionCode::MAIN_HAND_ONLY_RANGED_ATTACK => self::BOOLEAN,
            CombatActionCode::OFFHAND_ONLY_RANGED_ATTACK => self::BOOLEAN,
            CombatActionCode::TWO_HANDS_RANGED_ATTACK => self::BOOLEAN,
            CombatActionCode::TWO_HANDS_DEFENSE => self::BOOLEAN,
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
            CombatActionCode::HANDOVER_ITEM => self::BOOLEAN,
            MeleeCombatActionCode::HEADLESS_ATTACK => self::BOOLEAN,
            MeleeCombatActionCode::COVER_OF_ALLY => self::BOOLEAN,
            MeleeCombatActionCode::FLAT_ATTACK => self::BOOLEAN,
            MeleeCombatActionCode::PRESSURE => self::BOOLEAN,
            MeleeCombatActionCode::RETREAT => self::BOOLEAN,
            RangedCombatActionCode::AIMED_SHOT => self::BOOLEAN,
        ];
    }

    const ATTACK_WITH_WEAPON_TYPE = 'attack_with_weapon_type';
    const MELEE = 'melee';
    const SHOOTING = 'shooting';
    const THROWING = 'throwing';
    const ONE_HANDED = 'one_handed';
    const TWO_HANDED = 'two_handed';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [self::ATTACK_WITH_WEAPON_TYPE];
    }

    /**
     * Gives a list of all possible actions with given weapon.
     * Note about spear: that weapon can be used both for melee combat as well as ranged (throwing) - for this weapon
     * you will get merged pool of both melee and ranged actions.
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @return array|string[]
     */
    public function getActionsPossibleWhenAttackingWith(WeaponlikeCode $weaponlikeCode)
    {
        $rangeGroupPossibleActions = [];
        foreach ($this->getRangedWeaponTypesByWeaponCode($weaponlikeCode) as $weaponType) {
            $rangeGroupPossibleActions = $this->mergeActionsFromSameGroup($weaponType, $rangeGroupPossibleActions);
        }
        $holdingGroupPossibleActions = [];
        foreach ($this->getHoldingWeaponTypesByWeaponCode($weaponlikeCode) as $weaponType) {
            $holdingGroupPossibleActions = $this->mergeActionsFromSameGroup($weaponType, $holdingGroupPossibleActions);
        }

        // only actions allowed for BOTH groups
        return array_intersect($rangeGroupPossibleActions, $holdingGroupPossibleActions);
    }

    private function mergeActionsFromSameGroup($weaponType, array $possibleActions)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $currentlyPossibleActions = array_keys(
            array_filter(
                $this->getRow($weaponType),
                function ($isAllowed) {
                    return $isAllowed;
                }
            )
        );
        foreach ($currentlyPossibleActions as $currentlyPossibleAction) {
            if (!in_array($currentlyPossibleAction, $possibleActions, true)) {
                $possibleActions[] = $currentlyPossibleAction;
            }
        }

        return $possibleActions;
    }

    /**
     * @param WeaponlikeCode $weaponlikeCode
     * @return array|string[]
     */
    private function getRangedWeaponTypesByWeaponCode(WeaponlikeCode $weaponlikeCode)
    {
        $types = [];
        if ($weaponlikeCode->isMelee()) {
            $types[] = self::MELEE;
        }
        if ($weaponlikeCode->isShootingWeapon()) {
            $types[] = self::SHOOTING;
        }
        if ($weaponlikeCode->isThrowingWeapon()) {
            $types[] = self::THROWING;
        }

        return $types;
    }

    /**
     * @param WeaponlikeCode $weaponlikeCode
     * @return array|string[]
     */
    private function getHoldingWeaponTypesByWeaponCode(WeaponlikeCode $weaponlikeCode)
    {
        $types = [];
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        if ($this->armourer->canHoldItByTwoHands($weaponlikeCode)) {
            $types[] = self::TWO_HANDED;
        }
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        if ($this->armourer->canHoldItByOneHand($weaponlikeCode)) {
            $types[] = self::ONE_HANDED;
        }

        return $types;
    }

}