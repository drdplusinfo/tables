<?php
namespace DrdPlus\Tables\Combat;

use DrdPlus\Codes\CombatCharacteristicCode;
use DrdPlus\Codes\Properties\PropertyCode;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Combat\Attack;
use DrdPlus\Properties\Combat\Defense;
use DrdPlus\Properties\Combat\Shooting;
use DrdPlus\Tables\Partials\AbstractTable;

/**
 * See PPH page 34 left column, @link https://pph.drdplus.info/#tabulka_bojovych_charakteristik
 */
class CombatCharacteristicsTable extends AbstractTable
{
    const CHARACTERISTIC = 'characteristic';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader(): array
    {
        return [self::CHARACTERISTIC];
    }

    const PROPERTY = 'property';
    const DIVIDE_BY = 'divide_by';
    const ROUND_UP = 'round_up';
    const ROUND_DOWN = 'round_down';

    /**
     * @return array|string[]
     */
    protected function getColumnsHeader(): array
    {
        return [
            self::PROPERTY,
            self::DIVIDE_BY,
            self::ROUND_UP,
            self::ROUND_DOWN,
        ];
    }

    /**
     * @return array|string[][]
     */
    public function getIndexedValues(): array
    {
        return [
            CombatCharacteristicCode::ATTACK => [self::PROPERTY => PropertyCode::AGILITY, self::DIVIDE_BY => 2, self::ROUND_UP => false, self::ROUND_DOWN => true],
            CombatCharacteristicCode::DEFENSE => [self::PROPERTY => PropertyCode::AGILITY, self::DIVIDE_BY => 2, self::ROUND_UP => true, self::ROUND_DOWN => false],
            CombatCharacteristicCode::SHOOTING => [self::PROPERTY => PropertyCode::KNACK, self::DIVIDE_BY => 2, self::ROUND_UP => false, self::ROUND_DOWN => true],
        ];
    }

    /**
     * As you can see Attack can be created safely directly, without this table.
     *
     * @param Agility $agility
     * @return Attack
     */
    public function getAttack(Agility $agility)
    {
        return Attack::getIt($agility);
    }

    /**
     * As you can see Defense can be created safely directly, without this table.
     *
     * @param Agility $agility
     * @return Defense
     */
    public function getDefense(Agility $agility)
    {
        return Defense::getIt($agility);
    }

    /**
     * As you can see Shooting can be created safely directly, without this table.
     *
     * @param Knack $knack
     * @return Shooting
     */
    public function getShooting(Knack $knack)
    {
        return Shooting::getIt($knack);
    }

}