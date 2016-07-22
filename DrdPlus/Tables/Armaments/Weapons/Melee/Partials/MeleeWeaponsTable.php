<?php
namespace DrdPlus\Tables\Armaments\Weapons\Melee\Partials;

use DrdPlus\Tables\Armaments\Partials\AbstractArmamentsTable;
use DrdPlus\Tables\Armaments\Partials\CoveringWeaponParametersInterface;
use DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeaponCode;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound;
use Granam\Tools\ValueDescriber;

abstract class MeleeWeaponsTable extends AbstractArmamentsTable implements CoveringWeaponParametersInterface
{
    protected function getExpectedRowsHeader()
    {
        return ['weapon'];
    }

    const LENGTH = 'length';

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::REQUIRED_STRENGTH => self::INTEGER,
            self::LENGTH => self::INTEGER,
            self::OFFENSIVENESS => self::INTEGER,
            self::WOUNDS => self::INTEGER,
            self::WOUNDS_TYPE => self::STRING,
            self::COVER => self::INTEGER,
            self::WEIGHT => self::FLOAT,
        ];
    }

    /**
     * @param string $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeaponCode
     */
    public function getOffensivenessOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::OFFENSIVENESS);
    }

    /**
     * @param string $weaponCode
     * @param string $valueName
     * @return float|int|string
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeaponCode
     */
    private function getValueOf($weaponCode, $valueName)
    {
        try {
            return $this->getValue([$weaponCode], $valueName);
        } catch (RequiredRowDataNotFound $exception) {
            throw new UnknownMeleeWeaponCode(
                'Unknown weapon code ' . ValueDescriber::describe($weaponCode)
            );
        }
    }

    /**
     * @param string $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeaponCode
     */
    public function getWoundsOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::WOUNDS);
    }

    /**
     * @param string $weaponCode
     * @return string
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeaponCode
     */
    public function getWoundsTypeOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::WOUNDS_TYPE);
    }

    /**
     * @param string $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeaponCode
     */
    public function getRequiredStrengthOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::REQUIRED_STRENGTH);
    }

    /**
     * @param string $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeaponCode
     */
    public function getLengthOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::LENGTH);
    }

    /**
     * @param string $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeaponCode
     */
    public function getCoverOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::COVER);
    }

    /**
     * @param string $weaponCode
     * @return float
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeaponCode
     */
    public function getWeightOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::WEIGHT);
    }

}