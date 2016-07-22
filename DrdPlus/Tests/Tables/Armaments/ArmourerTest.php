<?php
namespace DrdPlus\Tests\Tables\Armaments;

use DrdPlus\Codes\BodyArmorCode;
use DrdPlus\Codes\HelmCode;
use DrdPlus\Tables\Armaments\Armors\BodyArmorsTable;
use DrdPlus\Tables\Armaments\Armors\HelmsTable;
use DrdPlus\Tables\Armaments\Armourer;
use DrdPlus\Tables\Armaments\Sanctions\ArmorSanctionsTable;
use DrdPlus\Tables\Tables;
use Granam\Tests\Tools\TestWithMockery;

class ArmourerTest extends TestWithMockery
{
    /**
     * @test
     * @dataProvider provideArmorWithBodySizeAndStrength
     * @param int $requiredStrength
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
        $armourer = new Armourer($tables = $this->createTables());
        $tables->shouldReceive('getBodyArmorsTable')
            ->andReturn($bodyArmorsTable = $this->createBodyArmorsTable());
        $armorCode = 'foo';
        $bodyArmorsTable->shouldReceive('getRequiredStrengthOf')
            ->with($armorCode)
            ->andReturn($requiredStrength);
        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForBodyArmor($this->createBodyArmorCode($armorCode), $bodySize, $strength)
        );
        $tables->shouldReceive('getArmorSanctionsTable')
            ->andReturn($armorSanctionsTable = $this->createArmorSanctionsTable());
        $armorSanctionsTable->shouldReceive('getSanctionsForMissingStrength')
            ->with($expectedMissingStrength)
            ->andReturn('bar');
        self::assertSame(
            'bar',
            $armourer->getSanctionValuesForBodyArmor($this->createBodyArmorCode($armorCode), $bodySize, $strength)
        );
    }

    public function provideArmorWithBodySizeAndStrength()
    {
        return [
            [123, 11, 65, 69],
            [0, 33, 88, 0], // no required strength results into zero missing strength
        ];
    }

    /**
     * @return \Mockery\MockInterface|Tables
     */
    private function createTables()
    {
        return $this->mockery(Tables::class);
    }

    /**
     * @param string $value
     * @return \Mockery\MockInterface|BodyArmorCode
     */
    private function createBodyArmorCode($value)
    {
        $bodyArmorCode = $this->mockery(BodyArmorCode::class);
        $bodyArmorCode->shouldReceive('getValue')
            ->andReturn($value);

        return $bodyArmorCode;
    }

    /**
     * @return \Mockery\MockInterface|BodyArmorsTable
     */
    private function createBodyArmorsTable()
    {
        return $this->mockery(BodyArmorsTable::class);
    }

    /**
     * @return \Mockery\MockInterface|ArmorSanctionsTable
     */
    private function createArmorSanctionsTable()
    {
        return $this->mockery(ArmorSanctionsTable::class);
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
        $armourer = new Armourer($tables = $this->createTables());
        $tables->shouldReceive('getHelmsTable')
            ->andReturn($helmsTable = $this->createHelmsTable());
        $armorCode = 'foo';
        $helmsTable->shouldReceive('getRequiredStrengthOf')
            ->with($armorCode)
            ->andReturn($requiredStrength);
        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForHelm($this->createHelmCode($armorCode), $bodySize, $strength)
        );
        $tables->shouldReceive('getArmorSanctionsTable')
            ->andReturn($armorSanctionsTable = $this->createArmorSanctionsTable());
        $armorSanctionsTable->shouldReceive('getSanctionsForMissingStrength')
            ->with($expectedMissingStrength)
            ->andReturn('bar');
        self::assertSame(
            'bar',
            $armourer->getSanctionValuesForHelm($this->createHelmCode($armorCode), $bodySize, $strength)
        );
    }

    /**
     * @param $value
     * @return \Mockery\MockInterface|HelmCode
     */
    private function createHelmCode($value)
    {
        $helmCode = $this->mockery(HelmCode::class);
        $helmCode->shouldReceive('getValue')
            ->andReturn($value);

        return $helmCode;
    }

}
