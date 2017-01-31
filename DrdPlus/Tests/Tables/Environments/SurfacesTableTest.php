<?php
namespace DrdPlus\Tests\Tables\Environments;

use DrdPlus\Codes\Environment\LandingSurfaceCode;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Tables\Environments\SurfacesTable;
use DrdPlus\Tests\Tables\TableTest;
use Granam\Integer\PositiveIntegerObject;

class SurfacesTableTest extends TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame(
            [['surface', 'power_of_wound_modifier', 'agility_multiplier_protection', 'armor_max_protection']],
            (new SurfacesTable())->getHeader()
        );
    }

    /**
     * @test
     * @dataProvider provideValuesToGetPowerOfWoundModifier
     * @param int $landingSurfaceValue
     * @param int $agilityValue
     * @param int $armorProtectionValue
     * @param int $expectedPowerOfWoundModifier
     */
    public function I_can_get_power_of_wound_modifier(
        $landingSurfaceValue,
        $agilityValue,
        $armorProtectionValue,
        $expectedPowerOfWoundModifier
    )
    {
        self::assertSame(
            $expectedPowerOfWoundModifier,
            (new SurfacesTable())->getPowerOfWoundModifier(
                LandingSurfaceCode::getIt($landingSurfaceValue),
                Agility::getIt($agilityValue),
                new PositiveIntegerObject($armorProtectionValue)
            )
        );
    }

    public function provideValuesToGetPowerOfWoundModifier()
    {
        return [
            [LandingSurfaceCode::DEEP_POWDER, 9999, 888888, -15],
            [LandingSurfaceCode::WATER, 0, 987654321, -15],
            [LandingSurfaceCode::WATER, -5, 987654321, 0],
            [LandingSurfaceCode::WATER, 8, 987654321, -39],
            [LandingSurfaceCode::SHARP_ROCKS_OR_POINTED_PALES, 99999, 0, 15],
            [LandingSurfaceCode::SHARP_ROCKS_OR_POINTED_PALES, 99999, 8, 7],
            [LandingSurfaceCode::SHARP_ROCKS_OR_POINTED_PALES, 99999, 876543, 7],
        ];
    }

}