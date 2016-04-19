<?php
namespace DrdPlus\Tables\Armaments\Weapons\Melee;

use DrdPlus\Tables\Armaments\Partials\MeleeWeaponParametersInterface;
use DrdPlus\Tables\Partials\AbstractFileTable;
use Granam\Tools\ValueDescriber;

class AxesTable extends AbstractFileTable implements MeleeWeaponParametersInterface
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/axes.csv';
    }

    protected function getExpectedRowsHeader()
    {
        return ['weapon'];
    }

    protected function getExpectedDataHeader()
    {
        return [
            self::REQUIRED_STRENGTH_HEADER => self::INTEGER,
            self::LENGTH_HEADER => self::INTEGER,
            self::OFFENSIVENESS_HEADER => self::INTEGER,
            self::WOUNDS_HEADER => self::INTEGER,
            self::WOUNDS_TYPE_HEADER => self::STRING,
            self::COVER_HEADER => self::INTEGER,
            self::WEIGHT_HEADER => self::FLOAT,
        ];
    }

    /**
     * @param string $axeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownWeaponCode
     */
    public function getOffensivenessOf($axeCode)
    {
        return $this->getValueOf($axeCode, self::OFFENSIVENESS_HEADER);
    }

    /**
     * @param string $axeCode
     * @param string $valueName
     * @return float|int|string
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownWeaponCode
     */
    private function getValueOf($axeCode, $valueName)
    {
        try {
            return $this->getValue([$axeCode], $valueName);
        } catch (\DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound $exception) {
            throw new Exceptions\UnknownWeaponCode(
                'Unknown axe code ' . ValueDescriber::describe($axeCode)
            );
        }
    }

    /**
     * @param string $axeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownWeaponCode
     */
    public function getWoundsOf($axeCode)
    {
        return $this->getValueOf($axeCode, self::WOUNDS_HEADER);
    }

    /**
     * @param string $axeCode
     * @return string
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownWeaponCode
     */
    public function getWoundsTypeOf($axeCode)
    {
        return $this->getValueOf($axeCode, self::WOUNDS_TYPE_HEADER);
    }

    /**
     * @param string $axeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownWeaponCode
     */
    public function getRequiredStrengthOf($axeCode)
    {
        return $this->getValueOf($axeCode, self::REQUIRED_STRENGTH_HEADER);
    }

    /**
     * @param string $axeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownWeaponCode
     */
    public function getLengthOf($axeCode)
    {
        return $this->getValueOf($axeCode, self::LENGTH_HEADER);
    }

    /**
     * @param string $axeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownWeaponCode
     */
    public function getCoverOf($axeCode)
    {
        return $this->getValueOf($axeCode, self::COVER_HEADER);
    }

    /**
     * @param string $axeCode
     * @return float
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownWeaponCode
     */
    public function getWeightOf($axeCode)
    {
        return $this->getValueOf($axeCode, self::WEIGHT_HEADER);
    }

}