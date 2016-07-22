<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface WeaponParametersInterface extends WearableParametersInterface
{
    const OFFENSIVENESS = 'offensiveness';

    /**
     * @param string $weaponCode
     * @return int
     */
    public function getOffensivenessOf($weaponCode);

    const WOUNDS = 'wounds';

    /**
     * @param string $weaponCode
     * @return int
     */
    public function getWoundsOf($weaponCode);

    const WOUNDS_TYPE = 'wounds_type';

    /**
     * @param string $weaponCode
     * @return string
     */
    public function getWoundsTypeOf($weaponCode);
}