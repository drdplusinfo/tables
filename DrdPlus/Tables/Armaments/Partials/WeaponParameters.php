<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface WeaponParameters extends WearableParameters
{
    /**
     * @param string $weaponCode
     * @return int
     */
    public function getOffensivenessOf($weaponCode);

    /**
     * @param string $weaponCode
     * @return int
     */
    public function getWoundsOf($weaponCode);

    /**
     * @param string $weaponCode
     * @return string
     */
    public function getWoundsTypeOf($weaponCode);
}