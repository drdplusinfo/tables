<?php
namespace DrdPlus\Tables\Armaments\Weapons\Shooting\Partials;

use DrdPlus\Tables\Armaments\Partials\WeaponParametersInterface;
use DrdPlus\Tables\Armaments\Weapons\Shooting\Exceptions\UnknownShootingArmamentCode;
use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound;
use Granam\Tools\ValueDescriber;

abstract class AbstractShootingArmamentsTable extends AbstractFileTable implements WeaponParametersInterface
{
    const RANGE_HEADER = 'range';

    protected function getExpectedDataHeader()
    {
        return [
            self::REQUIRED_STRENGTH_HEADER => self::INTEGER,
            self::OFFENSIVENESS_HEADER => self::INTEGER,
            self::WOUNDS_HEADER => self::INTEGER,
            self::WOUNDS_TYPE_HEADER => self::STRING,
            self::RANGE_HEADER => self::INTEGER,
            self::WEIGHT_HEADER => self::FLOAT,
        ];
    }

    /**
     * @param string $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Shooting\Exceptions\UnknownShootingArmamentCode
     */
    public function getOffensivenessOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::OFFENSIVENESS_HEADER);
    }

    /**
     * @param string $weaponCode
     * @param string $valueName
     * @return float|int|string
     * @throws \DrdPlus\Tables\Armaments\Weapons\Shooting\Exceptions\UnknownShootingArmamentCode
     */
    private function getValueOf($weaponCode, $valueName)
    {
        try {
            return $this->getValue([$weaponCode], $valueName);
        } catch (RequiredRowDataNotFound $exception) {
            throw new UnknownShootingArmamentCode(
                'Unknown shooting armament code ' . ValueDescriber::describe($weaponCode)
            );
        }
    }

    /**
     * @param string $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Shooting\Exceptions\UnknownShootingArmamentCode
     */
    public function getWoundsOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::WOUNDS_HEADER);
    }

    /**
     * @param string $weaponCode
     * @return string
     * @throws \DrdPlus\Tables\Armaments\Weapons\Shooting\Exceptions\UnknownShootingArmamentCode
     */
    public function getWoundsTypeOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::WOUNDS_TYPE_HEADER);
    }

    /**
     * @param string $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Shooting\Exceptions\UnknownShootingArmamentCode
     */
    public function getRequiredStrengthOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::REQUIRED_STRENGTH_HEADER);
    }

    /**
     * @param string $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Shooting\Exceptions\UnknownShootingArmamentCode
     */
    public function getRangeOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::RANGE_HEADER);
    }

    /**
     * @param string $weaponCode
     * @return float
     * @throws \DrdPlus\Tables\Armaments\Weapons\Shooting\Exceptions\UnknownShootingArmamentCode
     */
    public function getWeightOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::WEIGHT_HEADER);
    }

}