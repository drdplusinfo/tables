<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials;

use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\Armaments\WeaponCategoryCode;
use DrdPlus\Codes\Body\WoundTypeCode;
use DrdPlus\Properties\Base\Strength;
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
            $requiredStrength = Strength::getIt(0),
            $weaponLength = 1,
            $offensiveness = 2,
            $wounds = 3,
            $woundTypeCode = WoundTypeCode::getIt(WoundTypeCode::CUT),
            $cover = 4,
            $weight = new Weight(5, Weight::KG, Tables::getIt()->getWeightTable()),
            $twoHandedOnly = false
        );
        self::assertSame($requiredStrength->getValue(), $sut->getRequiredStrengthOf($chopa));
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
        $added = $sut->$addNew(
            $crasher,
            $requiredStrength = Strength::getIt(10),
            $weaponLength = 1,
            $offensiveness = 2,
            $wounds = 3,
            $woundTypeCode = WoundTypeCode::getIt(WoundTypeCode::CUT),
            $cover = 4,
            $weight = new Weight(5, Weight::KG, Tables::getIt()->getWeightTable()),
            $twoHandedOnly = false
        );
        self::assertTrue($added);
        self::assertSame($requiredStrength->getValue(), $sut->getRequiredStrengthOf($crasher));
        self::assertSame($weaponLength, $sut->getLengthOf($crasher));
        self::assertSame($offensiveness, $sut->getOffensivenessOf($crasher));
        self::assertSame($wounds, $sut->getWoundsOf($crasher));
        self::assertSame($woundTypeCode->getValue(), $sut->getWoundsTypeOf($crasher));
        self::assertSame($cover, $sut->getCoverOf($crasher));
        self::assertSame($weight->getKilograms(), $sut->getWeightOf($crasher));
        self::assertSame($twoHandedOnly, $sut->getTwoHandedOnlyOf($crasher));
    }

    /**
     * @test
     */
    public function I_can_add_same_weapon_multiple_time_without_error()
    {
        $sut = $this->createSut();
        $name = uniqid('cleaver', true);
        $addNew = StringTools::assembleMethodName(
            str_replace('_and_', '_or_', $this->getMeleeWeaponCategory()->getValue()),
            'addNew'
        );
        MeleeWeaponCode::addNewMeleeWeaponCode($name, $this->getMeleeWeaponCategory(), []);
        $cleaver = MeleeWeaponCode::getIt($name);
        $requiredStrength = Strength::getIt(0);
        $weaponLength = 1;
        $offensiveness = 2;
        $wounds = 3;
        $woundTypeCode = WoundTypeCode::getIt(WoundTypeCode::CUT);
        $cover = 4;
        $weight = new Weight(5, Weight::KG, Tables::getIt()->getWeightTable());
        $twoHandedOnly = false;
        for ($attempt = 1; $attempt < 5; $attempt++) {
            $added = $sut->$addNew(
                $cleaver,
                $requiredStrength,
                $weaponLength,
                $offensiveness,
                $wounds,
                $woundTypeCode = WoundTypeCode::getIt(WoundTypeCode::CUT),
                $cover,
                $weight = new Weight(5, Weight::KG, Tables::getIt()->getWeightTable()),
                $twoHandedOnly = false
            );
            if($attempt === 1) {
                self::assertTrue($added);
            } else {
                self::assertFalse($added);
            }
        }
        self::assertSame($requiredStrength->getValue(), $sut->getRequiredStrengthOf($cleaver));
        self::assertSame($weaponLength, $sut->getLengthOf($cleaver));
        self::assertSame($offensiveness, $sut->getOffensivenessOf($cleaver));
        self::assertSame($wounds, $sut->getWoundsOf($cleaver));
        self::assertSame($woundTypeCode->getValue(), $sut->getWoundsTypeOf($cleaver));
        self::assertSame($cover, $sut->getCoverOf($cleaver));
        self::assertSame($weight->getKilograms(), $sut->getWeightOf($cleaver));
        self::assertSame($twoHandedOnly, $sut->getTwoHandedOnlyOf($cleaver));
    }

    /**
     * @test
     * @dataProvider provideNewWeaponSlightlyChangedParameters
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Exceptions\DifferentWeaponIsUnderSameName
     *
     * @param $templateRequiredStrength
     * @param $templateWeaponLength
     * @param $templateOffensiveness
     * @param $templateWounds
     * @param $templateWoundTypeCode
     * @param $templateCover
     * @param $templateWeight
     * @param $templateTwoHandedOnly
     * @param $requiredStrength
     * @param $weaponLength
     * @param $offensiveness
     * @param $wounds
     * @param $woundTypeCode
     * @param $cover
     * @param $weight
     * @param $twoHandedOnly
     */
    public function I_can_not_add_same_named_weapon_with_different_parameters(
        $templateRequiredStrength,
        $templateWeaponLength,
        $templateOffensiveness,
        $templateWounds,
        $templateWoundTypeCode,
        $templateCover,
        $templateWeight,
        $templateTwoHandedOnly,
        $requiredStrength,
        $weaponLength,
        $offensiveness,
        $wounds,
        $woundTypeCode,
        $cover,
        $weight,
        $twoHandedOnly
    )
    {
        $sut = $this->createSut();
        $name = 'spoon_' . static::getSutClass(); // unique per SUT
        $addNew = StringTools::assembleMethodName(
            str_replace('_and_', '_or_', $this->getMeleeWeaponCategory()->getValue()),
            'addNew'
        );
        MeleeWeaponCode::addNewMeleeWeaponCode($name, $this->getMeleeWeaponCategory(), []);
        $spoon = MeleeWeaponCode::getIt($name);
        $added = $sut->$addNew(
            $spoon,
            Strength::getIt($templateRequiredStrength),
            $templateWeaponLength,
            $templateOffensiveness,
            $templateWounds,
            $templateWoundTypeCode,
            $templateCover,
            $templateWeight,
            $templateTwoHandedOnly
        );
        self::assertTrue($added);
        $addedAgain = $sut->$addNew($spoon, Strength::getIt($requiredStrength), $weaponLength, $offensiveness, $wounds, $woundTypeCode, $cover, $weight, $twoHandedOnly);
        self::assertFalse($addedAgain);
    }

    public function provideNewWeaponSlightlyChangedParameters(): array
    {
        $template = [
            'requiredStrength' => 0,
            'weaponLength' => 1,
            'offensiveness' => 2,
            'wounds' => 3,
            'woundTypeCode' => WoundTypeCode::getIt(WoundTypeCode::CUT),
            'cover' => 4,
            'weight' => new Weight(5, Weight::KG, Tables::getIt()->getWeightTable()),
            'twoHandedOnly' => false,
        ];
        $templateValues = array_values($template);

        return [
            array_merge($templateValues, array_values(array_merge($template, ['requiredStrength' => $template['requiredStrength'] + 1]))),
            array_merge($templateValues, array_values(array_merge($template, ['weaponLength' => $template['weaponLength'] + 1]))),
            array_merge($templateValues, array_values(array_merge($template, ['offensiveness' => $template['offensiveness'] - 1]))),
            array_merge($templateValues, array_values(array_merge($template, ['wounds' => $template['wounds'] - 1]))),
            array_merge($templateValues, array_values(array_merge($template, ['wounds' => $template['wounds'] - 1]))),
            array_merge($templateValues, array_values(array_merge($template, ['woundTypeCode' => WoundTypeCode::getIt(WoundTypeCode::CRUSH)]))),
            array_merge($templateValues, array_values(array_merge($template, ['cover' => $template['cover'] + 2]))),
            array_merge($templateValues, array_values(array_merge($template, ['weight' => new Weight(3, Weight::KG, Tables::getIt()->getWeightTable())]))),
            array_merge($templateValues, array_values(array_merge($template, ['twoHandedOnly' => !$template['twoHandedOnly']]))),
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Exceptions\NewWeaponIsNotOfRequiredType
     * @expectedExceptionMessageRegExp ~crossbow.+ham&axe~
     */
    public function I_can_not_add_new_melee_weapon_with_unexpected_category()
    {
        $sut = $this->createSut();
        $name = uniqid('ham&axe', true);
        MeleeWeaponCode::addNewMeleeWeaponCode($name, $this->getMeleeWeaponCategory(), []);
        $hamAndAxe = MeleeWeaponCode::getIt($name);
        $sut->addNewMeleeWeapon(
            $hamAndAxe,
            WeaponCategoryCode::getIt(WeaponCategoryCode::CROSSBOW), // intentionally ranged
            $requiredStrength = Strength::getIt(0),
            $weaponLength = 1,
            $offensiveness = 2,
            $wounds = 3,
            $woundTypeCode = WoundTypeCode::getIt(WoundTypeCode::CUT),
            $cover = 4,
            $weight = new Weight(5, Weight::KG, Tables::getIt()->getWeightTable()),
            $twoHandedOnly = false
        );
    }
}