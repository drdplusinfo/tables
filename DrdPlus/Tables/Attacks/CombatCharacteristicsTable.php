<?php
namespace DrdPlus\Tables\Attacks;

use DrdPlus\Codes\CombatCharacteristicCode;
use DrdPlus\Codes\PropertyCode;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Combat\Attack;
use DrdPlus\Properties\Combat\DefenseNumber;
use DrdPlus\Properties\Combat\Shooting;
use DrdPlus\Tables\Partials\AbstractTable;

/**
 * See PPH page 34 left column, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_bojovych_charakteristik
 */
class CombatCharacteristicsTable extends AbstractTable
{
    const CHARACTERISTIC = 'characteristic';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
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
    protected function getColumnsHeader()
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
    public function getIndexedValues()
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
        return new Attack($agility);
    }

    /**
     * As you can see DefenseNumber can be created safely directly, without this table.
     *
     * @param Agility $agility
     * @return DefenseNumber
     */
    public function getDefense(Agility $agility)
    {
        return new DefenseNumber($agility);
    }

    /**
     * As you can see Shooting can be created safely directly, without this table.
     *
     * @param Knack $knack
     * @return Shooting
     */
    public function getShooting(Knack $knack)
    {
        return new Shooting($knack);
    }

}