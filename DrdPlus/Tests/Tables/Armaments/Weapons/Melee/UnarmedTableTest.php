<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\UnarmedTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class UnarmedTableTest extends AbstractMeleeWeaponsTableTest
{
    public function provideWeaponAndNameWithValue()
    {
        return [
            [WeaponCode::HAND, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCode::HAND, AbstractMeleeWeaponsTable::LENGTH_HEADER, 0],
            [WeaponCode::HAND, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCode::HAND, AbstractMeleeWeaponsTable::WOUNDS_HEADER, -2],
            [WeaponCode::HAND, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::HAND, AbstractMeleeWeaponsTable::COVER_HEADER, 0],
            [WeaponCode::HAND, AbstractMeleeWeaponsTable::WEIGHT_HEADER, false],

            [WeaponCode::HOBNAILED_GLOVE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCode::HOBNAILED_GLOVE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 0],
            [WeaponCode::HOBNAILED_GLOVE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCode::HOBNAILED_GLOVE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 0],
            [WeaponCode::HOBNAILED_GLOVE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::HOBNAILED_GLOVE, AbstractMeleeWeaponsTable::COVER_HEADER, 0],
            [WeaponCode::HOBNAILED_GLOVE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, false],

            [WeaponCode::LEG, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCode::LEG, AbstractMeleeWeaponsTable::LENGTH_HEADER, 0],
            [WeaponCode::LEG, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, -1],
            [WeaponCode::LEG, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 1],
            [WeaponCode::LEG, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::LEG, AbstractMeleeWeaponsTable::COVER_HEADER, 0],
            [WeaponCode::LEG, AbstractMeleeWeaponsTable::WEIGHT_HEADER, false],

            [WeaponCode::HOBNAILED_BOOT, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, false],
            [WeaponCode::HOBNAILED_BOOT, AbstractMeleeWeaponsTable::LENGTH_HEADER, 0],
            [WeaponCode::HOBNAILED_BOOT, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, -2],
            [WeaponCode::HOBNAILED_BOOT, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 4],
            [WeaponCode::HOBNAILED_BOOT, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::HOBNAILED_BOOT, AbstractMeleeWeaponsTable::COVER_HEADER, 0],
            [WeaponCode::HOBNAILED_BOOT, AbstractMeleeWeaponsTable::WEIGHT_HEADER, false],
        ];
    }

    /**
     * @test
     */
    public function I_can_get_every_weapon_by_weapon_codes_library()
    {
        $unarmedTable = new UnarmedTable();
        foreach (WeaponCode::getUnarmedCodes() as $unarmedCode) {
            $row = $unarmedTable->getRow([$unarmedCode]);
            self::assertNotEmpty($row);
        }
    }

}
