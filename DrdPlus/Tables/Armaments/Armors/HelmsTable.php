<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Armaments\Armors;

use DrdPlus\Codes\Armaments\HelmCode;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Tables\Measurements\Weight\Weight;

/**
 * See PPH page 90 left column, @link https://pph.drdplus.info/#tabulka_zbroji_a_prileb
 */
class HelmsTable extends AbstractArmorsTable
{
    private $customHelms = [];

    /**
     * @return string
     */
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/helms.csv';
    }

    const HELM = 'helm';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader(): array
    {
        return [self::HELM];
    }

    public function getIndexedValues(): array
    {
        $indexedValues = parent::getIndexedValues();

        return array_merge($indexedValues, $this->customHelms);
    }

    // TODO share code with body armors table and test following method

    /**
     * @param HelmCode $helmCode
     * @param Strength $requiredStrength
     * @param int $restriction
     * @param int $protection
     * @param Weight $weight
     * @return bool
     * @throws \DrdPlus\Tables\Armaments\Armors\Exceptions\DifferentBodyArmorIsUnderSameName
     */
    public function addNewHelm(
        HelmCode $helmCode,
        Strength $requiredStrength,
        int $restriction,
        int $protection,
        Weight $weight
    ): bool
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $previousParameters = $this->findRow($helmCode);
        $newHelmParameters = [
            self::REQUIRED_STRENGTH => $requiredStrength->getValue(),
            self::RESTRICTION => $restriction,
            self::PROTECTION => $protection,
            self::WEIGHT => $weight->getKilograms(),
        ];
        if ($previousParameters) {
            if ($newHelmParameters === $previousParameters) {
                return false;
            }
            throw new Exceptions\DifferentBodyArmorIsUnderSameName(
                "New helm {$helmCode} can not be added as there is already a helm under same name"
                . ' but with different properties: '
                . var_export(array_diff_assoc($previousParameters, $newHelmParameters), true)
            );
        }
        $this->customHelms[$helmCode->getValue()] = $newHelmParameters;

        return true;
    }
}