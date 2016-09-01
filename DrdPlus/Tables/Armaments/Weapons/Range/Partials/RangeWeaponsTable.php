<?php
namespace DrdPlus\Tables\Armaments\Weapons\Range\Partials;

use DrdPlus\Tables\Armaments\Exceptions\UnknownRangeWeapon;
use DrdPlus\Tables\Armaments\Partials\AbstractArmamentsTable;
use DrdPlus\Tables\Armaments\Partials\WeaponlikeTableInterface;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound;
use Granam\Tools\ValueDescriber;

abstract class RangeWeaponsTable extends AbstractArmamentsTable implements WeaponlikeTableInterface
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
     * @param string $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangeWeapon
     */
    public function getOffensivenessOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::OFFENSIVENESS);
    }

    /**
     * @param string $weaponlikeCode
     * @param string $valueName
     * @return float|int|string
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangeWeapon
     */
    protected function getValueOf($weaponlikeCode, $valueName)
    {
        try {
            return $this->getValue([$weaponlikeCode], $valueName);
        } catch (RequiredRowNotFound $exception) {
            throw new UnknownRangeWeapon(
                'Unknown shooting armament code ' . ValueDescriber::describe($weaponlikeCode)
            );
        }
    }

    /**
     * @param string $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangeWeapon
     */
    public function getWoundsOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::WOUNDS);
    }

    /**
     * @param string $weaponlikeCode
     * @return string
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangeWeapon
     */
    public function getWoundsTypeOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::WOUNDS_TYPE);
    }

    /**
     * @param string $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangeWeapon
     */
    public function getRequiredStrengthOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::REQUIRED_STRENGTH);
    }

    /**
     * @param string $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangeWeapon
     */
    public function getRangeOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::RANGE);
    }

    /**
     * @param string $weaponlikeCode
     * @return float
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangeWeapon
     */
    public function getWeightOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::WEIGHT);
    }

}