<?php
namespace DrdPlus\Tests\Tables\Armaments;

use DrdPlus\Codes\BodyArmorCode;
use DrdPlus\Codes\HelmCode;
use DrdPlus\Codes\MeleeWeaponCode;
use DrdPlus\Codes\ShootingWeaponCode;
use DrdPlus\Tables\Armaments\Armors\BodyArmorsTable;
use DrdPlus\Tables\Armaments\Armors\HelmsTable;
use DrdPlus\Tables\Armaments\Armourer;
use DrdPlus\Tables\Armaments\Sanctions\ArmorSanctionsTable;
use DrdPlus\Tables\Armaments\Sanctions\MeleeWeaponSanctionsTable;
use DrdPlus\Tables\Armaments\Sanctions\ShootingWeaponSanctionsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\ShootingWeaponsTable;
use DrdPlus\Tables\Tables;
use Granam\Tests\Tools\TestWithMockery;

class ArmourerTest extends TestWithMockery
{
    /**
     * @test
     * @dataProvider provideBodySizeAndStrength
     * @param int $requiredStrength
     * @param int $bodySize
     * @param int $strength
     * @param mixed $expectedMissingStrength
     */
    public function I_can_get_missing_strength_and_sanction_values_for_body_armor(
        $requiredStrength,
        $bodySize,
        $strength,
        $expectedMissingStrength
    )
    {
        $armourer = new Armourer($tables = $this->createTables());
        $tables->shouldReceive('getBodyArmorsTable')
            ->andReturn($bodyArmorsTable = $this->createBodyArmorsTable());
        $armorCode = 'foo';
        $bodyArmorsTable->shouldReceive('getRequiredStrengthOf')
            ->with($armorCode)
            ->andReturn($requiredStrength);
        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForBodyArmor($this->createBodyArmorCode($armorCode), $bodySize, $strength)
        );
        $tables->shouldReceive('getArmorSanctionsTable')
            ->andReturn($armorSanctionsTable = $this->createArmorSanctionsTable());
        $armorSanctionsTable->shouldReceive('getSanctionsForMissingStrength')
            ->with($expectedMissingStrength)
            ->andReturn('bar');
        self::assertSame(
            'bar',
            $armourer->getSanctionValuesForBodyArmor($this->createBodyArmorCode($armorCode), $bodySize, $strength)
        );
    }

    public function provideBodySizeAndStrength()
    {
        return [
            [123, 11, 65, 69],
            [0, 33, 88, 0], // no required strength results into zero missing strength
        ];
    }

    /**
     * @return \Mockery\MockInterface|Tables
     */
    private function createTables()
    {
        return $this->mockery(Tables::class);
    }

    /**
     * @param string $value
     * @return \Mockery\MockInterface|BodyArmorCode
     */
    private function createBodyArmorCode($value)
    {
        $bodyArmorCode = $this->mockery(BodyArmorCode::class);
        $bodyArmorCode->shouldReceive('getValue')
            ->andReturn($value);

        return $bodyArmorCode;
    }

    /**
     * @return \Mockery\MockInterface|BodyArmorsTable
     */
    private function createBodyArmorsTable()
    {
        return $this->mockery(BodyArmorsTable::class);
    }

    /**
     * @return \Mockery\MockInterface|ArmorSanctionsTable
     */
    private function createArmorSanctionsTable()
    {
        return $this->mockery(ArmorSanctionsTable::class);
    }

    /**
     * @return \Mockery\MockInterface|HelmsTable
     */
    private function createHelmsTable()
    {
        return $this->mockery(HelmsTable::class);
    }

    /**
     * @test
     * @dataProvider provideBodySizeAndStrength
     * @param int $requiredStrength
     * @param int $bodySize
     * @param int $strength
     * @param mixed $expectedMissingStrength
     */
    public function I_can_get_missing_strength_and_sanction_values_for_helmet(
        $requiredStrength,
        $bodySize,
        $strength,
        $expectedMissingStrength
    )
    {
        $armourer = new Armourer($tables = $this->createTables());
        $tables->shouldReceive('getHelmsTable')
            ->andReturn($helmsTable = $this->createHelmsTable());
        $armorCode = 'foo';
        $helmsTable->shouldReceive('getRequiredStrengthOf')
            ->with($armorCode)
            ->andReturn($requiredStrength);
        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForHelm($this->createHelmCode($armorCode), $bodySize, $strength)
        );
        $tables->shouldReceive('getArmorSanctionsTable')
            ->andReturn($armorSanctionsTable = $this->createArmorSanctionsTable());
        $armorSanctionsTable->shouldReceive('getSanctionsForMissingStrength')
            ->with($expectedMissingStrength)
            ->andReturn('bar');
        self::assertSame(
            'bar',
            $armourer->getSanctionValuesForHelm($this->createHelmCode($armorCode), $bodySize, $strength)
        );
    }

    /**
     * @param $value
     * @return \Mockery\MockInterface|HelmCode
     */
    private function createHelmCode($value)
    {
        $helmCode = $this->mockery(HelmCode::class);
        $helmCode->shouldReceive('getValue')
            ->andReturn($value);

        return $helmCode;
    }

    /**
     * @test
     * @dataProvider provideStrengthAndMeleeWeaponGroup
     * @param int $requiredStrength
     * @param int $strength
     * @param mixed $expectedMissingStrength
     * @param string $weaponGroup
     */
    public function I_can_get_missing_strength_and_sanction_values_for_melee_weapon(
        $requiredStrength,
        $strength,
        $expectedMissingStrength,
        $weaponGroup
    )
    {
        $armourer = new Armourer($tables = $this->createTables());
        $weaponsTableBaseName = 'unarmedTable';
        if ($weaponGroup !== 'unarmed') {
            // maceOrClub = macesOrClubs
            $weaponsTableBaseName = preg_replace('~Or([A-Z])~', 'sAnd$1', $weaponGroup) . 'sTable';
        }
        $tables->shouldReceive('get' . ucfirst($weaponsTableBaseName))
            ->andReturn($meleeWeaponTable = $this->createMeleeWeaponTable());
        $weaponCode = ' foo';
        $meleeWeaponTable->shouldReceive('getRequiredStrengthOf')
            ->with($weaponCode)
            ->andReturn($requiredStrength);
        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForMeleeWeapon($this->createMeleeWeaponCode($weaponCode, $weaponGroup), $strength)
        );
        $tables->shouldReceive('getMeleeWeaponSanctionsTable')
            ->andReturn($meleeWeaponSanctionsTable = $this->createMeleeWeaponSanctionsTable());
        $meleeWeaponSanctionsTable->shouldReceive('getSanctionsForMissingStrength')
            ->with($expectedMissingStrength)
            ->andReturn('bar');
        self::assertSame(
            'bar',
            $armourer->getSanctionValuesForMeleeWeapon($this->createMeleeWeaponCode($weaponCode, $weaponGroup), $strength)
        );
    }

    public function provideStrengthAndMeleeWeaponGroup()
    {
        return [
            [50, 10, 40, 'axe'],
            [-66, -65, 0, 'knifeOrDagger'],
            [-88, -200, 112, 'maceOrClub'],
            [1, 2, 0, 'morningStarOrMorgenstern'],
            [2, 1, 1, 'saberOrBowieKnife'],
            [11, 13, 0, 'staffOrSpear'],
            [14, 10, 4, 'sword'],
            [-5, -2, 0, 'unarmed'],
            [999, -1, 1000, 'voulgeOrTrident'],
        ];
    }

    /**
     * @return \Mockery\MockInterface|MeleeWeaponsTable
     */
    private function createMeleeWeaponTable()
    {
        return $this->mockery(MeleeWeaponsTable::class);
    }

    /**
     * @return \Mockery\MockInterface|MeleeWeaponSanctionsTable
     */
    private function createMeleeWeaponSanctionsTable()
    {
        return $this->mockery(MeleeWeaponSanctionsTable::class);
    }

    /**
     * @param $value
     * @param string $matchingWeaponGroup
     * @return \Mockery\MockInterface|MeleeWeaponCode
     */
    private function createMeleeWeaponCode($value, $matchingWeaponGroup)
    {
        $code = $this->mockery(MeleeWeaponCode::class);
        $code->shouldReceive('getValue')
            ->andReturn($value);
        $code->shouldReceive('__toString')
            ->andReturn((string)$value);
        foreach ($this->getMeleeWeaponGroups() as $weaponGroup) {
            $code->shouldReceive('is' . ucfirst($weaponGroup))
                ->andReturn($weaponGroup === $matchingWeaponGroup);
        }

        return $code;
    }

    /**
     * @return array|string[]
     */
    private function getMeleeWeaponGroups()
    {
        return [
            'axe', 'knifeOrDagger', 'maceOrClub', 'morningStarOrMorgenstern',
            'saberOrBowieKnife', 'staffOrSpear', 'sword', 'unarmed', 'voulgeOrTrident'
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeaponCode
     * @expectedExceptionMessageRegExp ~foo~
     */
    public function I_can_not_get_strength_sanction_for_unknown_melee_weapon()
    {
        (new Armourer($this->createTables()))->getMissingStrengthForMeleeWeapon($this->createMeleeWeaponCode('foo', 'sharpLanguage'), 0);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeaponCode
     * @expectedExceptionMessageRegExp ~foo~
     */
    public function I_can_not_get_sanctions_for_unknown_melee_weapon()
    {
        (new Armourer($this->createTables()))->getSanctionValuesForMeleeWeapon($this->createMeleeWeaponCode('foo', 'sharpLanguage'), 0);
    }

    /**
     * @test
     * @dataProvider provideStrengthAndShootingWeaponGroup
     * @param int $requiredStrength
     * @param int $strength
     * @param mixed $expectedMissingStrength
     * @param string $weaponGroup
     */
    public function I_can_get_missing_strength_and_sanction_values_for_shooting_weapon(
        $requiredStrength,
        $strength,
        $expectedMissingStrength,
        $weaponGroup
    )
    {
        $armourer = new Armourer($tables = $this->createTables());
        $weaponsTableBaseName = $weaponGroup . 'sTable';
        $tables->shouldReceive('get' . ucfirst($weaponsTableBaseName))
            ->andReturn($shootingWeaponTable = $this->createShootingWeaponTable());
        $weaponCode = ' foo';
        $shootingWeaponTable->shouldReceive('getRequiredStrengthOf')
            ->with($weaponCode)
            ->andReturn($requiredStrength);
        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForShootingWeapon($this->createShootingWeaponCode($weaponCode, $weaponGroup), $strength)
        );
        $tables->shouldReceive('getShootingWeaponSanctionsTable')
            ->andReturn($shootingWeaponSanctionsTable = $this->createShootingWeaponSanctionsTable());
        $shootingWeaponSanctionsTable->shouldReceive('getSanctionsForMissingStrength')
            ->with($expectedMissingStrength)
            ->andReturn('bar');
        self::assertSame(
            'bar',
            $armourer->getSanctionValuesForShootingWeapon($this->createShootingWeaponCode($weaponCode, $weaponGroup), $strength)
        );
    }

    public function provideStrengthAndShootingWeaponGroup()
    {
        return [
            [123, 456, 0, 'arrow'],
            [456, 123, 333, 'arrow'],
            [222, 333, 0, 'bow'],
            [222, 110, 112, 'bow'],
            [963, 852, 111, 'dart'],
            [0, 0, 0, 'dart'],
            [1, 0, 1, 'crossbow'],
            [-100, 34, 0, 'crossbow'],
            [-5, -8, 3, 'slingStone'],
        ];
    }

    /**
     * @return \Mockery\MockInterface|ShootingWeaponsTable
     */
    private function createShootingWeaponTable()
    {
        return $this->mockery(ShootingWeaponsTable::class);
    }

    /**
     * @return \Mockery\MockInterface|ShootingWeaponSanctionsTable
     */
    private function createShootingWeaponSanctionsTable()
    {
        return $this->mockery(ShootingWeaponSanctionsTable::class);
    }

    /**
     * @param $value
     * @param string $matchingWeaponGroup
     * @return \Mockery\MockInterface|ShootingWeaponCode
     */
    private function createShootingWeaponCode($value, $matchingWeaponGroup)
    {
        $code = $this->mockery(ShootingWeaponCode::class);
        $code->shouldReceive('getValue')
            ->andReturn($value);
        $code->shouldReceive('__toString')
            ->andReturn((string)$value);
        foreach ($this->getShootingWeaponGroups() as $weaponGroup) {
            $code->shouldReceive('is' . ucfirst($weaponGroup))
                ->andReturn($weaponGroup === $matchingWeaponGroup);
        }

        return $code;
    }

    private function getShootingWeaponGroups()
    {
        return ['arrow', 'bow', 'dart', 'crossbow', 'slingStone'];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Shooting\Exceptions\UnknownShootingWeaponCode
     * @expectedExceptionMessageRegExp ~foo~
     */
    public function I_can_not_get_strength_sanction_for_unknown_shooting_weapon()
    {
        (new Armourer($this->createTables()))->getMissingStrengthForShootingWeapon($this->createShootingWeaponCode('foo', 'spit'), 0);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Shooting\Exceptions\UnknownShootingWeaponCode
     * @expectedExceptionMessageRegExp ~foo~
     */
    public function I_can_not_get_sanctions_for_unknown_shooting_weapon()
    {
        (new Armourer($this->createTables()))->getSanctionValuesForShootingWeapon($this->createShootingWeaponCode('foo', 'spit'), 0);
    }

}
