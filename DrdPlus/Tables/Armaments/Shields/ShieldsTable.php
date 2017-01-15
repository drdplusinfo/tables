<?php
namespace DrdPlus\Tables\Armaments\Shields;

use DrdPlus\Tables\Armaments\Exceptions\UnknownShield;
use DrdPlus\Tables\Armaments\Partials\AbstractArmamentsTable;
use DrdPlus\Tables\Armaments\Partials\MeleeWeaponlikesTable;
use DrdPlus\Tables\Armaments\Partials\UnwieldyTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound;
use Granam\Tools\ValueDescriber;

/**
 * See PPH page 86 right column, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_stitu
 */
class ShieldsTable extends AbstractArmamentsTable implements UnwieldyTable, MeleeWeaponlikesTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/shields.csv';
    }

    const SHIELD = 'shield';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [self::SHIELD];
    }

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::REQUIRED_STRENGTH => self::INTEGER,
            self::LENGTH => self::INTEGER,
            self::RESTRICTION => self::INTEGER,
            self::OFFENSIVENESS => self::INTEGER,
            self::WOUNDS => self::INTEGER,
            self::WOUNDS_TYPE => self::STRING,
            self::COVER => self::INTEGER,
            self::WEIGHT => self::FLOAT,
            self::TWO_HANDED => self::BOOLEAN,
        ];
    }

    /**
     * @param string $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownShield
     */
    public function getRequiredStrengthOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::REQUIRED_STRENGTH);
    }

    /**
     * @param string $shieldCode
     * @param string $valueName
     * @return int|float|string|bool
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownShield
     */
    private function getValueOf($shieldCode, $valueName)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->getValue([$shieldCode], $valueName);
        } catch (RequiredRowNotFound $exception) {
            throw new UnknownShield(
                'Unknown shield code ' . ValueDescriber::describe($shieldCode)
            );
        }
    }

    /**
     * @param string $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownShield
     */
    public function getLengthOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::LENGTH);
    }

    /**
     * @param string $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownShield
     */
    public function getRestrictionOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::RESTRICTION);
    }

    /**
     * @param string $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownShield
     */
    public function getOffensivenessOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::OFFENSIVENESS);
    }

    /**
     * @param string $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownShield
     */
    public function getWoundsOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::WOUNDS);
    }

    /**
     * @param string $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownShield
     */
    public function getWoundsTypeOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::WOUNDS_TYPE);
    }

    /**
     * @param string $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownShield
     */
    public function getCoverOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::COVER);
    }

    /**
     * @param string $shieldCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownShield
     */
    public function getWeightOf($shieldCode)
    {
        return $this->getValueOf($shieldCode, self::WEIGHT);
    }

    /**
     * @param string $weaponlikeCode
     * @return bool
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownShield
     */
    public function getTwoHandedOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::TWO_HANDED);
    }

}