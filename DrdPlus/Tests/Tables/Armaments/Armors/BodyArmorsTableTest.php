<?php
namespace DrdPlus\Tests\Tables\Armaments\Armors;

use DrdPlus\Codes\Armaments\BodyArmorCode;
use DrdPlus\Tables\Armaments\Armors\BodyArmorsTable;
use DrdPlus\Tools\Calculations\SumAndRound;

class BodyArmorsTableTest extends AbstractArmorsTableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $armorsTable = new BodyArmorsTable();
        self::assertSame(
            [[$this->getRowHeaderName(), 'required_strength', 'restriction', 'protection', 'weight', 'rounds_to_put_on']],
            $armorsTable->getHeader()
        );
    }

    public function provideArmorAndValue()
    {
        return [
            [BodyArmorCode::WITHOUT_ARMOR, BodyArmorsTable::REQUIRED_STRENGTH, false],
            [BodyArmorCode::WITHOUT_ARMOR, BodyArmorsTable::RESTRICTION, false],
            [BodyArmorCode::WITHOUT_ARMOR, BodyArmorsTable::PROTECTION, 0],
            [BodyArmorCode::WITHOUT_ARMOR, BodyArmorsTable::WEIGHT, false],
            [BodyArmorCode::WITHOUT_ARMOR, BodyArmorsTable::ROUNDS_TO_PUT_ON, false],

            [BodyArmorCode::PADDED_ARMOR, BodyArmorsTable::REQUIRED_STRENGTH, -2],
            [BodyArmorCode::PADDED_ARMOR, BodyArmorsTable::RESTRICTION, false],
            [BodyArmorCode::PADDED_ARMOR, BodyArmorsTable::PROTECTION, 2],
            [BodyArmorCode::PADDED_ARMOR, BodyArmorsTable::WEIGHT, 4.0],
            [BodyArmorCode::PADDED_ARMOR, BodyArmorsTable::ROUNDS_TO_PUT_ON, 1],

            [BodyArmorCode::LEATHER_ARMOR, BodyArmorsTable::REQUIRED_STRENGTH, 1],
            [BodyArmorCode::LEATHER_ARMOR, BodyArmorsTable::RESTRICTION, false],
            [BodyArmorCode::LEATHER_ARMOR, BodyArmorsTable::PROTECTION, 3],
            [BodyArmorCode::LEATHER_ARMOR, BodyArmorsTable::WEIGHT, 6.0],
            [BodyArmorCode::LEATHER_ARMOR, BodyArmorsTable::ROUNDS_TO_PUT_ON, 1],

            [BodyArmorCode::HOBNAILED_ARMOR, BodyArmorsTable::REQUIRED_STRENGTH, 3],
            [BodyArmorCode::HOBNAILED_ARMOR, BodyArmorsTable::RESTRICTION, false],
            [BodyArmorCode::HOBNAILED_ARMOR, BodyArmorsTable::PROTECTION, 4],
            [BodyArmorCode::HOBNAILED_ARMOR, BodyArmorsTable::WEIGHT, 8.0],
            [BodyArmorCode::HOBNAILED_ARMOR, BodyArmorsTable::ROUNDS_TO_PUT_ON, 2],

            [BodyArmorCode::CHAINMAIL_ARMOR, BodyArmorsTable::REQUIRED_STRENGTH, 5],
            [BodyArmorCode::CHAINMAIL_ARMOR, BodyArmorsTable::RESTRICTION, -1],
            [BodyArmorCode::CHAINMAIL_ARMOR, BodyArmorsTable::PROTECTION, 6],
            [BodyArmorCode::CHAINMAIL_ARMOR, BodyArmorsTable::WEIGHT, 15.0],
            [BodyArmorCode::CHAINMAIL_ARMOR, BodyArmorsTable::ROUNDS_TO_PUT_ON, 2],

            [BodyArmorCode::SCALE_ARMOR, BodyArmorsTable::REQUIRED_STRENGTH, 7],
            [BodyArmorCode::SCALE_ARMOR, BodyArmorsTable::RESTRICTION, -2],
            [BodyArmorCode::SCALE_ARMOR, BodyArmorsTable::PROTECTION, 7],
            [BodyArmorCode::SCALE_ARMOR, BodyArmorsTable::WEIGHT, 20.0],
            [BodyArmorCode::SCALE_ARMOR, BodyArmorsTable::ROUNDS_TO_PUT_ON, 3],

            [BodyArmorCode::PLATE_ARMOR, BodyArmorsTable::REQUIRED_STRENGTH, 10],
            [BodyArmorCode::PLATE_ARMOR, BodyArmorsTable::RESTRICTION, -3],
            [BodyArmorCode::PLATE_ARMOR, BodyArmorsTable::PROTECTION, 9],
            [BodyArmorCode::PLATE_ARMOR, BodyArmorsTable::WEIGHT, 30.0],
            [BodyArmorCode::PLATE_ARMOR, BodyArmorsTable::ROUNDS_TO_PUT_ON, 3],

            [BodyArmorCode::FULL_PLATE_ARMOR, BodyArmorsTable::REQUIRED_STRENGTH, 12],
            [BodyArmorCode::FULL_PLATE_ARMOR, BodyArmorsTable::RESTRICTION, -4],
            [BodyArmorCode::FULL_PLATE_ARMOR, BodyArmorsTable::PROTECTION, 10],
            [BodyArmorCode::FULL_PLATE_ARMOR, BodyArmorsTable::WEIGHT, 35.0],
            [BodyArmorCode::FULL_PLATE_ARMOR, BodyArmorsTable::ROUNDS_TO_PUT_ON, 4],
        ];
    }

    /**
     * @test
     */
    public function I_get_rounds_to_put_on_armor_related_to_its_protection()
    {
        $bodyArmorsTable = new BodyArmorsTable();
        foreach (BodyArmorCode::getBodyArmorCodes() as $bodyArmorCode) {
            if ($bodyArmorCode === BodyArmorCode::WITHOUT_ARMOR) {
                self::assertFalse($bodyArmorsTable->getRoundsToPutOnOf($bodyArmorCode));
            } else {
                self::assertSame(
                    SumAndRound::ceiledThird($bodyArmorsTable->getProtectionOf($bodyArmorCode)),
                    $bodyArmorsTable->getRoundsToPutOnOf($bodyArmorCode)
                );
            }
        }
    }
}