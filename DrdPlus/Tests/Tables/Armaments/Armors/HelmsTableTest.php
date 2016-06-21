<?php
namespace DrdPlus\Tests\Tables\Armaments\Armors;

use DrdPlus\Codes\ArmorCode;
use DrdPlus\Tables\Armaments\Armors\AbstractArmorsTable;

class HelmsTableTest extends AbstractArmorsTableTest
{
    public function provideArmorAndValue()
    {
        return [
            [ArmorCode::WITHOUT_HELM, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, false],
            [ArmorCode::WITHOUT_HELM, AbstractArmorsTable::RESTRICTION_HEADER, false],
            [ArmorCode::WITHOUT_HELM, AbstractArmorsTable::PROTECTION_HEADER, 0],
            [ArmorCode::WITHOUT_HELM, AbstractArmorsTable::WEIGHT_HEADER, false],

            [ArmorCode::LEATHER_CAP, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 0],
            [ArmorCode::LEATHER_CAP, AbstractArmorsTable::RESTRICTION_HEADER, false],
            [ArmorCode::LEATHER_CAP, AbstractArmorsTable::PROTECTION_HEADER, 1],
            [ArmorCode::LEATHER_CAP, AbstractArmorsTable::WEIGHT_HEADER, 0.3],

            [ArmorCode::CHAINMAIL_HOOD, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 2],
            [ArmorCode::CHAINMAIL_HOOD, AbstractArmorsTable::RESTRICTION_HEADER, false],
            [ArmorCode::CHAINMAIL_HOOD, AbstractArmorsTable::PROTECTION_HEADER, 2],
            [ArmorCode::CHAINMAIL_HOOD, AbstractArmorsTable::WEIGHT_HEADER, 1.2],

            [ArmorCode::CONICAL_HELM, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 3],
            [ArmorCode::CONICAL_HELM, AbstractArmorsTable::RESTRICTION_HEADER, -1],
            [ArmorCode::CONICAL_HELM, AbstractArmorsTable::PROTECTION_HEADER, 3],
            [ArmorCode::CONICAL_HELM, AbstractArmorsTable::WEIGHT_HEADER, 1.5],

            [ArmorCode::FULL_HELM, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 4],
            [ArmorCode::FULL_HELM, AbstractArmorsTable::RESTRICTION_HEADER, -1],
            [ArmorCode::FULL_HELM, AbstractArmorsTable::PROTECTION_HEADER, 4],
            [ArmorCode::FULL_HELM, AbstractArmorsTable::WEIGHT_HEADER, 2.0],

            [ArmorCode::BARREL_HELM, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 5],
            [ArmorCode::BARREL_HELM, AbstractArmorsTable::RESTRICTION_HEADER, -2],
            [ArmorCode::BARREL_HELM, AbstractArmorsTable::PROTECTION_HEADER, 5],
            [ArmorCode::BARREL_HELM, AbstractArmorsTable::WEIGHT_HEADER, 3.0],

            [ArmorCode::GREAT_HELM, AbstractArmorsTable::REQUIRED_STRENGTH_HEADER, 7],
            [ArmorCode::GREAT_HELM, AbstractArmorsTable::RESTRICTION_HEADER, -3],
            [ArmorCode::GREAT_HELM, AbstractArmorsTable::PROTECTION_HEADER, 7],
            [ArmorCode::GREAT_HELM, AbstractArmorsTable::WEIGHT_HEADER, 4.0],
        ];
    }
}