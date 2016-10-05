<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface StrengthSanctionsInterface
{
    /**
     * @param int $missingStrength
     * @return bool
     */
    public function canUseIt($missingStrength);
}