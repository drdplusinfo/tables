<?php
namespace DrdPlus\Tables\Armaments\Shields;

use DrdPlus\Codes\Armaments\ShieldCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tests\Tables\TableTestInterface;

class ShieldsTableTest extends \PHPUnit_Framework_TestCase implements TableTestInterface
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $shieldsTable = new ShieldsTable();
        self::assertSame(
            [['shield', 'required_strength', 'length', 'restriction', 'offensiveness', 'wounds', 'wounds_type', 'cover', 'weight', 'two_handed']],
            $shieldsTable->getHeader()
        );
    }

    /**
     * @test
     */
    public function I_can_get_all_values()
    {
        self::assertSame(
            $this->assembleIndexedValues($this->provideShieldAndValue()),
            (new ShieldsTable())->getIndexedValues()
        );
    }

    private function assembleIndexedValues(array $values)
    {
        $indexedValues = [];
        foreach ($values as $row) {
            list($shield, $parameterName, $parameterValue) = $row;
            if (!array_key_exists($shield, $indexedValues)) {
                $indexedValues[$shield] = [];
            }
            $indexedValues[$shield][$parameterName] = $parameterValue;
        }

        return $indexedValues;
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
            [ShieldCode::WITHOUT_SHIELD, ShieldsTable::REQUIRED_STRENGTH, false],
            [ShieldCode::WITHOUT_SHIELD, ShieldsTable::LENGTH, 0],
            [ShieldCode::WITHOUT_SHIELD, ShieldsTable::RESTRICTION, 0],
            [ShieldCode::WITHOUT_SHIELD, ShieldsTable::OFFENSIVENESS, false],
            [ShieldCode::WITHOUT_SHIELD, ShieldsTable::WOUNDS, false],
            [ShieldCode::WITHOUT_SHIELD, ShieldsTable::WOUNDS_TYPE, ''],
            // shield provides another cover per round, therefore without shield this fades
            [ShieldCode::WITHOUT_SHIELD, ShieldsTable::COVER, false],
            [ShieldCode::WITHOUT_SHIELD, ShieldsTable::WEIGHT, 0.0],
            [ShieldCode::WITHOUT_SHIELD, ShieldsTable::TWO_HANDED, false],

            [ShieldCode::BUCKLER, ShieldsTable::REQUIRED_STRENGTH, -3],
            [ShieldCode::BUCKLER, ShieldsTable::LENGTH, 0],
            [ShieldCode::BUCKLER, ShieldsTable::RESTRICTION, -1],
            [ShieldCode::BUCKLER, ShieldsTable::OFFENSIVENESS, 0],
            [ShieldCode::BUCKLER, ShieldsTable::WOUNDS, 0],
            [ShieldCode::BUCKLER, ShieldsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [ShieldCode::BUCKLER, ShieldsTable::COVER, 2],
            [ShieldCode::BUCKLER, ShieldsTable::WEIGHT, 0.8],
            [ShieldCode::BUCKLER, ShieldsTable::TWO_HANDED, false],

            [ShieldCode::SMALL_SHIELD, ShieldsTable::REQUIRED_STRENGTH, 1],
            [ShieldCode::SMALL_SHIELD, ShieldsTable::LENGTH, 0],
            [ShieldCode::SMALL_SHIELD, ShieldsTable::RESTRICTION, -2],
            [ShieldCode::SMALL_SHIELD, ShieldsTable::OFFENSIVENESS, 0],
            [ShieldCode::SMALL_SHIELD, ShieldsTable::WOUNDS, 1],
            [ShieldCode::SMALL_SHIELD, ShieldsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [ShieldCode::SMALL_SHIELD, ShieldsTable::COVER, 4],
            [ShieldCode::SMALL_SHIELD, ShieldsTable::WEIGHT, 1.5],
            [ShieldCode::SMALL_SHIELD, ShieldsTable::TWO_HANDED, false],

            [ShieldCode::MEDIUM_SHIELD, ShieldsTable::REQUIRED_STRENGTH, 5],
            [ShieldCode::MEDIUM_SHIELD, ShieldsTable::LENGTH, 0],
            [ShieldCode::MEDIUM_SHIELD, ShieldsTable::RESTRICTION, -3],
            [ShieldCode::MEDIUM_SHIELD, ShieldsTable::OFFENSIVENESS, 0],
            [ShieldCode::MEDIUM_SHIELD, ShieldsTable::WOUNDS, 2],
            [ShieldCode::MEDIUM_SHIELD, ShieldsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [ShieldCode::MEDIUM_SHIELD, ShieldsTable::COVER, 5],
            [ShieldCode::MEDIUM_SHIELD, ShieldsTable::WEIGHT, 2.5],
            [ShieldCode::MEDIUM_SHIELD, ShieldsTable::TWO_HANDED, false],

            [ShieldCode::HEAVY_SHIELD, ShieldsTable::REQUIRED_STRENGTH, 9],
            [ShieldCode::HEAVY_SHIELD, ShieldsTable::LENGTH, 0],
            [ShieldCode::HEAVY_SHIELD, ShieldsTable::RESTRICTION, -4],
            [ShieldCode::HEAVY_SHIELD, ShieldsTable::OFFENSIVENESS, 0],
            [ShieldCode::HEAVY_SHIELD, ShieldsTable::WOUNDS, 3],
            [ShieldCode::HEAVY_SHIELD, ShieldsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [ShieldCode::HEAVY_SHIELD, ShieldsTable::COVER, 6],
            [ShieldCode::HEAVY_SHIELD, ShieldsTable::WEIGHT, 4.0],
            [ShieldCode::HEAVY_SHIELD, ShieldsTable::TWO_HANDED, false],

            [ShieldCode::PAVISE, ShieldsTable::REQUIRED_STRENGTH, 13],
            [ShieldCode::PAVISE, ShieldsTable::LENGTH, 0],
            [ShieldCode::PAVISE, ShieldsTable::RESTRICTION, -5],
            [ShieldCode::PAVISE, ShieldsTable::OFFENSIVENESS, 0],
            [ShieldCode::PAVISE, ShieldsTable::WOUNDS, 4],
            [ShieldCode::PAVISE, ShieldsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [ShieldCode::PAVISE, ShieldsTable::COVER, 7],
            [ShieldCode::PAVISE, ShieldsTable::WEIGHT, 6.0],
            [ShieldCode::PAVISE, ShieldsTable::TWO_HANDED, false],
        ];
    }

    /**
     * @test
     * @dataProvider provideValueName
     * @param string $valueName
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownShield
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
            [ShieldsTable::REQUIRED_STRENGTH],
            [ShieldsTable::RESTRICTION],
            [ShieldsTable::OFFENSIVENESS],
            [ShieldsTable::WOUNDS],
            [ShieldsTable::WOUNDS_TYPE],
            [ShieldsTable::COVER],
            [ShieldsTable::WEIGHT],
            [ShieldsTable::TWO_HANDED, false],
        ];
    }

}
