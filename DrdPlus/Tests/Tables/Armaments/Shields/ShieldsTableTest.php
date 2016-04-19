<?php
namespace DrdPlus\Tables\Armaments\Shields;

use DrdPlus\Codes\ShieldCodes;
use DrdPlus\Codes\WoundTypeCodes;
use DrdPlus\Tests\Tables\TableTest;

class ShieldsTableTest extends \PHPUnit_Framework_TestCase implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $shieldsTable = new ShieldsTable();
        self::assertSame(
            [['shield', 'required_strength', 'restriction', 'offensiveness', 'wounds', 'wounds_type', 'cover', 'weight']],
            $shieldsTable->getHeader()
        );
    }

    /**
     * @test
     * @dataProvider provideShieldAndValue
     * @param string $shieldCode
     * @param string $valueName
     * @param mixed $expectedValue
     */
    public function I_can_get_values_for_every_armor($shieldCode, $valueName, $expectedValue)
    {
        $shieldsTable = new ShieldsTable();
        $value = $shieldsTable->getValue([$shieldCode], $valueName);
        self::assertSame($expectedValue, $value);
        $getValueNameOf = 'get' . implode(array_map(
                function ($namePart) {
                    return ucfirst($namePart);
                },
                explode('_', $valueName)
            )) . 'Of';
        self::assertSame($value, $shieldsTable->$getValueNameOf($shieldCode));
    }

    public function provideShieldAndValue()
    {
        return [
            [ShieldCodes::BUCKLER, ShieldsTable::REQUIRED_STRENGTH_HEADER, -3],
            [ShieldCodes::BUCKLER, ShieldsTable::RESTRICTION_HEADER, -1],
            [ShieldCodes::BUCKLER, ShieldsTable::OFFENSIVENESS_HEADER, 0],
            [ShieldCodes::BUCKLER, ShieldsTable::WOUNDS_HEADER, 0],
            [ShieldCodes::BUCKLER, ShieldsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [ShieldCodes::BUCKLER, ShieldsTable::COVER_HEADER, 2],
            [ShieldCodes::BUCKLER, ShieldsTable::WEIGHT_HEADER, 0.8],

            [ShieldCodes::SMALL_SHIELD, ShieldsTable::REQUIRED_STRENGTH_HEADER, 1],
            [ShieldCodes::SMALL_SHIELD, ShieldsTable::RESTRICTION_HEADER, -2],
            [ShieldCodes::SMALL_SHIELD, ShieldsTable::OFFENSIVENESS_HEADER, 0],
            [ShieldCodes::SMALL_SHIELD, ShieldsTable::WOUNDS_HEADER, 1],
            [ShieldCodes::SMALL_SHIELD, ShieldsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [ShieldCodes::SMALL_SHIELD, ShieldsTable::COVER_HEADER, 4],
            [ShieldCodes::SMALL_SHIELD, ShieldsTable::WEIGHT_HEADER, 1.5],

            [ShieldCodes::MEDIUM_SHIELD, ShieldsTable::REQUIRED_STRENGTH_HEADER, 5],
            [ShieldCodes::MEDIUM_SHIELD, ShieldsTable::RESTRICTION_HEADER, -3],
            [ShieldCodes::MEDIUM_SHIELD, ShieldsTable::OFFENSIVENESS_HEADER, 0],
            [ShieldCodes::MEDIUM_SHIELD, ShieldsTable::WOUNDS_HEADER, 2],
            [ShieldCodes::MEDIUM_SHIELD, ShieldsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [ShieldCodes::MEDIUM_SHIELD, ShieldsTable::COVER_HEADER, 5],
            [ShieldCodes::MEDIUM_SHIELD, ShieldsTable::WEIGHT_HEADER, 2.5],

            [ShieldCodes::HEAVY_SHIELD, ShieldsTable::REQUIRED_STRENGTH_HEADER, 9],
            [ShieldCodes::HEAVY_SHIELD, ShieldsTable::RESTRICTION_HEADER, -4],
            [ShieldCodes::HEAVY_SHIELD, ShieldsTable::OFFENSIVENESS_HEADER, 0],
            [ShieldCodes::HEAVY_SHIELD, ShieldsTable::WOUNDS_HEADER, 3],
            [ShieldCodes::HEAVY_SHIELD, ShieldsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [ShieldCodes::HEAVY_SHIELD, ShieldsTable::COVER_HEADER, 6],
            [ShieldCodes::HEAVY_SHIELD, ShieldsTable::WEIGHT_HEADER, 4.0],

            [ShieldCodes::PAVISE, ShieldsTable::REQUIRED_STRENGTH_HEADER, 13],
            [ShieldCodes::PAVISE, ShieldsTable::RESTRICTION_HEADER, -5],
            [ShieldCodes::PAVISE, ShieldsTable::OFFENSIVENESS_HEADER, 0],
            [ShieldCodes::PAVISE, ShieldsTable::WOUNDS_HEADER, 4],
            [ShieldCodes::PAVISE, ShieldsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [ShieldCodes::PAVISE, ShieldsTable::COVER_HEADER, 7],
            [ShieldCodes::PAVISE, ShieldsTable::WEIGHT_HEADER, 6.0],
        ];
    }

}
