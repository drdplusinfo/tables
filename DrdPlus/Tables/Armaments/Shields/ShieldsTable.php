<?php
namespace DrdPlus\Tables\Armaments\Shields;

use DrdPlus\Tables\Armaments\Partials\CoveringWeaponParametersInterface;
use DrdPlus\Tables\Armaments\Partials\UnwieldyParametersInterface;
use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound;
use Granam\Tools\ValueDescriber;

class ShieldsTable extends AbstractFileTable implements UnwieldyParametersInterface, CoveringWeaponParametersInterface
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/shields.csv';
    }

    protected function getRowsHeader()
    {
        return ['shield'];
    }

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::REQUIRED_STRENGTH => self::INTEGER,
            self::RESTRICTION => self::INTEGER,
            self::OFFENSIVENESS => self::INTEGER,
            self::WOUNDS => self::INTEGER,
            self::WOUNDS_TYPE => self::STRING,
            self::COVER => self::INTEGER,
            self::WEIGHT => self::FLOAT,
        ];
    }

    /**
     * @param string $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Shields\Exceptions\UnknownShieldCode
     */
    public function getRequiredStrengthOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::REQUIRED_STRENGTH);
    }

    /**
     * @param string $shieldCode
     * @param string $valueName
     * @return int|float|string
     * @throws \DrdPlus\Tables\Armaments\Shields\Exceptions\UnknownShieldCode
     */
    private function getValueOf($shieldCode, $valueName)
    {
        try {
            return $this->getValue([$shieldCode], $valueName);
        } catch (RequiredRowDataNotFound $exception) {
            throw new Exceptions\UnknownShieldCode(
                'Unknown shield code ' . ValueDescriber::describe($shieldCode)
            );
        }
    }

    /**
     * @param $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Shields\Exceptions\UnknownShieldCode
     */
    public function getRestrictionOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::RESTRICTION);
    }

    /**
     * @param $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Shields\Exceptions\UnknownShieldCode
     */
    public function getOffensivenessOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::OFFENSIVENESS);
    }

    /**
     * @param $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Shields\Exceptions\UnknownShieldCode
     */
    public function getWoundsOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::WOUNDS);
    }

    /**
     * @param $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Shields\Exceptions\UnknownShieldCode
     */
    public function getWoundsTypeOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::WOUNDS_TYPE);
    }

    /**
     * @param $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Shields\Exceptions\UnknownShieldCode
     */
    public function getCoverOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::COVER);
    }

    /**
     * @param $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Shields\Exceptions\UnknownShieldCode
     */
    public function getWeightOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::WEIGHT);
    }

}