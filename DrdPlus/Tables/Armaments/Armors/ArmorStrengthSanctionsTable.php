<?php
namespace DrdPlus\Tables\Armaments\Armors;

use DrdPlus\Tables\Armaments\Exceptions\CanNotUseArmorBecauseOfMissingStrength;
use DrdPlus\Tables\Armaments\Partials\AbstractStrengthSanctionsTable;

/**
 * See PPH page 91 right column, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_postihu_za_zbroj
 */
class ArmorStrengthSanctionsTable extends AbstractStrengthSanctionsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/armor_strength_sanctions.csv';
    }

    const SANCTION_DESCRIPTION = 'sanction_description';
    const AGILITY_SANCTION = 'agility_sanction';
    const CAN_MOVE = 'can_move';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::MISSING_STRENGTH => self::POSITIVE_INTEGER,
            self::SANCTION_DESCRIPTION => self::STRING,
            self::AGILITY_SANCTION => self::NEGATIVE_INTEGER,
            self::CAN_MOVE => self::BOOLEAN,
        ];
    }

    /**
     * @param int $missingStrength
     * @return bool
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function canUseIt($missingStrength)
    {
        return $this->canMove($missingStrength);
    }

    /**
     * @param int $missingStrength
     * @return bool
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function canMove($missingStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getSanctionOf(
            $missingStrength,
            self::CAN_MOVE,
            false /* do not check missing strength before value determination */
        );
    }

    /**
     * @param int $missingStrength
     * @return int
     * @throws CanNotUseArmorBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getSanctionDescription($missingStrength)
    {
        return $this->getSanctionOf($missingStrength, self::SANCTION_DESCRIPTION, false /* do not check maximal missing strength */);
    }

    /**
     * @param int $missingStrength
     * @param string $columnName
     * @param bool $guardMaximumMissingStrength
     * @return int
     * @throws CanNotUseArmorBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    private function getSanctionOf($missingStrength, $columnName, $guardMaximumMissingStrength = true)
    {
        if ($guardMaximumMissingStrength && !$this->canMove($missingStrength)) {
            throw new CanNotUseArmorBecauseOfMissingStrength(
                "Too much missing strength {$missingStrength} to bear an armor"
            );
        }

        return $this->getSanctionsForMissingStrength($missingStrength)[$columnName];
    }

    /**
     * @param int $missingStrength
     * @return int
     * @throws CanNotUseArmorBecauseOfMissingStrength
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getAgilityMalus($missingStrength)
    {
        return $this->getSanctionOf($missingStrength, self::AGILITY_SANCTION);
    }
}