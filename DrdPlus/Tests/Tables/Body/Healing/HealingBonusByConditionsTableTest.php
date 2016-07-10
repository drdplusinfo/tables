<?php
namespace DrdPlus\Tests\Tables\Body\Healing;

use DrdPlus\Codes\EnvironmentConditionsTypeCode;
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
            [0, -6, EnvironmentConditionsTypeCode::FOUL_CONDITIONS /* -6, -12 */],
            [100, -12, EnvironmentConditionsTypeCode::FOUL_CONDITIONS /* -6, -12 */],
            [33, -4, EnvironmentConditionsTypeCode::BAD_CONDITIONS /* -5, -3 */],
            [49, -1, EnvironmentConditionsTypeCode::IMPAIRED_CONDITIONS /* -2, -1 */],
            [50, -2, EnvironmentConditionsTypeCode::IMPAIRED_CONDITIONS /* -2, -1 */],
            [0, 0, EnvironmentConditionsTypeCode::GOOD_CONDITIONS],
            [100, 0, EnvironmentConditionsTypeCode::GOOD_CONDITIONS],
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
}