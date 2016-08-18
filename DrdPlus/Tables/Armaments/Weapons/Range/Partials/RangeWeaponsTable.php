<?php
namespace DrdPlus\Tables\Armaments\Weapons\Range\Partials;

use DrdPlus\Tables\Armaments\Partials\AbstractArmamentsTable;
use DrdPlus\Tables\Armaments\Partials\WeaponParametersInterface;
use DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound;
use Granam\Tools\ValueDescriber;

abstract class RangeWeaponsTable extends AbstractArmamentsTable implements WeaponParametersInterface
{
    const RANGE = 'range';

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::REQUIRED_STRENGTH => self::INTEGER,
            self::OFFENSIVENESS => self::INTEGER,
            self::WOUNDS => self::INTEGER,
            self::WOUNDS_TYPE => self::STRING,
            self::RANGE => self::INTEGER,
            self::WEIGHT => self::FLOAT,
        ];
    }

    /**
     * @param string $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode
     */
    public function getOffensivenessOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::OFFENSIVENESS);
    }

    /**
     * @param string $weaponCode
     * @param string $valueName
     * @return float|int|string
     * @throws \DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode
     */
    protected function getValueOf($weaponCode, $valueName)
    {
        try {
            return $this->getValue([$weaponCode], $valueName);
        } catch (RequiredRowNotFound $exception) {
            throw new UnknownRangeWeaponCode(
                'Unknown shooting armament code ' . ValueDescriber::describe($weaponCode)
            );
        }
    }

    /**
     * @param string $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode
     */
    public function getWoundsOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::WOUNDS);
    }

    /**
     * @param string $weaponCode
     * @return string
     * @throws \DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode
     */
    public function getWoundsTypeOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::WOUNDS_TYPE);
    }

    /**
     * @param string $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode
     */
    public function getRequiredStrengthOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::REQUIRED_STRENGTH);
    }

    /**
     * @param string $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode
     */
    public function getRangeOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::RANGE);
    }

    /**
     * @param string $weaponCode
     * @return float
     * @throws \DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode
     */
    public function getWeightOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::WEIGHT);
    }

}