<?php

namespace DrdPlus\Tests\Tables\Theurgist\Demons;

use DrdPlus\Codes\Theurgist\DemonCode;
use DrdPlus\Tables\Theurgist\Demons\DemonsTable;
use DrdPlus\Tests\Tables\Theurgist\AbstractTheurgistTableTest;

class DemonsTableTest extends AbstractTheurgistTableTest
{
    protected function getMandatoryParameters(): array
    {
        return [
            DemonsTable::REALM,
            DemonsTable::EVOCATION,
            DemonsTable::REALMS_AFFECTION,
            DemonsTable::DIFFICULTY
        ];
    }

    protected function getMainCodeClass(): string
    {
        return DemonCode::class;
    }

    protected function getOptionalParameters(): array
    {
        return [
            DemonsTable::DEMON_CAPACITY,
            DemonsTable::DEMON_ENDURANCE,
            DemonsTable::SPELL_SPEED,
            DemonsTable::DEMON_QUALITY,
            DemonsTable::DEMON_ACTIVATION_DURATION,
            DemonsTable::DEMON_RADIUS,
            DemonsTable::DEMON_STRENGTH,
            DemonsTable::DEMON_AGILITY,
            DemonsTable::DEMON_KNACK,
            DemonsTable::DEMON_ARMOR,
            DemonsTable::DEMON_INVISIBILITY,
        ];
    }
// TODO test parameters like demon body, will...
}
