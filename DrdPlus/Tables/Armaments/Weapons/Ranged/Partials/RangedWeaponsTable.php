<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Armaments\Weapons\Ranged\Partials;

use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Codes\Armaments\WeaponCategoryCode;
use DrdPlus\Codes\Body\WoundTypeCode;
use DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon;
use DrdPlus\Tables\Armaments\Partials\AbstractArmamentsTable;
use DrdPlus\Tables\Armaments\Partials\WeaponlikeTable;
use DrdPlus\Tables\Measurements\Distance\DistanceBonus;
use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound;
use Granam\Scalar\Tools\ToString;
use Granam\String\StringInterface;
use Granam\String\StringTools;
use Granam\Tools\ValueDescriber;

abstract class RangedWeaponsTable extends AbstractArmamentsTable implements WeaponlikeTable
{
    const RANGE = 'range';
    const WEAPON = 'weapon';

    private $customRangedWeapons = [];

    /**
     * @return array|string[]
     */
    protected function getRowsHeader(): array
    {
        return [self::WEAPON];
    }

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes(): array
    {
        return [
            self::REQUIRED_STRENGTH => self::INTEGER,
            self::OFFENSIVENESS => self::INTEGER,
            self::WOUNDS => self::INTEGER,
            self::WOUNDS_TYPE => self::STRING,
            self::RANGE => self::INTEGER,
            self::COVER => self::INTEGER,
            self::WEIGHT => self::FLOAT,
            self::TWO_HANDED_ONLY => self::BOOLEAN,
        ];
    }

    /**
     * @param RangedWeaponCode $rangedWeaponCode
     * @param WeaponCategoryCode $rangedWeaponCategoryCode
     * @param int $requiredStrength
     * @param DistanceBonus $range
     * @param int $offensiveness
     * @param int $wounds
     * @param WoundTypeCode $woundTypeCode
     * @param int $cover
     * @param Weight $weight
     * @param bool $twoHandedOnly
     * @throws \DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\Exceptions\NewRangedWeaponIsNotOfRequiredType
     * @throws \DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\Exceptions\DifferentRangedWeaponIsUnderSameName
     */
    public function addNewRangedWeapon(
        RangedWeaponCode $rangedWeaponCode,
        WeaponCategoryCode $rangedWeaponCategoryCode,
        int $requiredStrength,
        DistanceBonus $range,
        int $offensiveness,
        int $wounds,
        WoundTypeCode $woundTypeCode,
        int $cover,
        Weight $weight,
        bool $twoHandedOnly
    )
    {
        /** like @see RangedWeaponCode::isBow() */
        $isType = StringTools::assembleMethodName(
            str_replace('_and_', '_or_', $rangedWeaponCategoryCode->getValue()),
            'is'
        );
        /** like @see RangedWeaponCode::getBowValues() */
        $getTypeCodes = StringTools::assembleGetterForName($rangedWeaponCategoryCode->getValue()) . 'Values';
        if (!is_callable([$rangedWeaponCode, $isType]) || !$rangedWeaponCode->$isType()
            || !is_callable(get_class($rangedWeaponCode) . '::' . $getTypeCodes)
            || !in_array($rangedWeaponCode->getValue(), $rangedWeaponCode::$getTypeCodes(), true)
        ) {
            throw new Exceptions\NewRangedWeaponIsNotOfRequiredType(
                "Expected new ranged weapon to be '$rangedWeaponCategoryCode' type, got {$rangedWeaponCode}"
                . " with $rangedWeaponCode type values " . implode(',', $rangedWeaponCode::$getTypeCodes())
                . ' and all possible values ' . var_export($rangedWeaponCode::getPossibleValues(), true)
            );
        }
        $newRangedWeapon = [
            self::REQUIRED_STRENGTH => $requiredStrength,
            self::OFFENSIVENESS => $offensiveness,
            self::RANGE => $range->getValue(), // distance bonus in fact
            self::WOUNDS => $wounds,
            self::WOUNDS_TYPE => $woundTypeCode->getValue(),
            self::COVER => $cover,
            self::WEIGHT => $weight->getKilograms(),
            self::TWO_HANDED_ONLY => $twoHandedOnly,
        ];
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $previousRangedWeapon = $this->findRow($rangedWeaponCode);
        if ($previousRangedWeapon && $newRangedWeapon !== $previousRangedWeapon) {
            throw new Exceptions\DifferentRangedWeaponIsUnderSameName(
                "New ranged weapon {$rangedWeaponCode} can not be added as there is already a weapon under same name"
                . ' but with different parameters: '
                . ValueDescriber::describe(array_diff_assoc($previousRangedWeapon, $newRangedWeapon))
            );
        }
        $this->customRangedWeapons[$rangedWeaponCode->getValue()] = $newRangedWeapon;
    }

    /**
     * @param string|StringInterface $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    public function getOffensivenessOf($weaponlikeCode): int
    {
        return $this->getValueOf($weaponlikeCode, self::OFFENSIVENESS);
    }

    /**
     * @param string|StringInterface $rangedWeaponCode
     * @param string $valueName
     * @return float|int|string|bool
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    protected function getValueOf($rangedWeaponCode, string $valueName)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->customRangedWeapons[ToString::toString($rangedWeaponCode)][$valueName]
            ?? $this->getStandardValueOf($rangedWeaponCode, $valueName);
    }

    /**
     * @param string|StringInterface|RangedWeaponCode $rangedWeaponCode
     * @param string $valueName
     * @return float|int|string|bool
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    private function getStandardValueOf($rangedWeaponCode, string $valueName)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->getValue([$rangedWeaponCode], $valueName);
        } catch (RequiredRowNotFound $exception) {
            throw new UnknownRangedWeapon(
                'Unknown ranged armament code ' . ValueDescriber::describe($rangedWeaponCode)
            );
        }
    }

    /**
     * @param string|StringInterface $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    public function getWoundsOf($weaponlikeCode): int
    {
        return $this->getValueOf($weaponlikeCode, self::WOUNDS);
    }

    /**
     * @param string|StringInterface $weaponlikeCode
     * @return string
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    public function getWoundsTypeOf($weaponlikeCode): string
    {
        return $this->getValueOf($weaponlikeCode, self::WOUNDS_TYPE);
    }

    /**
     * @param string|StringInterface $weaponlikeCode
     * @return int|false
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    public function getRequiredStrengthOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::REQUIRED_STRENGTH);
    }

    /**
     * @param string|StringInterface $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    public function getRangeOf($weaponlikeCode): int
    {
        return $this->getValueOf($weaponlikeCode, self::RANGE);
    }

    /**
     * Every ranged weapon is considered as with cover of 2 (projectiles 0), see PPH page 94, right column
     *
     * @param string|StringInterface $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    public function getCoverOf($weaponlikeCode): int
    {
        return $this->getValueOf($weaponlikeCode, self::COVER);
    }

    /**
     * @param string|StringInterface $weaponlikeCode
     * @return float
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    public function getWeightOf($weaponlikeCode): float
    {
        return $this->getValueOf($weaponlikeCode, self::WEIGHT);
    }

    /**
     * @param string|StringInterface $weaponlikeCode
     * @return bool
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    public function getTwoHandedOnlyOf($weaponlikeCode): bool
    {
        return $this->getValueOf($weaponlikeCode, self::TWO_HANDED_ONLY);
    }
}