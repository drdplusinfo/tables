<?php
namespace DrdPlus\Tables\Body\FatigueByLoad;

use DrdPlus\Tables\Body\MovementTypes\MovementTypesTable;
use DrdPlus\Tables\Measurements\Time\Time;
use DrdPlus\Tables\Partials\AbstractFileTable;
use Granam\Integer\Tools\ToInteger;

class FatigueByLoadTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/fatigue_by_load.csv';
    }

    protected function getRowsHeader()
    {
        return ['missing_strength_up_to'];
    }

    const LOAD = 'load';
    const WEARIES_LIKE = 'wearies_like';

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::LOAD => self::STRING,
            self::WEARIES_LIKE => self::STRING
        ];
    }

    /**
     * @param int $missingStrength
     * @param AthleticsInterface $athletics
     * @param MovementTypesTable $movementTypesTable
     * @return Time|false Gives false if there is no fatigue from current load at all
     * @throws \DrdPlus\Tables\Body\FatigueByLoad\Exceptions\OverloadedAndCanNotMove
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getPeriodForPointOfFatigue($missingStrength, AthleticsInterface $athletics, MovementTypesTable $movementTypesTable)
    {
        $desiredRow = $this->getRowFittingToMissingStrength($missingStrength, $athletics);

        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $movementTypesTable->getPeriodForPointOfFatigue($desiredRow[self::WEARIES_LIKE]);
    }

    /**
     * @param int $missingStrength
     * @param AthleticsInterface $athletics
     * @return array
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     * @throws \DrdPlus\Tables\Body\FatigueByLoad\Exceptions\OverloadedAndCanNotMove
     */
    private function getRowFittingToMissingStrength($missingStrength, AthleticsInterface $athletics)
    {
        $missingStrength = ToInteger::toInteger($missingStrength) - $athletics->getAthleticsBonus()->getValue();
        $usedMaximalMissingStrength = false;
        $desiredRow = [];
        foreach ($this->getIndexedValues() as $maximalMissingStrength => $row) {
            if ($maximalMissingStrength >= $missingStrength
                && ($usedMaximalMissingStrength === false || $usedMaximalMissingStrength > $maximalMissingStrength)
            ) {
                $desiredRow = $row;
                $usedMaximalMissingStrength = $maximalMissingStrength;
            }
        }
        if (!$desiredRow) { // overload is so big so person can not move
            throw new Exceptions\OverloadedAndCanNotMove(
                "Missing strength {$missingStrength} causes overload so the being can not move at all"
                . ($athletics->getAthleticsBonus()->getValue() > 0
                    ? " even with athletics {$athletics->getAthleticsBonus()}"
                    : ''
                )
            );
        }

        return $desiredRow;
    }

    /**
     * @param int $missingStrength
     * @param AthleticsInterface $athletics
     * @return string
     * @throws \DrdPlus\Tables\Body\FatigueByLoad\Exceptions\OverloadedAndCanNotMove
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getLoadName($missingStrength, AthleticsInterface $athletics)
    {
        $desiredRow = $this->getRowFittingToMissingStrength($missingStrength, $athletics);

        return $desiredRow[self::LOAD];
    }
}