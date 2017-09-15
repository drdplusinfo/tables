<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tests\Tables\Armaments\Weapons\Ranged\Partials;

use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Codes\Armaments\WeaponCategoryCode;
use DrdPlus\Codes\Body\WoundTypeCode;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTable;
use DrdPlus\Tables\Measurements\Distance\DistanceBonus;
use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Tables;
use DrdPlus\Tests\Tables\Armaments\Partials\WeaponlikeTableTest;
use Granam\String\StringTools;

abstract class RangedWeaponsTableTest extends WeaponlikeTableTest
{

    /**
     * @return string
     */
    abstract protected function getRowHeaderName(): string;

    /**
     * @test
     * @dataProvider provideValueName
     * @param string $valueName
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     * @expectedExceptionMessageRegExp ~skull_crasher~
     */
    public function I_can_not_get_value_of_unknown_melee_weapon(string $valueName)
    {
        $getValueNameOf = $this->assembleValueGetter($valueName);
        $sutClass = self::getSutClass();
        /** @var RangedWeaponsTable $shootingArmamentsTable */
        $shootingArmamentsTable = new $sutClass();
        $shootingArmamentsTable->$getValueNameOf('skull_crasher');
    }

    public function provideValueName()
    {
        return [
            [RangedWeaponsTable::REQUIRED_STRENGTH],
            [RangedWeaponsTable::OFFENSIVENESS],
            [RangedWeaponsTable::WOUNDS],
            [RangedWeaponsTable::WOUNDS_TYPE],
            [RangedWeaponsTable::RANGE],
            [RangedWeaponsTable::COVER],
            [RangedWeaponsTable::WEIGHT],
            [RangedWeaponsTable::TWO_HANDED_ONLY],
        ];
    }

    /**
     * @test
     */
    public function I_can_add_new_ranged_weapon()
    {
        $sut = $this->createSut();
        $name = uniqid('cannot', true);
        RangedWeaponCode::addNewRangedWeaponCode($name, $this->getRangedWeaponCategory(), []);
        $cannot = RangedWeaponCode::getIt($name);
        $sut->addNewRangedWeapon(
            $cannot,
            $this->getRangedWeaponCategory(),
            $requiredStrength = Strength::getIt(5),
            $range = new DistanceBonus(1, Tables::getIt()->getDistanceTable()),
            $offensiveness = 4,
            $wounds = 3,
            $woundTypeCode = WoundTypeCode::getIt(WoundTypeCode::STAB),
            $cover = 2,
            $weight = new Weight(5, Weight::KG, Tables::getIt()->getWeightTable()),
            $twoHandedOnly = true
        );
        self::assertSame($requiredStrength->getValue(), $sut->getRequiredStrengthOf($cannot));
        self::assertSame($range->getValue(), $sut->getRangeOf($cannot));
        self::assertSame($offensiveness, $sut->getOffensivenessOf($cannot));
        self::assertSame($wounds, $sut->getWoundsOf($cannot));
        self::assertSame($woundTypeCode->getValue(), $sut->getWoundsTypeOf($cannot));
        self::assertSame($cover, $sut->getCoverOf($cannot));
        self::assertSame($weight->getKilograms(), $sut->getWeightOf($cannot));
        self::assertSame($twoHandedOnly, $sut->getTwoHandedOnlyOf($cannot));
    }

    protected function createSut(): RangedWeaponsTable
    {
        $sutClass = self::getSutClass();

        return new $sutClass();
    }

    private $weaponCategory;

    private function getRangedWeaponCategory(): WeaponCategoryCode
    {
        if ($this->weaponCategory === null) {
            $sutClass = static::getSutClass();
            $basename = preg_replace('~^.+\\\([^\\\]+)$~', '$1', $sutClass);
            $keyword = preg_replace('~Table$~', '', $basename);
            $categoryName = StringTools::camelCaseToSnakeCasedBasename($keyword);
            $singular = rtrim(str_replace('s_', '_', $categoryName), 's');

            $this->weaponCategory = WeaponCategoryCode::getIt($singular);
        }

        return $this->weaponCategory;
    }

