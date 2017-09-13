<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials;

use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\Armaments\WeaponCategoryCode;
use DrdPlus\Codes\Body\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;
use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Tables;
use DrdPlus\Tests\Tables\Armaments\Partials\WeaponlikeTableTest;
use Granam\String\StringTools;

abstract class MeleeWeaponsTableTest extends WeaponlikeTableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $meleeWeaponsTable = $this->createSut();
        self::assertSame(
            [['weapon', 'required_strength', 'length', 'offensiveness', 'wounds', 'wounds_type', 'cover', 'weight', 'two_handed_only']],
            $meleeWeaponsTable->getHeader()
        );
    }

    protected function createSut(): MeleeWeaponsTable
    {
        $sutClass = self::getSutClass();

        return new $sutClass();
    }

    /**
     * @test
     * @dataProvider provideValueName
     * @param string $valueName
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeapon
     * @expectedExceptionMessageRegExp ~skull_crasher~
     */
    public function I_can_not_get_value_of_unknown_melee_weapon($valueName)
    {
        $getValueNameOf = $this->assembleValueGetter($valueName);
        $meleeWeaponsTable = $this->createSut();
        $meleeWeaponsTable->$getValueNameOf('skull_crasher');
    }

    public function provideValueName()
    {
        return [
            [MeleeWeaponsTable::REQUIRED_STRENGTH],
            [MeleeWeaponsTable::LENGTH],
            [MeleeWeaponsTable::OFFENSIVENESS],
            [MeleeWeaponsTable::WOUNDS],
            [MeleeWeaponsTable::WOUNDS_TYPE],
            [MeleeWeaponsTable::COVER],
            [MeleeWeaponsTable::WEIGHT],
        ];
    }

    /**
     * @test
     */
    abstract public function I_can_get_every_weapon_by_weapon_codes_library();

    /**
     * @test
     */
    public function I_can_add_new_melee_weapon()
    {
        $sut = $this->createSut();
        $name = uniqid('chopa', true);
        MeleeWeaponCode::addNewMeleeWeaponCode($name, $this->getMeleeWeaponCategory(), []);
        $chopa = MeleeWeaponCode::getIt($name);
        $sut->addNewMeleeWeapon(
            $chopa,
            $this->getMeleeWeaponCategory(),
            $requiredStrength = 0,
            $weaponLength = 1,
            $offensiveness = 2,
            $wounds = 3,
            $woundTypeCode = WoundTypeCode::getIt(WoundTypeCode::CUT),
            $cover = 4,
            $weight = new Weight(5, Weight::KG, Tables::getIt()->getWeightTable()),
            $twoHandedOnly = false
        );
        self::assertSame($requiredStrength, $sut->getRequiredStrengthOf($chopa));
        self::assertSame($weaponLength, $sut->getLengthOf($chopa));
        self::assertSame($offensiveness, $sut->getOffensivenessOf($chopa));
        self::assertSame($wounds, $sut->getWoundsOf($chopa));
        self::assertSame($woundTypeCode->getValue(), $sut->getWoundsTypeOf($chopa));
        self::assertSame($cover, $sut->getCoverOf($chopa));
        self::assertSame($weight->getKilograms(), $sut->getWeightOf($chopa));
        self::assertSame($twoHandedOnly, $sut->getTwoHandedOnlyOf($chopa));
    }

    private $meleeWeaponCategory;

    private function getMeleeWeaponCategory(): WeaponCategoryCode
    {
        if ($this->meleeWeaponCategory === null) {
            $sutClass = static::getSutClass();
            $basename = preg_replace('~^.+\\\([^\\\]+)$~', '$1', $sutClass);
            $keyword = preg_replace('~Table$~', '', $basename);
            $categoryName = StringTools::camelCaseToSnakeCasedBasename($keyword);
            $singular = rtrim(str_replace('s_', '_', $categoryName), 's');

            $this->meleeWeaponCategory = WeaponCategoryCode::getIt($singular);
        }

        return $this->meleeWeaponCategory;
    }

    /**
     * @test
     */
    public function I_can_add_new_melee_weapon_by_specific_method()
    {
        $sut = $this->createSut();
        $name = uniqid('crasher', true);
        $addNew = StringTools::assembleMethodName(
            str_replace('_and_', '_or_', $this->getMeleeWeaponCategory()->getValue()),
            'addNew'
        );
        MeleeWeaponCode::addNewMeleeWeaponCode($name, $this->getMeleeWeaponCategory(), []);
        $crasher = MeleeWeaponCode::getIt($name);
        $sut->$addNew(
            $crasher,
            $requiredStrength = 0,
            $weaponLength = 1,
            $offensiveness = 2,
            $wounds = 3,
            $woundTypeCode = WoundTypeCode::getIt(WoundTypeCode::CUT),
            $cover = 4,
            $weight = new Weight(5, Weight::KG, Tables::getIt()->getWeightTable()),
            $twoHandedOnly = false
        );
        self::assertSame($requiredStrength, $sut->getRequiredStrengthOf($crasher));
        self::assertSame($weaponLength, $sut->getLengthOf($crasher));
        self::assertSame($offensiveness, $sut->getOffensivenessOf($crasher));
        self::assertSame($wounds, $sut->getWoundsOf($crasher));
        self::assertSame($woundTypeCode->getValue(), $sut->getWoundsTypeOf($crasher));
        self::assertSame($cover, $sut->getCoverOf($crasher));
        self::assertSame($weight->getKilograms(), $sut->getWeightOf($crasher));
        self::assertSame($twoHandedOnly, $sut->getTwoHandedOnlyOf($crasher));
    }
}