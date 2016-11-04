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

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [self::ATTACK_WITH_WEAPON_TYPE];
    }

    /**
     * Gives a list of all possible actions with given weapon.
     * Note about SPEAR: that weapon can be used both for melee as well as ranged combat (throwing) - for this weapon
     * you will get merged pool of both melee and ranged actions.
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @return array|string[]
     */
    public function getActionsPossibleWhenFightingWith(WeaponlikeCode $weaponlikeCode)
    {
        $possibleActions = [];
        foreach ($this->getWeaponTypesByWeaponCode($weaponlikeCode) as $weaponType) {
            $possibleActions = array_unique(
                array_merge($possibleActions, $this->getActionsPossibleWithType($weaponType))
            );
        }

        return $possibleActions;
    }

    private function getActionsPossibleWithType($weaponType)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return array_keys(
            array_filter(
                $this->getRow($weaponType),
                function ($isAllowed) {
                    return $isAllowed; // directly uses value given by table source
                }
            )
        );
    }

    const MELEE = 'melee';
    const SHOOTING = 'shooting';
    const THROWING = 'throwing';

    /**
     * @param WeaponlikeCode $weaponlikeCode
     * @return array|string[]
     */
    private function getWeaponTypesByWeaponCode(WeaponlikeCode $weaponlikeCode)
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

}