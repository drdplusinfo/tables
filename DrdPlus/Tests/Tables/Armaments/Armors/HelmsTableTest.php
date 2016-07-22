<?php
namespace DrdPlus\Tests\Tables\Armaments\Armors;

use DrdPlus\Codes\HelmCode;
use DrdPlus\Tables\Armaments\Armors\AbstractArmorsTable;

class HelmsTableTest extends AbstractArmorsTableTest
{
    public function provideArmorAndValue()
    {
        return [
            [HelmCode::WITHOUT_HELM, AbstractArmorsTable::REQUIRED_STRENGTH, false],
            [HelmCode::WITHOUT_HELM, AbstractArmorsTable::RESTRICTION, false],
            [HelmCode::WITHOUT_HELM, AbstractArmorsTable::PROTECTION, 0],
            [HelmCode::WITHOUT_HELM, AbstractArmorsTable::WEIGHT, false],

            [HelmCode::LEATHER_CAP, AbstractArmorsTable::REQUIRED_STRENGTH, 0],
            [HelmCode::LEATHER_CAP, AbstractArmorsTable::RESTRICTION, false],
            [HelmCode::LEATHER_CAP, AbstractArmorsTable::PROTECTION, 1],
            [HelmCode::LEATHER_CAP, AbstractArmorsTable::WEIGHT, 0.3],

            [HelmCode::CHAINMAIL_HOOD, AbstractArmorsTable::REQUIRED_STRENGTH, 2],
            [HelmCode::CHAINMAIL_HOOD, AbstractArmorsTable::RESTRICTION, false],
            [HelmCode::CHAINMAIL_HOOD, AbstractArmorsTable::PROTECTION, 2],
            [HelmCode::CHAINMAIL_HOOD, AbstractArmorsTable::WEIGHT, 1.2],

            [HelmCode::CONICAL_HELM, AbstractArmorsTable::REQUIRED_STRENGTH, 3],
            [HelmCode::CONICAL_HELM, AbstractArmorsTable::RESTRICTION, -1],
            [HelmCode::CONICAL_HELM, AbstractArmorsTable::PROTECTION, 3],
            [HelmCode::CONICAL_HELM, AbstractArmorsTable::WEIGHT, 1.5],

            [HelmCode::FULL_HELM, AbstractArmorsTable::REQUIRED_STRENGTH, 4],
            [HelmCode::FULL_HELM, AbstractArmorsTable::RESTRICTION, -1],
            [HelmCode::FULL_HELM, AbstractArmorsTable::PROTECTION, 4],
            [HelmCode::FULL_HELM, AbstractArmorsTable::WEIGHT, 2.0],

            [HelmCode::BARREL_HELM, AbstractArmorsTable::REQUIRED_STRENGTH, 5],
            [HelmCode::BARREL_HELM, AbstractArmorsTable::RESTRICTION, -2],
            [HelmCode::BARREL_HELM, AbstractArmorsTable::PROTECTION, 5],
            [HelmCode::BARREL_HELM, AbstractArmorsTable::WEIGHT, 3.0],

            [HelmCode::GREAT_HELM, AbstractArmorsTable::REQUIRED_STRENGTH, 7],
            [HelmCode::GREAT_HELM, AbstractArmorsTable::RESTRICTION, -3],
            [HelmCode::GREAT_HELM, AbstractArmorsTable::PROTECTION, 7],
            [HelmCode::GREAT_HELM, AbstractArmorsTable::WEIGHT, 4.0],
        ];
    }
}