<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Armaments\Weapons\Melee\Partials;

use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\Armaments\WeaponCategoryCode;
use DrdPlus\Codes\Body\WoundTypeCode;
use DrdPlus\Properties\Body\WeightInKg;
use DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeapon;
use DrdPlus\Tables\Armaments\Partials\AbstractArmamentsTable;
use DrdPlus\Tables\Armaments\Partials\MeleeWeaponlikesTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound;
use Granam\Scalar\Tools\ToString;
use Granam\String\StringInterface;
use Granam\Tools\ValueDescriber;

abstract class MeleeWeaponsTable extends AbstractArmamentsTable implements MeleeWeaponlikesTable
{

    private $customMeleeWeapons = [];

    protected function getRowsHeader(): array
    {
        return ['weapon'];
    }

    protected function getExpectedDataHeaderNamesToTypes(): array
    {
        return [
            self::REQUIRED_STRENGTH => self::INTEGER,
            self::LENGTH => self::INTEGER,
            self::OFFENSIVENESS => self::INTEGER,
            self::WOUNDS => self::INTEGER,
            self::WOUNDS_TYPE => self::STRING,
            self::COVER => self::INTEGER,
            self::WEIGHT => self::FLOAT,
            self::TWO_HANDED_ONLY => self::BOOLEAN,
        ];
    }

    /**
     * @param MeleeWeaponCode $meleeWeaponCode
     * @param WeaponCategoryCode $meleeWeaponCategoryCode
     * @param int $requiredStrength
     * @param int $lengthInMeters
     * @param int $offensiveness
     * @param int $wounds
     * @param WoundTypeCode $woundTypeCode
     * @param int $cover
     * @param WeightInKg $weightInKg
     * @param bool $twoHandedOnly
     * @throws \DrdPlus\Tables\Armaments\Weapons\Melee\Partials\Exceptions\NewMeleeWeaponIsNotOfRequiredType
     */
    public function addNewMeleeWeapon(
        MeleeWeaponCode $meleeWeaponCode,
        WeaponCategoryCode $meleeWeaponCategoryCode,
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
        /** like @see MeleeWeaponCode::isAxe() */
        $isType = 'is' . ucfirst($meleeWeaponCategoryCode->getValue());
        /** like @see MeleeWeaponCode::getAxeCodes() */
        $getTypeCodes = 'get' . ucfirst($meleeWeaponCategoryCode->getValue()) . 'Codes';
        if (!is_callable([$meleeWeaponCode, $isType]) || !$meleeWeaponCode->$isType()
            || !is_callable(get_class($meleeWeaponCode) . '::' . $getTypeCodes)
            || !in_array($meleeWeaponCode->getValue(), $meleeWeaponCode::$getTypeCodes(), true)
        ) {
            throw new Exceptions\NewMeleeWeaponIsNotOfRequiredType(
                "Expected new melee weapon to be '$meleeWeaponCategoryCode' type, got '{$meleeWeaponCode}'"
                . " with $meleeWeaponCategoryCode type values " . implode(',', $meleeWeaponCode::$getTypeCodes())
                . ' and all possible values ' . implode(',', $meleeWeaponCode::getPossibleValues())
            );
        }
        // TODO check conflicts
        $this->customMeleeWeapons[$meleeWeaponCode->getValue()] = [
            self::REQUIRED_STRENGTH => $requiredStrength,
            self::LENGTH => $lengthInMeters,
            self::OFFENSIVENESS => $offensiveness,
            self::WOUNDS => $wounds,
            self::WOUNDS_TYPE => $woundTypeCode,
            self::COVER => $cover,
            self::WEIGHT => $weightInKg,
            self::TWO_HANDED_ONLY => $twoHandedOnly,
        ];
    }

    /**
     * @param string|StringInterface $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeapon
     */
    public function getOffensivenessOf($weaponlikeCode): int
    {
        return $this->getValueOf($weaponlikeCode, self::OFFENSIVENESS);
    }

    /**
     * @param string|StringInterface $weaponlikeCode
     * @param string $valueName
     * @return float|int|string|bool
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeapon
     */
    private function getValueOf($weaponlikeCode, string $valueName)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->customMeleeWeapons[ToString::toString($weaponlikeCode)][$valueName]
            ?? $this->getStandardValueOf($weaponlikeCode, $valueName);
    }

    /**
     * @param string|StringInterface $weaponlikeCode
     * @param string $valueName
     * @return float|int|string|false
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeapon
     */
    private function getStandardValueOf($weaponlikeCode, string $valueName)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->getValue([$weaponlikeCode], $valueName);
        } catch (RequiredRowNotFound $exception) {
            throw new UnknownMeleeWeapon(
                'Unknown weapon code ' . ValueDescriber::describe($weaponlikeCode)
            );
        }
    }

    /**
     * @param string|StringInterface $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeapon
     */
    public function getWoundsOf($weaponlikeCode): int
    {
        return $this->getValueOf($weaponlikeCode, self::WOUNDS);
    }

    /**
     * @param string|StringInterface $weaponlikeCode
     * @return string
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeapon
     */
    public function getWoundsTypeOf($weaponlikeCode): string
    {
        return $this->getValueOf($weaponlikeCode, self::WOUNDS_TYPE);
    }

    /**
     * @param string|StringInterface $weaponlikeCode
     * @return int|false
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeapon
     */
    public function getRequiredStrengthOf($weaponlikeCode)
    {
        return $this->getValueOf($weaponlikeCode, self::REQUIRED_STRENGTH);
    }

    /**
     * @param string|StringInterface $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeapon
     */
    public function getLengthOf($weaponlikeCode): int
    {
        return $this->getValueOf($weaponlikeCode, self::LENGTH);
    }

    /**
     * @param string|StringInterface $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeapon
     */
    public function getCoverOf($weaponlikeCode): int
    {
        return $this->getValueOf($weaponlikeCode, self::COVER);
    }

    /**
     * @param string|StringInterface $weaponlikeCode
     * @return float
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeapon
     */
    public function getWeightOf($weaponlikeCode): float
    {
        return $this->getValueOf($weaponlikeCode, self::WEIGHT);
    }

    /**
     * @param string|StringInterface $weaponlikeCode
     * @return bool
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeapon
     */
    public function getTwoHandedOnlyOf($weaponlikeCode): bool
    {
        return $this->getValueOf($weaponlikeCode, self::TWO_HANDED_ONLY);
    }

}