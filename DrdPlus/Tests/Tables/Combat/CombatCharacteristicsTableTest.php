<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tests\Tables\Combat;

use DrdPlus\Codes\CombatCharacteristicCode;
use DrdPlus\Codes\Properties\PropertyCode;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Combat\Attack;
use DrdPlus\Properties\Combat\Defense;
use DrdPlus\Properties\Combat\Shooting;
use DrdPlus\Tables\Combat\CombatCharacteristicsTable;
use DrdPlus\Tests\Tables\TableTest;

class CombatCharacteristicsTableTest extends TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame(
            [['characteristic', 'property', 'divide_by', 'round_up', 'round_down']],
            (new CombatCharacteristicsTable())->getHeader()
        );
    }

    /**
     * @test
     */
    public function I_get_expected_attack_and_values()
    {
        $combatCharacteristicsTable = new CombatCharacteristicsTable();
        $agility = $this->createAgility(123);
        $attack = $combatCharacteristicsTable->getAttack($agility);
        self::assertInstanceOf(Attack::class, $attack);
        self::assertSame(Attack::getIt($agility)->getValue(), $attack->getValue());
        self::assertSame(
            ['property' => PropertyCode::AGILITY, 'divide_by' => 2, 'round_up' => false, 'round_down' => true],
            $combatCharacteristicsTable->getRow(CombatCharacteristicCode::ATTACK)
        );
    }

    /**
     * @param $value
     * @return Agility|\Mockery\MockInterface
     */
    private function createAgility($value)
    {
        $agility = $this->mockery(Agility::class);
        $agility->shouldReceive('getValue')
            ->andReturn($value);

        return $agility;
    }

    /**
     * @test
     */
    public function I_get_expected_defense_and_values()
    {
        $combatCharacteristicsTable = new CombatCharacteristicsTable();
        $agility = $this->createAgility(123);
        $defense = $combatCharacteristicsTable->getDefense($agility);
        self::assertInstanceOf(Defense::class, $defense);
        self::assertSame(Defense::getIt($agility)->getValue(), $defense->getValue());
        self::assertSame(
            ['property' => PropertyCode::AGILITY, 'divide_by' => 2, 'round_up' => true, 'round_down' => false],
            $combatCharacteristicsTable->getRow(CombatCharacteristicCode::DEFENSE)
        );
    }

    /**
     * @test
     */
    public function I_get_expected_shooting_and_values()
    {
        $combatCharacteristicsTable = new CombatCharacteristicsTable();
        $knack = $this->createKnack(123);
        $shooting = $combatCharacteristicsTable->getShooting($knack);
        self::assertInstanceOf(Shooting::class, $shooting);
        self::assertSame(Shooting::getIt($knack)->getValue(), $shooting->getValue());
        self::assertSame(
            ['property' => PropertyCode::KNACK, 'divide_by' => 2, 'round_up' => false, 'round_down' => true],
            $combatCharacteristicsTable->getRow(CombatCharacteristicCode::SHOOTING)
        );
    }

    /**
     * @param $value
     * @return Knack|\Mockery\MockInterface
     */
    private function createKnack($value)
    {
        $knack = $this->mockery(Knack::class);
        $knack->shouldReceive('getValue')
            ->andReturn($value);

        return $knack;
    }
}