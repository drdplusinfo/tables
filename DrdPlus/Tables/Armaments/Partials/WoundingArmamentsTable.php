<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Armaments\Partials;

use Granam\String\StringInterface;

interface WoundingArmamentsTable extends BearablesTable
{
    const OFFENSIVENESS = 'offensiveness';

    /**
     * @param string|StringInterface $weaponlikeCode
     * @return int
     */
    public function getOffensivenessOf($weaponlikeCode): int;

    const WOUNDS = 'wounds';

    /**
     * @param string|StringInterface $weaponlikeCode
     * @return int
     */
    public function getWoundsOf($weaponlikeCode): int;

    const WOUNDS_TYPE = 'wounds_type';

    /**
     * @param string|StringInterface $weaponlikeCode
     * @return string
     */
    public function getWoundsTypeOf($weaponlikeCode): string;
}