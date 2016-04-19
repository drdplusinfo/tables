<?php
namespace DrdPlus\Tables\Armaments\Shields;

use DrdPlus\Codes\ShieldCodes;
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
            [ShieldCodes::BUCKLER, ShieldsTable::WOUNDS_TYPE_HEADER, 'crush'],
            [ShieldCodes::BUCKLER, ShieldsTable::COVER_HEADER, 2],
            [ShieldCodes::BUCKLER, ShieldsTable::WEIGHT_HEADER, 0.8],
        ];
    }

}