    /**
     * @test
     */
    public function I_can_add_new_ranged_weapon_by_specific_method()
    {
        $sut = $this->createSut();
        $name = uniqid('nailer', true);
        $addNew = StringTools::assembleMethodName(
            str_replace('_and_', '_or_', $this->getRangedWeaponCategory()->getValue()),
            'addNew'
        );
        RangedWeaponCode::addNewRangedWeaponCode($name, $this->getRangedWeaponCategory(), []);
        $nailer = RangedWeaponCode::getIt($name);
        $sut->$addNew(
            $nailer,
            $requiredStrength = Strength::getIt(9),
            $range = new DistanceBonus(123, Tables::getIt()->getDistanceTable()),
            $offensiveness = 2,
            $wounds = 3,
            $woundTypeCode = WoundTypeCode::getIt(WoundTypeCode::CUT),
            $cover = 4,
            $weight = new Weight(5, Weight::KG, Tables::getIt()->getWeightTable()),
            $twoHandedOnly = false
        );
        self::assertSame($requiredStrength->getValue(), $sut->getRequiredStrengthOf($nailer));
        self::assertSame($range->getValue(), $sut->getRangeOf($nailer));
        self::assertSame($offensiveness, $sut->getOffensivenessOf($nailer));
        self::assertSame($wounds, $sut->getWoundsOf($nailer));
        self::assertSame($woundTypeCode->getValue(), $sut->getWoundsTypeOf($nailer));
        self::assertSame($cover, $sut->getCoverOf($nailer));
        self::assertSame($weight->getKilograms(), $sut->getWeightOf($nailer));
        self::assertSame($twoHandedOnly, $sut->getTwoHandedOnlyOf($nailer));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Exceptions\NewWeaponIsNotOfRequiredType
     * @expectedExceptionMessageRegExp ~sword.+cake~
     */
    public function I_can_not_add_new_melee_weapon_with_unexpected_category()
    {
        $sut = $this->createSut();
        $name = uniqid('cake', true);
        RangedWeaponCode::addNewRangedWeaponCode($name, $this->getRangedWeaponCategory(), []);
        $cake = RangedWeaponCode::getIt($name);
        $sut->addNewRangedWeapon(
            $cake,
            WeaponCategoryCode::getIt(WeaponCategoryCode::SWORD), // intentionally melee
            $requiredStrength = Strength::getIt(0),
            $range = new DistanceBonus(123, Tables::getIt()->getDistanceTable()),
            $offensiveness = 2,
            $wounds = 3,
            $woundTypeCode = WoundTypeCode::getIt(WoundTypeCode::CUT),
            $cover = 4,
            $weight = new Weight(5, Weight::KG, Tables::getIt()->getWeightTable()),
            $twoHandedOnly = false
        );
    }

    /**
     * @test
     * @dataProvider provideNewWeaponSlightlyChangedParameters
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Exceptions\DifferentWeaponIsUnderSameName
     * @param $templateRequiredStrength
     * @param DistanceBonus $templateRange
     * @param $templateOffensiveness
     * @param $templateWounds
     * @param WoundTypeCode $templateWoundTypeCode
     * @param $templateCover
     * @param $templateWeight
     * @param bool $templateTwoHandedOnly
     * @param $requiredStrength
     * @param DistanceBonus $range
     * @param $offensiveness
     * @param $wounds
     * @param WoundTypeCode $woundTypeCode
     * @param $cover
     * @param $weight
     * @param bool $twoHandedOnly
     */
    public function I_can_not_add_same_named_weapon_with_different_parameters(
        $templateRequiredStrength,
        $templateRange,
        $templateOffensiveness,
        $templateWounds,
        $templateWoundTypeCode,
        $templateCover,
        $templateWeight,
        $templateTwoHandedOnly,
        $requiredStrength,
        $range,
        $offensiveness,
        $wounds,
        $woundTypeCode,
        $cover,
        $weight,
        $twoHandedOnly
    )
    {
        $sut = $this->createSut();
        $name = 'hailstone_' . static::getSutClass(); // unique per SUT
        $addNew = StringTools::assembleMethodName(
            str_replace('_and_', '_or_', $this->getRangedWeaponCategory()->getValue()),
            'addNew'
        );
        RangedWeaponCode::addNewRangedWeaponCode($name, $this->getRangedWeaponCategory(), []);
        $hailstone = RangedWeaponCode::getIt($name);
        $sut->$addNew(
            $hailstone,
            Strength::getIt($templateRequiredStrength),
            $templateRange,
            $templateOffensiveness,
            $templateWounds,
            $templateWoundTypeCode,
            $templateCover,
            $templateWeight,
            $templateTwoHandedOnly
        );
        $sut->$addNew($hailstone, Strength::getIt($requiredStrength), $range, $offensiveness, $wounds, $woundTypeCode, $cover, $weight, $twoHandedOnly);
    }

    public function provideNewWeaponSlightlyChangedParameters(): array
    {
        $template = [
            'requiredStrength' => 0,
            'range' => new DistanceBonus(1, Tables::getIt()->getDistanceTable()),
            'offensiveness' => 2,
            'wounds' => 3,
            'woundTypeCode' => WoundTypeCode::getIt(WoundTypeCode::STAB),
            'cover' => 4,
            'weight' => new Weight(5, Weight::KG, Tables::getIt()->getWeightTable()),
            'twoHandedOnly' => false,
        ];
        $templateValues = array_values($template);

        return [
            array_merge($templateValues, array_values(array_merge($template, ['requiredStrength' => $template['requiredStrength'] + 1]))),
            array_merge($templateValues, array_values(array_merge($template, ['range' => new DistanceBonus(2, Tables::getIt()->getDistanceTable())]))),
            array_merge($templateValues, array_values(array_merge($template, ['offensiveness' => $template['offensiveness'] - 1]))),
            array_merge($templateValues, array_values(array_merge($template, ['wounds' => $template['wounds'] - 1]))),
            array_merge($templateValues, array_values(array_merge($template, ['wounds' => $template['wounds'] - 1]))),
            array_merge($templateValues, array_values(array_merge($template, ['woundTypeCode' => WoundTypeCode::getIt(WoundTypeCode::CRUSH)]))),
            array_merge($templateValues, array_values(array_merge($template, ['cover' => $template['cover'] + 2]))),
            array_merge($templateValues, array_values(array_merge($template, ['weight' => new Weight(3, Weight::KG, Tables::getIt()->getWeightTable())]))),
            array_merge($templateValues, array_values(array_merge($template, ['twoHandedOnly' => !$template['twoHandedOnly']]))),
        ];
    }

}