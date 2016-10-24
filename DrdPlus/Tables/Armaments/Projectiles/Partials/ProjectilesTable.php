<?php
namespace DrdPlus\Tables\Armaments\Projectiles\Partials;

use DrdPlus\Codes\Armaments\ProjectileCode;
use DrdPlus\Tables\Armaments\Exceptions\UnknownProjectile;
use DrdPlus\Tables\Armaments\Partials\AbstractArmamentsTable;
use DrdPlus\Tables\Armaments\Partials\WoundingArmamentsTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound;
use Granam\String\StringInterface;
use Granam\Tools\ValueDescriber;

/**
 * Note: Every projectile considered as with cover of 0 (if you are so despair you have to cover by a sling stone for
 * example).
 */
abstract class ProjectilesTable extends AbstractArmamentsTable implements WoundingArmamentsTable
{
    const RANGE = 'range';

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::OFFENSIVENESS => self::INTEGER,
            self::WOUNDS => self::INTEGER,
            self::WOUNDS_TYPE => self::STRING,
            self::RANGE => self::INTEGER,
            self::WEIGHT => self::FLOAT,
        ];
    }

    protected function getRowsHeader()
    {
        return ['projectile'];
    }

    /**
     * @param string $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownProjectile
     */
    public function getOffensivenessOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::OFFENSIVENESS);
    }

    /**
     * @param string|StringInterface|ProjectileCode $projectileCode
     * @param string $valueName
     * @return float|int|string|bool
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownProjectile
     */
    protected function getValueOf($projectileCode, $valueName)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->getValue([$projectileCode], $valueName);
        } catch (RequiredRowNotFound $exception) {
            throw new UnknownProjectile(
                'Unknown projectile code ' . ValueDescriber::describe((string)$projectileCode)
            );
        }
    }

    /**
     * @param string $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownProjectile
     */
    public function getWoundsOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::WOUNDS);
    }

    /**
     * @param string $weaponlikeCode
     * @return string
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownProjectile
     */
    public function getWoundsTypeOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::WOUNDS_TYPE);
    }

    /**
     * @param string $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownProjectile
     */
    public function getRangeOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::RANGE);
    }

    /**
     * @param string $weaponlikeCode
     * @return float
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownProjectile
     */
    public function getWeightOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::WEIGHT);
    }

}