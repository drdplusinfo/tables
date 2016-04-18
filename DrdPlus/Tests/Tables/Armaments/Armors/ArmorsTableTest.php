<?php
namespace DrdPlus\Tables\Armaments\Armors;

use DrdPlus\Codes\ArmorCodes;
use DrdPlus\Tests\Tables\TableTest;

class ArmorsTableTest extends \PHPUnit_Framework_TestCase implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $armorsTable = new ArmorsTable();
        self::assertSame(
            [['armor', 'required_strength', 'restriction', 'protection', 'weight']],
            $armorsTable->getHeader()
        );
    }

    /**
     * @test
     * @dataProvider provideArmorAndValue
     * @param string $armorCode
     * @param string $valueName
     * @param mixed $expectedValue
     */
    public function I_can_get_values_for_every_armor($armorCode, $valueName, $expectedValue)
    {
        $armorsTable = new ArmorsTable();
        $value = $armorsTable->getValue([$armorCode], $valueName);
        self::assertSame($expectedValue, $value);
        $getValueNameOf = 'get' . implode(array_map(
                function ($namePart) {
                    return ucfirst($namePart);
                },
                explode('_', $valueName)
            )) . 'Of';
        self::assertSame($value, $armorsTable->$getValueNameOf($armorCode));
    }

    public function provideArmorAndValue()
    {
        return [
            [ArmorCodes::WITHOUT_ARMOR, ArmorsTable::REQUIRED_STRENGTH_HEADER, false],
            [ArmorCodes::WITHOUT_ARMOR, ArmorsTable::RESTRICTION_HEADER, false],
            [ArmorCodes::WITHOUT_ARMOR, ArmorsTable::PROTECTION_HEADER, 0],
            [ArmorCodes::WITHOUT_ARMOR, ArmorsTable::WEIGHT_HEADER, false],

            [ArmorCodes::PADDED_ARMOR, ArmorsTable::REQUIRED_STRENGTH_HEADER, -2],
            [ArmorCodes::PADDED_ARMOR, ArmorsTable::RESTRICTION_HEADER, false],
            [ArmorCodes::PADDED_ARMOR, ArmorsTable::PROTECTION_HEADER, 2],
            [ArmorCodes::PADDED_ARMOR, ArmorsTable::WEIGHT_HEADER, 4.0],

            [ArmorCodes::LEATHER_ARMOR, ArmorsTable::REQUIRED_STRENGTH_HEADER, 1],
            [ArmorCodes::LEATHER_ARMOR, ArmorsTable::RESTRICTION_HEADER, false],
            [ArmorCodes::LEATHER_ARMOR, ArmorsTable::PROTECTION_HEADER, 3],
            [ArmorCodes::LEATHER_ARMOR, ArmorsTable::WEIGHT_HEADER, 6.0],

            [ArmorCodes::HOBNAILED_ARMOR, ArmorsTable::REQUIRED_STRENGTH_HEADER, 3],
            [ArmorCodes::HOBNAILED_ARMOR, ArmorsTable::RESTRICTION_HEADER, false],
            [ArmorCodes::HOBNAILED_ARMOR, ArmorsTable::PROTECTION_HEADER, 4],
            [ArmorCodes::HOBNAILED_ARMOR, ArmorsTable::WEIGHT_HEADER, 8.0],

            [ArmorCodes::CHAINMAIL, ArmorsTable::REQUIRED_STRENGTH_HEADER, 5],
            [ArmorCodes::CHAINMAIL, ArmorsTable::RESTRICTION_HEADER, -1],
            [ArmorCodes::CHAINMAIL, ArmorsTable::PROTECTION_HEADER, 6],
            [ArmorCodes::CHAINMAIL, ArmorsTable::WEIGHT_HEADER, 15.0],

            [ArmorCodes::SCALE_ARMOR, ArmorsTable::REQUIRED_STRENGTH_HEADER, 7],
            [ArmorCodes::SCALE_ARMOR, ArmorsTable::RESTRICTION_HEADER, -2],
            [ArmorCodes::SCALE_ARMOR, ArmorsTable::PROTECTION_HEADER, 7],
            [ArmorCodes::SCALE_ARMOR, ArmorsTable::WEIGHT_HEADER, 20.0],

            [ArmorCodes::PLATE_ARMOR, ArmorsTable::REQUIRED_STRENGTH_HEADER, 10],
            [ArmorCodes::PLATE_ARMOR, ArmorsTable::RESTRICTION_HEADER, -3],
            [ArmorCodes::PLATE_ARMOR, ArmorsTable::PROTECTION_HEADER, 9],
            [ArmorCodes::PLATE_ARMOR, ArmorsTable::WEIGHT_HEADER, 30.0],

            [ArmorCodes::FULL_PLATE_ARMOR, ArmorsTable::REQUIRED_STRENGTH_HEADER, 12],
            [ArmorCodes::FULL_PLATE_ARMOR, ArmorsTable::RESTRICTION_HEADER, -4],
            [ArmorCodes::FULL_PLATE_ARMOR, ArmorsTable::PROTECTION_HEADER, 10],
            [ArmorCodes::FULL_PLATE_ARMOR, ArmorsTable::WEIGHT_HEADER, 35.0],
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Armors\Exceptions\UnknownArmorCode
     */
    public function I_can_not_get_value_for_unknown_armor()
    {
        $armorsTable = new ArmorsTable();
        $armorsTable->getProtectionOf('skeleton armor of never-life');
    }

}
