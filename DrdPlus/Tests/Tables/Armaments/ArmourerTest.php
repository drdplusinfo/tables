<?php
namespace DrdPlus\Tests\Tables\Armaments;

use DrdPlus\Tables\Armaments\Armors\BodyArmorsTable;
use DrdPlus\Tables\Armaments\Armors\HelmsTable;
use DrdPlus\Tables\Armaments\Armourer;
use DrdPlus\Tables\Armaments\Sanctions\ArmorSanctionsTable;
use Granam\Tests\Tools\TestWithMockery;

class ArmourerTest extends TestWithMockery
{
    /**
     * @test
     * @dataProvider provideArmorWithBodySizeAndStrength
     * @param int|bool $requiredStrength
     * @param int $bodySize
     * @param int $strength
     * @param mixed $expectedMissingStrength
     */
    public function I_can_get_missing_strength_and_sanction_values_for_body_armor(
        $requiredStrength,
        $bodySize,
        $strength,
        $expectedMissingStrength
    )
    {
        $armourer = new Armourer(
            $armorSanctionsTable = $this->createArmorSanctionsTable(),
            $bodyArmorsTable = $this->createBodyArmorsTable(),
            $this->createHelmsTable()
        );
        $bodyArmorsTable->shouldReceive('getRequiredStrengthOf')
            ->with($armorCode = 'foo')
            ->andReturn($requiredStrength);

        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForBodyArmor($armorCode, $bodySize, $strength)
        );

        $armorSanctionsTable->shouldReceive('getSanctionValuesForMissingStrength')
            ->with($expectedMissingStrength)
            ->andReturn($sanctionValues = ['bar']);
        self::assertSame(
            $sanctionValues,
            $armourer->getSanctionValuesForBodyArmor($armorCode, $bodySize, $strength)
        );
    }

    public function provideArmorWithBodySizeAndStrength()
    {
        return [
            [123, 11, 65, 69],
            [false, 33, 88, 0], // no required strength results into zero missing strength
        ];
    }

    /**
     * @return \Mockery\MockInterface|ArmorSanctionsTable
     */
    private function createArmorSanctionsTable()
    {
        return $this->mockery(ArmorSanctionsTable::class);
    }

    /**
     * @return \Mockery\MockInterface|BodyArmorsTable
     */
    private function createBodyArmorsTable()
    {
        return $this->mockery(BodyArmorsTable::class);
    }

    /**
     * @return \Mockery\MockInterface|HelmsTable
     */
    private function createHelmsTable()
    {
        return $this->mockery(HelmsTable::class);
    }

    /**
     * @test
     * @dataProvider provideArmorWithBodySizeAndStrength
     * @param int|bool $requiredStrength
     * @param int $bodySize
     * @param int $strength
     * @param mixed $expectedMissingStrength
     */
    public function I_can_get_missing_strength_and_sanction_values_for_helmet(
        $requiredStrength,
        $bodySize,
        $strength,
        $expectedMissingStrength
    )
    {
        $armourer = new Armourer(
            $armorSanctionsTable = $this->createArmorSanctionsTable(),
            $this->createBodyArmorsTable(),
            $helmsTable = $this->createHelmsTable()
        );
        $helmsTable->shouldReceive('getRequiredStrengthOf')
            ->with($helmsCode = 'foo')
            ->andReturn($requiredStrength);

        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForHelm($helmsCode, $bodySize, $strength)
        );

        $armorSanctionsTable->shouldReceive('getSanctionValuesForMissingStrength')
            ->with($expectedMissingStrength)
            ->andReturn($sanctionValues = ['bar']);
        self::assertSame(
            $sanctionValues,
            $armourer->getSanctionValuesForHelm($helmsCode, $bodySize, $strength)
        );
    }

}
