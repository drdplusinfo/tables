<?php
namespace DrdPlus\Tables\Armaments\Partials;

use DrdPlus\Tables\Partials\AbstractFileTable;
use Granam\Integer\Tools\ToInteger;

abstract class AbstractSanctionsForMissingStrengthTable extends AbstractFileTable
{
    const MISSING_STRENGTH = 'missing_strength';

    protected function getRowsHeader()
    {
        return [self::MISSING_STRENGTH];
    }

    /**
     * @param int $missingStrength
     * @return array|mixed[];
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getSanctionsForMissingStrength($missingStrength)
    {
        $missingStrength = ToInteger::toInteger($missingStrength);
        $currentRow = [];
        foreach ($this->getIndexedValues() as $currentRow) {
            if ($currentRow[self::MISSING_STRENGTH] >= $missingStrength) {
                return $currentRow; // rows are ordered from lowest to highest missing strength
            }
        }

        return $currentRow; // row with highest missing strength is the last
    }

    /**
     * @param int $missingStrength
     * @return bool
     */
    abstract public function canUseArmament($missingStrength);
}