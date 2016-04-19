<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCodes;
use DrdPlus\Codes\WoundTypeCodes;
use DrdPlus\Tables\Armaments\Weapons\Melee\AxesTable;
use DrdPlus\Tests\Tables\TableTest;

class AxesTableTest extends \PHPUnit_Framework_TestCase implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $axesTable = new AxesTable();
        self::assertSame(
            [['weapon', 'required_strength', 'length', 'offensiveness', 'wounds', 'wounds_type', 'cover', 'weight']],
            $axesTable->getHeader()
        );
    }

    /**
     * @test
     * @dataProvider provideAxeAndValue
     * @param string $axeCode
     * @param string $valueName
     * @param mixed $expectedValue
     */
    public function I_can_get_values_for_every_axe($axeCode, $valueName, $expectedValue)
    {
        $axesTable = new AxesTable();
        $value = $axesTable->getValue([$axeCode], $valueName);
        self::assertSame($expectedValue, $value);
        $getValueNameOf = 'get' . implode(array_map(
                function ($namePart) {
                    return ucfirst($namePart);
                },
                explode('_', $valueName)
            )) . 'Of';
        self::assertSame($value, $axesTable->$getValueNameOf($axeCode));
    }

    public function provideAxeAndValue()
    {
        return [
            [WeaponCodes::LIGHT_AXE, AxesTable::REQUIRED_STRENGTH_HEADER, 3],
            [WeaponCodes::LIGHT_AXE, AxesTable::LENGTH_HEADER, 1],
            [WeaponCodes::LIGHT_AXE, AxesTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::LIGHT_AXE, AxesTable::WOUNDS_HEADER, 3],
            [WeaponCodes::LIGHT_AXE, AxesTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::LIGHT_AXE, AxesTable::COVER_HEADER, 2],
            [WeaponCodes::LIGHT_AXE, AxesTable::WEIGHT_HEADER, 1.0],

            [WeaponCodes::AXE, AxesTable::REQUIRED_STRENGTH_HEADER, 6],
            [WeaponCodes::AXE, AxesTable::LENGTH_HEADER, 2],
            [WeaponCodes::AXE, AxesTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::AXE, AxesTable::WOUNDS_HEADER, 5],
            [WeaponCodes::AXE, AxesTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::AXE, AxesTable::COVER_HEADER, 2],
            [WeaponCodes::AXE, AxesTable::WEIGHT_HEADER, 2.0],

            [WeaponCodes::WAR_AXE, AxesTable::REQUIRED_STRENGTH_HEADER, 9],
            [WeaponCodes::WAR_AXE, AxesTable::LENGTH_HEADER, 3],
            [WeaponCodes::WAR_AXE, AxesTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::WAR_AXE, AxesTable::WOUNDS_HEADER, 7],
            [WeaponCodes::WAR_AXE, AxesTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::WAR_AXE, AxesTable::COVER_HEADER, 3],
            [WeaponCodes::WAR_AXE, AxesTable::WEIGHT_HEADER, 2.5],

            [WeaponCodes::TWO_HANDED_AXE, AxesTable::REQUIRED_STRENGTH_HEADER, 12],
            [WeaponCodes::TWO_HANDED_AXE, AxesTable::LENGTH_HEADER, 3],
            [WeaponCodes::TWO_HANDED_AXE, AxesTable::OFFENSIVENESS_HEADER, 4],
            [WeaponCodes::TWO_HANDED_AXE, AxesTable::WOUNDS_HEADER, 10],
            [WeaponCodes::TWO_HANDED_AXE, AxesTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::TWO_HANDED_AXE, AxesTable::COVER_HEADER, 3],
            [WeaponCodes::TWO_HANDED_AXE, AxesTable::WEIGHT_HEADER, 3.0],
        ];
    }

}