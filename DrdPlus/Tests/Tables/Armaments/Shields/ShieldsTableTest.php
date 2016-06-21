<?php
namespace DrdPlus\Tables\Armaments\Shields;

use DrdPlus\Codes\ShieldCode;
use DrdPlus\Codes\WoundTypeCode;
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
        $getValueNameOf = $this->assembleValueGetter($valueName);
        self::assertSame($value, $shieldsTable->$getValueNameOf($shieldCode));
    }

    private function assembleValueGetter($valueName)
    {
        return 'get' . implode(
            array_map(
                function ($namePart) {
                    return ucfirst($namePart);
                },
                explode('_', $valueName)
            )
        ) . 'Of';
    }

    public function provideShieldAndValue()
    {
        return [
            [ShieldCode::BUCKLER, ShieldsTable::REQUIRED_STRENGTH_HEADER, -3],
            [ShieldCode::BUCKLER, ShieldsTable::RESTRICTION_HEADER, -1],
            [ShieldCode::BUCKLER, ShieldsTable::OFFENSIVENESS_HEADER, 0],
            [ShieldCode::BUCKLER, ShieldsTable::WOUNDS_HEADER, 0],
            [ShieldCode::BUCKLER, ShieldsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [ShieldCode::BUCKLER, ShieldsTable::COVER_HEADER, 2],
            [ShieldCode::BUCKLER, ShieldsTable::WEIGHT_HEADER, 0.8],

            [ShieldCode::SMALL_SHIELD, ShieldsTable::REQUIRED_STRENGTH_HEADER, 1],
            [ShieldCode::SMALL_SHIELD, ShieldsTable::RESTRICTION_HEADER, -2],
            [ShieldCode::SMALL_SHIELD, ShieldsTable::OFFENSIVENESS_HEADER, 0],
            [ShieldCode::SMALL_SHIELD, ShieldsTable::WOUNDS_HEADER, 1],
            [ShieldCode::SMALL_SHIELD, ShieldsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [ShieldCode::SMALL_SHIELD, ShieldsTable::COVER_HEADER, 4],
            [ShieldCode::SMALL_SHIELD, ShieldsTable::WEIGHT_HEADER, 1.5],

            [ShieldCode::MEDIUM_SHIELD, ShieldsTable::REQUIRED_STRENGTH_HEADER, 5],
            [ShieldCode::MEDIUM_SHIELD, ShieldsTable::RESTRICTION_HEADER, -3],
            [ShieldCode::MEDIUM_SHIELD, ShieldsTable::OFFENSIVENESS_HEADER, 0],
            [ShieldCode::MEDIUM_SHIELD, ShieldsTable::WOUNDS_HEADER, 2],
            [ShieldCode::MEDIUM_SHIELD, ShieldsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [ShieldCode::MEDIUM_SHIELD, ShieldsTable::COVER_HEADER, 5],
            [ShieldCode::MEDIUM_SHIELD, ShieldsTable::WEIGHT_HEADER, 2.5],

            [ShieldCode::HEAVY_SHIELD, ShieldsTable::REQUIRED_STRENGTH_HEADER, 9],
            [ShieldCode::HEAVY_SHIELD, ShieldsTable::RESTRICTION_HEADER, -4],
            [ShieldCode::HEAVY_SHIELD, ShieldsTable::OFFENSIVENESS_HEADER, 0],
            [ShieldCode::HEAVY_SHIELD, ShieldsTable::WOUNDS_HEADER, 3],
            [ShieldCode::HEAVY_SHIELD, ShieldsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [ShieldCode::HEAVY_SHIELD, ShieldsTable::COVER_HEADER, 6],
            [ShieldCode::HEAVY_SHIELD, ShieldsTable::WEIGHT_HEADER, 4.0],

            [ShieldCode::PAVISE, ShieldsTable::REQUIRED_STRENGTH_HEADER, 13],
            [ShieldCode::PAVISE, ShieldsTable::RESTRICTION_HEADER, -5],
            [ShieldCode::PAVISE, ShieldsTable::OFFENSIVENESS_HEADER, 0],
            [ShieldCode::PAVISE, ShieldsTable::WOUNDS_HEADER, 4],
            [ShieldCode::PAVISE, ShieldsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [ShieldCode::PAVISE, ShieldsTable::COVER_HEADER, 7],
            [ShieldCode::PAVISE, ShieldsTable::WEIGHT_HEADER, 6.0],
        ];
    }

    /**
     * @test
     * @dataProvider provideValueName
     * @param string $valueName
     * @expectedException \DrdPlus\Tables\Armaments\Shields\Exceptions\UnknownShieldCode
     * @expectedExceptionMessageRegExp ~protector_of_masses~
     */
    public function I_can_not_get_value_of_unknown_shield($valueName)
    {
        $getValueNameOf = $this->assembleValueGetter($valueName);
        (new ShieldsTable())->$getValueNameOf('protector_of_masses');
    }

    public function provideValueName()
    {
        return [
            [ShieldsTable::REQUIRED_STRENGTH_HEADER],
            [ShieldsTable::RESTRICTION_HEADER],
            [ShieldsTable::OFFENSIVENESS_HEADER],
            [ShieldsTable::WOUNDS_HEADER],
            [ShieldsTable::WOUNDS_TYPE_HEADER],
            [ShieldsTable::COVER_HEADER],
            [ShieldsTable::WEIGHT_HEADER],
        ];
    }

}
