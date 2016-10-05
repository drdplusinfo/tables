<?php
namespace DrdPlus\Tables\Armaments\Partials;

use DrdPlus\Tables\Partials\AbstractFileTable;
use Granam\Integer\IntegerInterface;
use Granam\Integer\Tools\ToInteger;

abstract class AbstractStrengthSanctionsTable extends AbstractFileTable implements StrengthSanctionsInterface
{
    const MISSING_STRENGTH = 'missing_strength';

    protected function getRowsHeader()
    {
        return [self::MISSING_STRENGTH];
    }

    /**
     * @param int|IntegerInterface $missingStrength
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

}