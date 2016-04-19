<?php
namespace DrdPlus\Tables\Armaments\Weapons\Melee\Partials;

use DrdPlus\Tables\Armaments\Partials\MeleeWeaponParametersInterface;
use DrdPlus\Tables\Partials\AbstractFileTable;
use Granam\Tools\ValueDescriber;

abstract class AbstractMeleeWeaponsTable extends AbstractFileTable implements MeleeWeaponParametersInterface
{
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
     * @param string $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Partials\Exceptions\UnknownWeaponCode
     */
    public function getOffensivenessOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::OFFENSIVENESS_HEADER);
    }

    /**
     * @param string $weaponCode
     * @param string $valueName
     * @return float|int|string
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Partials\Exceptions\UnknownWeaponCode
     */
    private function getValueOf($weaponCode, $valueName)
    {
        try {
            return $this->getValue([$weaponCode], $valueName);
        } catch (\DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound $exception) {
            throw new Exceptions\UnknownWeaponCode(
                'Unknown weapon code ' . ValueDescriber::describe($weaponCode)
            );
        }
    }

    /**
     * @param string $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Partials\Exceptions\UnknownWeaponCode
     */
    public function getWoundsOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::WOUNDS_HEADER);
    }

    /**
     * @param string $weaponCode
     * @return string
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Partials\Exceptions\UnknownWeaponCode
     */
    public function getWoundsTypeOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::WOUNDS_TYPE_HEADER);
    }

    /**
     * @param string $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Partials\Exceptions\UnknownWeaponCode
     */
    public function getRequiredStrengthOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::REQUIRED_STRENGTH_HEADER);
    }

    /**
     * @param string $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Partials\Exceptions\UnknownWeaponCode
     */
    public function getLengthOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::LENGTH_HEADER);
    }

    /**
     * @param string $weaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Partials\Exceptions\UnknownWeaponCode
     */
    public function getCoverOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::COVER_HEADER);
    }

    /**
     * @param string $weaponCode
     * @return float
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Partials\Exceptions\UnknownWeaponCode
     */
    public function getWeightOf($weaponCode)
    {
        return $this->getValueOf($weaponCode, self::WEIGHT_HEADER);
    }

}