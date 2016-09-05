<?php
namespace DrdPlus\Tables\Armaments\Weapons\Ranged\Partials;

use DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon;
use DrdPlus\Tables\Armaments\Partials\AbstractArmamentsTable;
use DrdPlus\Tables\Armaments\Partials\WeaponlikeTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound;
use Granam\Tools\ValueDescriber;

abstract class RangedWeaponsTable extends AbstractArmamentsTable implements WeaponlikeTable
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
            self::COVER => self::INTEGER,
            self::WEIGHT => self::FLOAT,
            self::TWO_HANDED => self::BOOLEAN,
        ];
    }

    /**
     * @param string $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    public function getOffensivenessOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::OFFENSIVENESS);
    }

    /**
     * @param string $weaponlikeCode
     * @param string $valueName
     * @return float|int|string|bool
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    protected function getValueOf($weaponlikeCode, $valueName)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->getValue([$weaponlikeCode], $valueName);
        } catch (RequiredRowNotFound $exception) {
            throw new UnknownRangedWeapon(
                'Unknown shooting armament code ' . ValueDescriber::describe($weaponlikeCode)
            );
        }
    }

    /**
     * @param string $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    public function getWoundsOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::WOUNDS);
    }

    /**
     * @param string $weaponlikeCode
     * @return string
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    public function getWoundsTypeOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::WOUNDS_TYPE);
    }

    /**
     * @param string $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    public function getRequiredStrengthOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::REQUIRED_STRENGTH);
    }

    /**
     * @param string $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    public function getRangeOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::RANGE);
    }

    /**
     * Every ranged weapon is considered as with cover of 2 (projectiles 0), see PPH page 94, right column
     *
     * @param string $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    public function getCoverOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::COVER);
    }

    /**
     * @param string $weaponlikeCode
     * @return float
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    public function getWeightOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::WEIGHT);
    }

    /**
     * @param $weaponlikeCode
     * @return bool
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    public function getTwoHandedOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::TWO_HANDED);
    }

}