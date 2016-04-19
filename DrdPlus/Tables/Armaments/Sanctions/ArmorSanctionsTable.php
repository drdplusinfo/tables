<?php
namespace DrdPlus\Tables\Armaments\Sanctions;

use DrdPlus\Tables\Partials\AbstractFileTable;
use Granam\Integer\Tools\ToInteger;

class ArmorSanctionsTable extends AbstractFileTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/sanctions_for_armor.csv';
    }

    protected function getExpectedRowsHeader()
    {
        return [];
    }

    const MINIMAL_MISSING_STRENGTH_HEADER = 'minimal_missing_strength';
    const MAXIMAL_MISSING_STRENGTH_HEADER = 'maximal_missing_strength';
    const DESCRIPTION_HEADER = 'description';
    const AGILITY_SANCTION_HEADER = 'agility_sanction';
    const CAN_MOVE_HEADER = 'can_move';

    protected function getExpectedDataHeader()
    {
        return [
            self::MINIMAL_MISSING_STRENGTH_HEADER => self::INTEGER,
            self::MAXIMAL_MISSING_STRENGTH_HEADER => self::INTEGER,
            self::DESCRIPTION_HEADER => self::STRING,
            self::AGILITY_SANCTION_HEADER => self::INTEGER,
            self::CAN_MOVE_HEADER => self::BOOLEAN,
        ];
    }

    /**
     * @param int|bool $missingStrength
     * @return array|mixed[];
     */
    public function getSanctionValuesForMissingStrength($missingStrength)
    {
        if ($missingStrength === false) {
            return $this->getRow([0]); // very first row with no sanction
        }
        $missingStrength = ToInteger::toInteger($missingStrength);
        $row = [];
        foreach ($this->getIndexedValues() as $row) {
            if (
                ($row[self::MINIMAL_MISSING_STRENGTH_HEADER] === false
                    || $row[self::MINIMAL_MISSING_STRENGTH_HEADER] <= $missingStrength
                )
                && ($row[self::MAXIMAL_MISSING_STRENGTH_HEADER] === false
                    || $row[self::MAXIMAL_MISSING_STRENGTH_HEADER] >= $missingStrength
                )
            ) {
                break;
            }
        }

        return $row;
    }

}