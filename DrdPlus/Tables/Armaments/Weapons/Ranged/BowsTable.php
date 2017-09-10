<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Armaments\Weapons\Ranged;

use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Codes\Armaments\WeaponCategoryCode;
use DrdPlus\Codes\Body\WoundTypeCode;
use DrdPlus\Properties\Body\WeightInKg;
use DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon;
use DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTable;
use Granam\String\StringInterface;

/**
 * See PPH page 88 right column, @link https://pph.drdplus.info/#tabulka_strelnych_a_vrhacich_zbrani
 */
class BowsTable extends RangedWeaponsTable
{
    /**
     * @return string
     */
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/bows.csv';
    }

    const MAXIMAL_APPLICABLE_STRENGTH = 'maximal_applicable_strength';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes(): array
    {
        return [
            self::REQUIRED_STRENGTH => self::INTEGER,
            self::MAXIMAL_APPLICABLE_STRENGTH => self::POSITIVE_INTEGER,
            self::OFFENSIVENESS => self::INTEGER,
            self::WOUNDS => self::INTEGER,
            self::WOUNDS_TYPE => self::STRING,
            self::RANGE => self::POSITIVE_INTEGER,
            self::COVER => self::POSITIVE_INTEGER,
            self::WEIGHT => self::FLOAT,
            self::TWO_HANDED_ONLY => self::BOOLEAN,
        ];
    }

    /**
     * @param string|StringInterface|RangedWeaponCode $bowCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Ranged\Exceptions\UnknownBow
     */
    public function getMaximalApplicableStrengthOf($bowCode): int
    {
        try {
            return $this->getValueOf($bowCode, self::MAXIMAL_APPLICABLE_STRENGTH);
        } catch (UnknownRangedWeapon $unknownRangedWeapon) {
            throw new Exceptions\UnknownBow("Unknown bow '{$bowCode}'");
        }
    }

    /**
     * @param RangedWeaponCode $bowCode you need a code even for a custom weapon, so prove now
     * @param int $requiredStrength
     * @param int $lengthInMeters
     * @param int $offensiveness
     * @param int $wounds
     * @param WoundTypeCode $woundTypeCode
     * @param int $cover
     * @param WeightInKg $weightInKg
     * @param bool $twoHandedOnly
     * @throws \DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\Exceptions\NewRangedWeaponIsNotOfRequiredType
     */
    public function addNewBow(
        RangedWeaponCode $bowCode,
        int $requiredStrength,
        int $lengthInMeters,
        int $offensiveness,
        int $wounds,
        WoundTypeCode $woundTypeCode,
        int $cover,
        WeightInKg $weightInKg,
        bool $twoHandedOnly
    )
    {
        $this->addNewRangedWeapon(
            $bowCode,
            WeaponCategoryCode::getIt(WeaponCategoryCode::BOW),
            $requiredStrength,
            $lengthInMeters,
            $offensiveness,
            $wounds,
            $woundTypeCode,
            $cover,
            $weightInKg,
            $twoHandedOnly
        );
    }
}