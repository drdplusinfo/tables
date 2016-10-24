<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Ranged;

use DrdPlus\Codes\Armaments\SlingStoneCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTableTest;

class SlingStonesTableTest extends RangedWeaponsTableTest
{
    protected function getRowHeaderName()
    {
        return 'projectile';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [SlingStoneCode::SLING_STONE_LIGHT, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [SlingStoneCode::SLING_STONE_LIGHT, RangedWeaponsTable::OFFENSIVENESS, 0],
            [SlingStoneCode::SLING_STONE_LIGHT, RangedWeaponsTable::WOUNDS, 0],
            [SlingStoneCode::SLING_STONE_LIGHT, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [SlingStoneCode::SLING_STONE_LIGHT, RangedWeaponsTable::RANGE, 0],
            [SlingStoneCode::SLING_STONE_LIGHT, RangedWeaponsTable::COVER, 0],
            [SlingStoneCode::SLING_STONE_LIGHT, RangedWeaponsTable::WEIGHT, 0.1],
            [SlingStoneCode::SLING_STONE_LIGHT, RangedWeaponsTable::TWO_HANDED, false],

            [SlingStoneCode::SLING_STONE_HEAVIER, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [SlingStoneCode::SLING_STONE_HEAVIER, RangedWeaponsTable::OFFENSIVENESS, 0],
            [SlingStoneCode::SLING_STONE_HEAVIER, RangedWeaponsTable::WOUNDS, 2],
            [SlingStoneCode::SLING_STONE_HEAVIER, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [SlingStoneCode::SLING_STONE_HEAVIER, RangedWeaponsTable::RANGE, -2],
            [SlingStoneCode::SLING_STONE_HEAVIER, RangedWeaponsTable::COVER, 0],
            [SlingStoneCode::SLING_STONE_HEAVIER, RangedWeaponsTable::WEIGHT, 0.2],
            [SlingStoneCode::SLING_STONE_HEAVIER, RangedWeaponsTable::TWO_HANDED, false],
        ];
    }

}