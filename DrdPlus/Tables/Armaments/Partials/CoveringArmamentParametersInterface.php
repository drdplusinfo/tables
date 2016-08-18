<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface CoveringArmamentParametersInterface extends WeaponParametersInterface
{
    const COVER = 'cover';

    /**
     * @param string $armamentCode
     * @return int
     */
    public function getCoverOf($armamentCode);
}