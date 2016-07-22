<?php
namespace DrdPlus\Tables\Armaments\Sanctions;

class ArmorSanctionsTable extends AbstractSanctionsForMissingStrengthTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/armor_sanctions.csv';
    }

    protected function getExpectedRowsHeader()
    {
        return [];
    }

    const DESCRIPTION = 'description';
    const AGILITY_SANCTION = 'agility_sanction';
    const CAN_MOVE = 'can_move';

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::MISSING_STRENGTH => self::POSITIVE_INTEGER,
            self::DESCRIPTION => self::STRING,
            self::AGILITY_SANCTION => self::NEGATIVE_INTEGER,
            self::CAN_MOVE => self::BOOLEAN,
        ];
    }

}