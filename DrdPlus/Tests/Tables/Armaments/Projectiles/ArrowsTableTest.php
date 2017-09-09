<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tests\Tables\Armaments\Projectiles;

use DrdPlus\Codes\Armaments\ArrowCode;
use DrdPlus\Codes\Body\WoundTypeCode;
use DrdPlus\Tables\Armaments\Projectiles\ArrowsTable;
use DrdPlus\Tests\Tables\Armaments\Projectiles\Partials\ProjectilesTableTest;

class ArrowsTableTest extends ProjectilesTableTest
{
    protected function getRowHeaderName(): string
    {
        return 'projectile';
    }

    public function provideArmamentAndNameWithValue(): array
    {
        return [
            [ArrowCode::BASIC_ARROW, ArrowsTable::OFFENSIVENESS, 0],
            [ArrowCode::BASIC_ARROW, ArrowsTable::WOUNDS, 0],
            [ArrowCode::BASIC_ARROW, ArrowsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ArrowCode::BASIC_ARROW, ArrowsTable::RANGE, 0],
            [ArrowCode::BASIC_ARROW, ArrowsTable::WEIGHT, 0.05],

            [ArrowCode::LONG_RANGE_ARROW, ArrowsTable::OFFENSIVENESS, 0],
            [ArrowCode::LONG_RANGE_ARROW, ArrowsTable::WOUNDS, -1],
            [ArrowCode::LONG_RANGE_ARROW, ArrowsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ArrowCode::LONG_RANGE_ARROW, ArrowsTable::RANGE, 2],
            [ArrowCode::LONG_RANGE_ARROW, ArrowsTable::WEIGHT, 0.05],

            [ArrowCode::WAR_ARROW, ArrowsTable::OFFENSIVENESS, 0],
            [ArrowCode::WAR_ARROW, ArrowsTable::WOUNDS, 2],
            [ArrowCode::WAR_ARROW, ArrowsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ArrowCode::WAR_ARROW, ArrowsTable::RANGE, -2],
            [ArrowCode::WAR_ARROW, ArrowsTable::WEIGHT, 0.1],

            [ArrowCode::PIERCING_ARROW, ArrowsTable::OFFENSIVENESS, 0],
            [ArrowCode::PIERCING_ARROW, ArrowsTable::WOUNDS, -1],
            [ArrowCode::PIERCING_ARROW, ArrowsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ArrowCode::PIERCING_ARROW, ArrowsTable::RANGE, 0],
            [ArrowCode::PIERCING_ARROW, ArrowsTable::WEIGHT, 0.05],

            [ArrowCode::HOLLOW_ARROW, ArrowsTable::OFFENSIVENESS, 0],
            [ArrowCode::HOLLOW_ARROW, ArrowsTable::WOUNDS, -1],
            [ArrowCode::HOLLOW_ARROW, ArrowsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ArrowCode::HOLLOW_ARROW, ArrowsTable::RANGE, 0],
            [ArrowCode::HOLLOW_ARROW, ArrowsTable::WEIGHT, 0.05],

            [ArrowCode::CRIPPLING_ARROW, ArrowsTable::OFFENSIVENESS, -1],
            [ArrowCode::CRIPPLING_ARROW, ArrowsTable::WOUNDS, -2],
            [ArrowCode::CRIPPLING_ARROW, ArrowsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ArrowCode::CRIPPLING_ARROW, ArrowsTable::RANGE, -1],
            [ArrowCode::CRIPPLING_ARROW, ArrowsTable::WEIGHT, 0.05],

            [ArrowCode::INCENDIARY_ARROW, ArrowsTable::OFFENSIVENESS, -3],
            [ArrowCode::INCENDIARY_ARROW, ArrowsTable::WOUNDS, -3],
            [ArrowCode::INCENDIARY_ARROW, ArrowsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [ArrowCode::INCENDIARY_ARROW, ArrowsTable::RANGE, -2],
            [ArrowCode::INCENDIARY_ARROW, ArrowsTable::WEIGHT, 0.05],

            [ArrowCode::SILVER_ARROW, ArrowsTable::OFFENSIVENESS, 0],
            [ArrowCode::SILVER_ARROW, ArrowsTable::WOUNDS, 0],
            [ArrowCode::SILVER_ARROW, ArrowsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ArrowCode::SILVER_ARROW, ArrowsTable::RANGE, 0],
            [ArrowCode::SILVER_ARROW, ArrowsTable::WEIGHT, 0.05],
        ];
    }

}