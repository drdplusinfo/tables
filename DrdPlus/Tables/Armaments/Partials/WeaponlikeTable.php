<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface WeaponlikeTable extends WearablesTable
{
    const OFFENSIVENESS = 'offensiveness';

    /**
     * @param string $weaponlikeCode
     * @return int
     */
    public function getOffensivenessOf($weaponlikeCode);

    const WOUNDS = 'wounds';

    /**
     * @param string $weaponlikeCode
     * @return int
     */
    public function getWoundsOf($weaponlikeCode);

    const WOUNDS_TYPE = 'wounds_type';

    /**
     * @param string $weaponlikeCode
     * @return string
     */
    public function getWoundsTypeOf($weaponlikeCode);

    const COVER = 'cover';

    /**
     * @param string $weaponlikeCode
     * @return int
     */
    public function getCoverOf($weaponlikeCode);

    const TWO_HANDED = 'two_handed';

    /**
     * @param $itemCode
     * @return bool
     */
    public function getTwoHandedOf($itemCode);
}