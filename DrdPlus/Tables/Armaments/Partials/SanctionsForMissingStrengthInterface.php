<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface SanctionsForMissingStrengthInterface
{
    /**
     * @param int $missingStrength
     * @return bool
     */
    public function canUseIt($missingStrength);
}