<?php
namespace DrdPlus\Tests\Tables\Armaments\Projectiles;

use DrdPlus\Codes\Armaments\SlingStoneCode;
use DrdPlus\Codes\Body\WoundTypeCode;
use DrdPlus\Tables\Armaments\Projectiles\SlingStonesTable;
use DrdPlus\Tests\Tables\Armaments\Projectiles\Partials\ProjectilesTableTest;

class SlingStonesTableTest extends ProjectilesTableTest
{
    protected function getRowHeaderName()
    {
        return 'projectile';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [SlingStoneCode::SLING_STONE_LIGHT, SlingStonesTable::OFFENSIVENESS, 0],
            [SlingStoneCode::SLING_STONE_LIGHT, SlingStonesTable::WOUNDS, 0],
            [SlingStoneCode::SLING_STONE_LIGHT, SlingStonesTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [SlingStoneCode::SLING_STONE_LIGHT, SlingStonesTable::RANGE, 0],
            [SlingStoneCode::SLING_STONE_LIGHT, SlingStonesTable::WEIGHT, 0.1],

            [SlingStoneCode::SLING_STONE_HEAVIER, SlingStonesTable::OFFENSIVENESS, 0],
            [SlingStoneCode::SLING_STONE_HEAVIER, SlingStonesTable::WOUNDS, 2],
            [SlingStoneCode::SLING_STONE_HEAVIER, SlingStonesTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [SlingStoneCode::SLING_STONE_HEAVIER, SlingStonesTable::RANGE, -2],
            [SlingStoneCode::SLING_STONE_HEAVIER, SlingStonesTable::WEIGHT, 0.2],
        ];
    }

}