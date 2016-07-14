<?php
namespace DrdPlus\Tests\Tables\Body\Healing;

use DrdPlus\Codes\EnvironmentConditionsCode;
use DrdPlus\Tables\Body\Healing\HealingByConditionsTable;
use DrdPlus\Tables\Body\Healing\HealingConditionsPercents;
use DrdPlus\Tests\Tables\TableTest;
use Granam\Tests\Tools\TestWithMockery;

class HealingByConditionsTableTest extends TestWithMockery implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $healingBonusForConditionsTable = new HealingByConditionsTable();
        self::assertSame(
            [['situation', 'bonus_from', 'bonus_to', 'can_be_more']],
            $healingBonusForConditionsTable->getHeader()
        );
    }

    /**
     * @test
     * @dataProvider provideBonusWithConditionsCode
     * @param int $conditionsPercents
     * @param int $expectedBonus
     * @param string $conditionsCode
     */
    public function I_can_get_bonus_for_every_conditions($conditionsPercents, $expectedBonus, $conditionsCode)
    {
        $healingBonusForConditionsTable = new HealingByConditionsTable();
        self::assertSame(
            $expectedBonus,
            $healingBonusForConditionsTable->getHealingBonusByConditions(
                $conditionsCode,
                $this->createHealingConditionsPercents($conditionsPercents)
            )
        );
    }

    public function provideBonusWithConditionsCode()
    {
        return [
            [0, -6, EnvironmentConditionsCode::FOUL_CONDITIONS /* -6, -12 */],
            [100, -12, EnvironmentConditionsCode::FOUL_CONDITIONS /* -6, -12 */],
            [180, -17, EnvironmentConditionsCode::FOUL_CONDITIONS /* -6, -12 */],
            [33, -4, EnvironmentConditionsCode::BAD_CONDITIONS /* -5, -3 */],
            [49, -1, EnvironmentConditionsCode::IMPAIRED_CONDITIONS /* -2, -1 */],
            [50, -2, EnvironmentConditionsCode::IMPAIRED_CONDITIONS /* -2, -1 */],
            [0, 0, EnvironmentConditionsCode::GOOD_CONDITIONS],
            [100, 0, EnvironmentConditionsCode::GOOD_CONDITIONS],
        ];
    }

    /**
     * @param int $percents
     * @return \Mockery\MockInterface|HealingConditionsPercents
     */
    private function createHealingConditionsPercents($percents)
    {
        $healingConditionsPercents = $this->mockery(HealingConditionsPercents::class);
        $healingConditionsPercents->shouldReceive('getValue')
            ->andReturn($percents);
        $healingConditionsPercents->shouldReceive('getRate')
            ->andReturn($percents / 100);

        return $healingConditionsPercents;
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Body\Healing\Exceptions\UnexpectedHealingConditionsPercents
     * @expectedExceptionMessageRegExp ~101~
     */
    public function I_can_not_get_higher_bonus_than_hundred_percents_if_conditions_do_not_allow_it()
    {
        (new HealingByConditionsTable())->getHealingBonusByConditions(
            EnvironmentConditionsCode::IMPAIRED_CONDITIONS,
            new HealingConditionsPercents(101)
        );
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Body\Healing\Exceptions\UnknownCodeOfHealingInfluence
     * @expectedExceptionMessageRegExp ~frozen~
     */
    public function I_can_not_get_bonus_for_unknown_condition()
    {
        (new HealingByConditionsTable())->getHealingBonusByConditions('frozen', $this->createHealingConditionsPercents(0));
    }
}