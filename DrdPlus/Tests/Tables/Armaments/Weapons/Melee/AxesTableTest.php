<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Melee\AxesTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class AxesTableTest extends AbstractMeleeWeaponsTableTest
{

    public function provideWeaponAndNameWithValue()
    {
        return [
            [WeaponCode::LIGHT_AXE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 3],
            [WeaponCode::LIGHT_AXE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCode::LIGHT_AXE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::LIGHT_AXE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 3],
            [WeaponCode::LIGHT_AXE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::LIGHT_AXE, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCode::LIGHT_AXE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.0],

            [WeaponCode::AXE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 6],
            [WeaponCode::AXE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCode::AXE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::AXE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 5],
            [WeaponCode::AXE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::AXE, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCode::AXE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.0],

            [WeaponCode::WAR_AXE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 9],
            [WeaponCode::WAR_AXE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCode::WAR_AXE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::WAR_AXE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 7],
            [WeaponCode::WAR_AXE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::WAR_AXE, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCode::WAR_AXE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.5],

            [WeaponCode::TWO_HANDED_AXE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 12],
            [WeaponCode::TWO_HANDED_AXE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCode::TWO_HANDED_AXE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 4],
            [WeaponCode::TWO_HANDED_AXE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 10],
            [WeaponCode::TWO_HANDED_AXE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::TWO_HANDED_AXE, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCode::TWO_HANDED_AXE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 3.0],
        ];
    }

    /**
     * @test
     */
    public function I_can_get_every_weapon_by_weapon_codes_library()
    {
        $axesTable = new AxesTable();
        foreach (WeaponCode::getAxeCodes() as $axeCode) {
            $row = $axesTable->getRow([$axeCode]);
            self::assertNotEmpty($row);
        }
    }

}