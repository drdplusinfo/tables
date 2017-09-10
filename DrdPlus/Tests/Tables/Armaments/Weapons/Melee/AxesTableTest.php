<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\Armaments\WeaponCategoryCode;
use DrdPlus\Codes\Body\WoundTypeCode;
use DrdPlus\Properties\Body\WeightInKg;
use DrdPlus\Tables\Armaments\Weapons\Melee\AxesTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTableTest;

class AxesTableTest extends MeleeWeaponsTableTest
{

    public function provideArmamentAndNameWithValue(): array
    {
        return [
            [MeleeWeaponCode::LIGHT_AXE, MeleeWeaponsTable::REQUIRED_STRENGTH, 3],
            [MeleeWeaponCode::LIGHT_AXE, MeleeWeaponsTable::LENGTH, 1],
            [MeleeWeaponCode::LIGHT_AXE, MeleeWeaponsTable::OFFENSIVENESS, 3],
            [MeleeWeaponCode::LIGHT_AXE, MeleeWeaponsTable::WOUNDS, 3],
            [MeleeWeaponCode::LIGHT_AXE, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [MeleeWeaponCode::LIGHT_AXE, MeleeWeaponsTable::COVER, 2],
            [MeleeWeaponCode::LIGHT_AXE, MeleeWeaponsTable::WEIGHT, 1.0],
            [MeleeWeaponCode::LIGHT_AXE, MeleeWeaponsTable::TWO_HANDED_ONLY, false],

            [MeleeWeaponCode::AXE, MeleeWeaponsTable::REQUIRED_STRENGTH, 6],
            [MeleeWeaponCode::AXE, MeleeWeaponsTable::LENGTH, 2],
            [MeleeWeaponCode::AXE, MeleeWeaponsTable::OFFENSIVENESS, 3],
            [MeleeWeaponCode::AXE, MeleeWeaponsTable::WOUNDS, 5],
            [MeleeWeaponCode::AXE, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [MeleeWeaponCode::AXE, MeleeWeaponsTable::COVER, 2],
            [MeleeWeaponCode::AXE, MeleeWeaponsTable::WEIGHT, 2.0],
            [MeleeWeaponCode::AXE, MeleeWeaponsTable::TWO_HANDED_ONLY, false],

            [MeleeWeaponCode::WAR_AXE, MeleeWeaponsTable::REQUIRED_STRENGTH, 9],
            [MeleeWeaponCode::WAR_AXE, MeleeWeaponsTable::LENGTH, 3],
            [MeleeWeaponCode::WAR_AXE, MeleeWeaponsTable::OFFENSIVENESS, 3],
            [MeleeWeaponCode::WAR_AXE, MeleeWeaponsTable::WOUNDS, 7],
            [MeleeWeaponCode::WAR_AXE, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [MeleeWeaponCode::WAR_AXE, MeleeWeaponsTable::COVER, 3],
            [MeleeWeaponCode::WAR_AXE, MeleeWeaponsTable::WEIGHT, 2.5],
            [MeleeWeaponCode::WAR_AXE, MeleeWeaponsTable::TWO_HANDED_ONLY, false],

            [MeleeWeaponCode::TWO_HANDED_AXE, MeleeWeaponsTable::REQUIRED_STRENGTH, 12],
            [MeleeWeaponCode::TWO_HANDED_AXE, MeleeWeaponsTable::LENGTH, 3],
            [MeleeWeaponCode::TWO_HANDED_AXE, MeleeWeaponsTable::OFFENSIVENESS, 4],
            [MeleeWeaponCode::TWO_HANDED_AXE, MeleeWeaponsTable::WOUNDS, 10],
            [MeleeWeaponCode::TWO_HANDED_AXE, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [MeleeWeaponCode::TWO_HANDED_AXE, MeleeWeaponsTable::COVER, 3],
            [MeleeWeaponCode::TWO_HANDED_AXE, MeleeWeaponsTable::WEIGHT, 3.0],
            [MeleeWeaponCode::TWO_HANDED_AXE, MeleeWeaponsTable::TWO_HANDED_ONLY, false],
        ];
    }

    /**
     * @test
     */
    public function I_can_get_every_weapon_by_weapon_codes_library()
    {
        $axesTable = new AxesTable();
        foreach (MeleeWeaponCode::getAxeCodes() as $axeCode) {
            $row = $axesTable->getRow([$axeCode]);
            self::assertNotEmpty($row);
        }
    }

    /**
     * @test
     */
    public function I_can_add_new_axe()
    {
        $axesTable = new AxesTable();
        MeleeWeaponCode::addNewMeleeWeaponCode('chopa', WeaponCategoryCode::getIt(WeaponCategoryCode::AXE), []);
        $chopa = MeleeWeaponCode::getIt('chopa');
        $axesTable->addNewAxe(
            $chopa,
            0,
            1,
            2,
            3,
            WoundTypeCode::getIt(WoundTypeCode::CUT),
            4,
            WeightInKg::getIt(5),
            false
        );
    }
}