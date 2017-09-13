<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tests\Tables\Armaments\Weapons\Ranged\Partials;

use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Codes\Armaments\WeaponCategoryCode;
use DrdPlus\Codes\Body\WoundTypeCode;
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
            $requiredStrength = 5,
            $range = new DistanceBonus(1, Tables::getIt()->getDistanceTable()),
            $offensiveness = 4,
            $wounds = 3,
            $woundTypeCode = WoundTypeCode::getIt(WoundTypeCode::STAB),
            $cover = 2,
            $weight = new Weight(5, Weight::KG, Tables::getIt()->getWeightTable()),
            $twoHandedOnly = true
        );
        self::assertSame($requiredStrength, $sut->getRequiredStrengthOf($cannot));
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
    public function I_can_add_new_melee_weapon_by_specific_method()
    {
        $sut = $this->createSut();
        $name = uniqid('crasher', true);
        $addNew = StringTools::assembleMethodName(
            str_replace('_and_', '_or_', $this->getRangedWeaponCategory()->getValue()),
            'addNew'
        );
        RangedWeaponCode::addNewRangedWeaponCode($name, $this->getRangedWeaponCategory(), []);
        $nailer = RangedWeaponCode::getIt($name);
        $sut->$addNew(
            $nailer,
            $requiredStrength = 0,
            $range = new DistanceBonus(123, Tables::getIt()->getDistanceTable()),
            $offensiveness = 2,
            $wounds = 3,
            $woundTypeCode = WoundTypeCode::getIt(WoundTypeCode::CUT),
            $cover = 4,
            $weight = new Weight(5, Weight::KG, Tables::getIt()->getWeightTable()),
            $twoHandedOnly = false
        );
        self::assertSame($requiredStrength, $sut->getRequiredStrengthOf($nailer));
        self::assertSame($range->getValue(), $sut->getRangeOf($nailer));
        self::assertSame($offensiveness, $sut->getOffensivenessOf($nailer));
        self::assertSame($wounds, $sut->getWoundsOf($nailer));
        self::assertSame($woundTypeCode->getValue(), $sut->getWoundsTypeOf($nailer));
        self::assertSame($cover, $sut->getCoverOf($nailer));
        self::assertSame($weight->getKilograms(), $sut->getWeightOf($nailer));
        self::assertSame($twoHandedOnly, $sut->getTwoHandedOnlyOf($nailer));
    }
}