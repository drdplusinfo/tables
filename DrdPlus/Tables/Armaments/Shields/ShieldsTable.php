<?php
namespace DrdPlus\Tables\Armaments\Shields;

use DrdPlus\Tables\Parts\AbstractFileTable;
use DrdPlus\Tables\Parts\Exceptions\RequiredRowDataNotFound;
use Granam\Tools\ValueDescriber;

class ShieldsTable extends AbstractFileTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/shields.csv';
    }

    protected function getExpectedRowsHeader()
    {
        return ['shield'];
    }

    const REQUIRED_STRENGTH_HEADER = 'required_strength';
    const RESTRICTION_HEADER = 'restriction';
    const OFFENSIVENESS_HEADER = 'offensiveness';
    const WOUNDS_HEADER = 'wounds';
    const WOUNDS_TYPE_HEADER = 'wounds_type';
    const COVER_HEADER = 'cover';
    const WEIGHT_HEADER = 'weight';

    protected function getExpectedDataHeader()
    {
        return [
            self::REQUIRED_STRENGTH_HEADER => self::INTEGER,
            self::RESTRICTION_HEADER => self::INTEGER,
            self::OFFENSIVENESS_HEADER => self::INTEGER,
            self::WOUNDS_HEADER => self::INTEGER,
            self::WOUNDS_TYPE_HEADER => self::STRING,
            self::COVER_HEADER => self::INTEGER,
            self::WEIGHT_HEADER => self::FLOAT,
        ];
    }

    /**
     * @param string $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Shields\Exceptions\UnknownShieldCode
     */
    public function getRequiredStrengthOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::REQUIRED_STRENGTH_HEADER);
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
        return $this->getValueOf($shieldCode, self::RESTRICTION_HEADER);
    }

    /**
     * @param $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Shields\Exceptions\UnknownShieldCode
     */
    public function getOffensivenessOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::OFFENSIVENESS_HEADER);
    }

    /**
     * @param $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Shields\Exceptions\UnknownShieldCode
     */
    public function getWoundsOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::WOUNDS_HEADER);
    }

    /**
     * @param $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Shields\Exceptions\UnknownShieldCode
     */
    public function getWoundsTypeOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::WOUNDS_TYPE_HEADER);
    }

    /**
     * @param $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Shields\Exceptions\UnknownShieldCode
     */
    public function getCoverOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::COVER_HEADER);
    }

    /**
     * @param $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Shields\Exceptions\UnknownShieldCode
     */
    public function getWeightOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::WEIGHT_HEADER);
    }

}