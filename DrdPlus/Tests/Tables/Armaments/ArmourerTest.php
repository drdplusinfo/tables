<?php
namespace DrdPlus\Tests\Tables\Armaments;

use DrdPlus\Codes\Armaments\BodyArmorCode;
use DrdPlus\Codes\Armaments\HelmCode;
use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\Armaments\MeleeWeaponlikeCode;
use DrdPlus\Codes\Armaments\ProjectileCode;
use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Codes\Armaments\ShieldCode;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Body\Size;
use DrdPlus\Properties\Combat\EncounterRange;
use DrdPlus\Properties\Combat\MaximalRange;
use DrdPlus\Properties\Derived\Speed;
use DrdPlus\Tables\Armaments\Armors\ArmorStrengthSanctionsTable;
use DrdPlus\Tables\Armaments\Armourer;
use DrdPlus\Tables\Armaments\MissingProtectiveArmamentSkill;
use DrdPlus\Tables\Armaments\Partials\AbstractArmamentsTable;
use DrdPlus\Tables\Armaments\Partials\MeleeWeaponlikesTable;
use DrdPlus\Tables\Armaments\Projectiles\Partials\ProjectilesTable;
use DrdPlus\Tables\Armaments\Shields\ShieldStrengthSanctionsTable;
use DrdPlus\Tables\Armaments\Shields\ShieldsTable;
use DrdPlus\Tables\Armaments\Shields\ShieldUsageSkillTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\MeleeWeaponStrengthSanctionsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\MissingWeaponSkillTable;
use DrdPlus\Tables\Armaments\Weapons\Ranged\BowsTable;
use DrdPlus\Tables\Armaments\Weapons\Ranged\CrossbowsTable;
use DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Ranged\RangedWeaponStrengthSanctionsTable;
use DrdPlus\Tables\Combat\Attacks\ContinuousAttackNumberByDistanceTable;
use DrdPlus\Tables\Measurements\BaseOfWounds\BaseOfWoundsTable;
use DrdPlus\Tables\Measurements\Distance\Distance;
use DrdPlus\Tables\Measurements\Distance\DistanceBonus;
use DrdPlus\Tables\Measurements\Distance\DistanceTable;
use DrdPlus\Tables\Tables;
use Granam\Integer\IntegerInterface;
use Granam\Integer\PositiveInteger;
use Granam\Tests\Tools\TestWithMockery;

class ArmourerTest extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_find_out_if_can_use_each_armament()
    {
        $this->I_can_find_out_if_can_use_body_armor();
        $this->I_can_find_out_if_can_use_melee_weapon();
        $this->I_can_find_out_if_can_use_range_weapon();
        $this->I_can_find_out_if_can_use_shield();
    }

    private function I_can_find_out_if_can_use_body_armor()
    {
        $armourer = new Armourer($tables = $this->createTables());
        $bodyArmorCode = $this->createBodyArmorCode('foo');
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($bodyArmorCode)
            ->andReturn($armamentsTable = $this->mockery(AbstractArmamentsTable::class));
        $armamentsTable->shouldReceive('getRequiredStrengthOf')
            ->with($bodyArmorCode)
            ->andReturn(123);
        $tables->shouldReceive('getArmamentStrengthSanctionsTableByCode')
            ->andReturn($armorSanctionsTable = $this->createArmorSanctionsTable());
        $armorSanctionsTable->shouldReceive('canUseIt')
            ->with(124 /* required strength - current strength + size */)
            ->andReturn(false);
        self::assertFalse($armourer->canUseArmament($bodyArmorCode, Strength::getIt(1), Size::getIt(2)));
    }

    private function I_can_find_out_if_can_use_melee_weapon()
    {
        $armourer = new Armourer($tables = $this->createTables());
        $axe = $this->createMeleeWeaponCode('foo', 'axe');
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($axe)
            ->andReturn($armamentsTable = $this->mockery(AbstractArmamentsTable::class));
        $armamentsTable->shouldReceive('getRequiredStrengthOf')
            ->with($axe)
            ->andReturn(234);
        $tables->shouldReceive('getArmamentStrengthSanctionsTableByCode')
            ->andReturn($meleeWeaponSanctionsTable = $this->createMeleeWeaponSanctionsTable());
        $meleeWeaponSanctionsTable->shouldReceive('canUseIt')
            ->with(238 /* required strength - current strength */)
            ->andReturn(false);
        self::assertFalse($armourer->canUseArmament($axe, Strength::getIt(-4), $this->createSize()));
    }

    /**
     * @param $value
     * @return \Mockery\MockInterface|Size
     */
    private function createSize($value = null)
    {
        $size = $this->mockery(Size::class);
        if ($value !== null) {
            $size->shouldReceive('getValue')
                ->andReturn($value);
        }

        return $size;
    }

    private function I_can_find_out_if_can_use_range_weapon()
    {
        $armourer = new Armourer($tables = $this->createTables());
        $bow = $this->createRangedWeaponCode('foo bar', 'bow');
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($bow)
            ->andReturn($armamentsTable = $this->mockery(AbstractArmamentsTable::class));
        $armamentsTable->shouldReceive('getRequiredStrengthOf')
            ->with($bow)
            ->andReturn(345);
        $tables->shouldReceive('getArmamentStrengthSanctionsTableByCode')
            ->andReturn($rangedWeaponSanctionsTable = $this->createRangedWeaponSanctionsTable());
        $rangedWeaponSanctionsTable->shouldReceive('canUseIt')
            ->with(344 /* required strength - current strength */)
            ->andReturn(true);
        self::assertTrue($armourer->canUseArmament($bow, Strength::getIt(1), $this->createSize()));
    }

    private function I_can_find_out_if_can_use_shield()
    {
        $armourer = new Armourer($tables = $this->createTables());
        $shield = $this->createShield();
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($shield)
            ->andReturn($armamentsTable = $this->mockery(AbstractArmamentsTable::class));
        $armamentsTable->shouldReceive('getRequiredStrengthOf')
            ->with($shield)
            ->andReturn(456);
        $tables->shouldReceive('getArmamentStrengthSanctionsTableByCode')
            ->andReturn($shieldSanctionsSanctionsTable = $this->createShieldSanctionsTable());
        $shieldSanctionsSanctionsTable->shouldReceive('canUseIt')
            ->with(444 /* required strength - current strength */)
            ->andReturn(false);
        self::assertFalse($armourer->canUseArmament($shield, Strength::getIt(12), $this->createSize()));
    }

    /**
     * @return \Mockery\MockInterface|ShieldCode
     */
    private function createShield()
    {
        $shieldCode = $this->mockery(ShieldCode::class);
        $shieldCode->shouldReceive('isWeapon')
            ->andReturn(false);
        $shieldCode->shouldReceive('isShield')
            ->andReturn(true);

        return $shieldCode;
    }

    /**
     * @test
     * @dataProvider provideBodySizeAndStrength
     * @param int $requiredStrength
     * @param int $bodySize
     * @param int $strength
     * @param mixed $expectedMissingStrength
     */
    public function I_can_get_missing_strength_and_sanction_values_for_body_armor_and_helm(
        $requiredStrength,
        $bodySize,
        $strength,
        $expectedMissingStrength
    )
    {
        $armourer = new Armourer($tables = $this->createTables());

        $bodyArmorCode = $this->createBodyArmorCode('foo');
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($bodyArmorCode)
            ->andReturn($armamentsTable = $this->mockery(AbstractArmamentsTable::class));
        $armamentsTable->shouldReceive('getRequiredStrengthOf')
            ->with($bodyArmorCode)
            ->andReturn($requiredStrength);
        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForArmament(
                $bodyArmorCode, Strength::getIt($strength), Size::getIt($bodySize)
            )
        );

        $helmCode = $this->createHelmCode('bar');
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($helmCode)
            ->andReturn($armamentsTable = $this->mockery(AbstractArmamentsTable::class));
        $armamentsTable->shouldReceive('getRequiredStrengthOf')
            ->with($helmCode)
            ->andReturn($requiredStrength);
        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForArmament(
                $helmCode,
                Strength::getIt($strength),
                Size::getIt($bodySize)
            )
        );
        $tables->shouldReceive('getArmorStrengthSanctionsTable')
            ->andReturn($armorSanctionsTable = $this->createArmorSanctionsTable());
        $armorSanctionsTable->shouldReceive('getSanctionDescription')
            ->with($expectedMissingStrength)
            ->andReturn(309052);
        self::assertSame(
            309052,
            $armourer->getSanctionDescriptionByStrengthWithArmor($helmCode, Strength::getIt($strength), Size::getIt($bodySize))
        );
        $armorSanctionsTable->shouldReceive('getAgilityMalus')
            ->with($expectedMissingStrength)
            ->andReturn(1247394);
        self::assertSame(
            1247394,
            $armourer->getAgilityMalusByStrengthWithArmor($bodyArmorCode, Strength::getIt($strength), Size::getIt($bodySize))
        );
    }

    public function provideBodySizeAndStrength(): array
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
     * @return \Mockery\MockInterface|ArmorStrengthSanctionsTable
     */
    private function createArmorSanctionsTable()
    {
        return $this->mockery(ArmorStrengthSanctionsTable::class);
    }

    /**
     * @param $value
     * @return \Mockery\MockInterface|HelmCode
     */
    private function createHelmCode($value = null)
    {
        $helmCode = $this->mockery(HelmCode::class);
        if ($value !== null) {
            $helmCode->shouldReceive('getValue')
                ->andReturn($value);
        }

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
        $meleeWeaponCode = $this->createMeleeWeaponCode('foo', $weaponGroup);
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($meleeWeaponCode)
            ->andReturn($meleeWeaponTable = $this->createMeleeWeaponsTable());
        $meleeWeaponTable->shouldReceive('getRequiredStrengthOf')
            ->with($meleeWeaponCode)
            ->andReturn($requiredStrength);
        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForArmament($meleeWeaponCode, Strength::getIt($strength), $this->createSize())
        );

        $tables->shouldReceive('getWeaponlikeStrengthSanctionsTableByCode')
            ->andReturn($meleeWeaponSanctionsTable = $this->createMeleeWeaponSanctionsTable());

        $meleeWeaponSanctionsTable->shouldReceive('getFightNumberSanction')
            ->with($expectedMissingStrength)
            ->andReturn(7837836);
        self::assertSame(
            7837836,
            $armourer->getFightNumberMalusByStrengthWithWeaponOrShield($meleeWeaponCode, Strength::getIt($strength))
        );

        $meleeWeaponSanctionsTable->shouldReceive('getAttackNumberSanction')
            ->with($expectedMissingStrength)
            ->andReturn(8634);
        self::assertSame(
            8634,
            $armourer->getAttackNumberMalusByStrengthWithWeaponlike($meleeWeaponCode, Strength::getIt($strength))
        );

        $tables->shouldReceive('getMeleeWeaponlikeCodeStrengthSanctionsTableByCode')
            ->andReturn($meleeWeaponSanctionsTable);
        $meleeWeaponSanctionsTable->shouldReceive('getDefenseNumberSanction')
            ->with($expectedMissingStrength)
            ->andReturn(-581215);
        self::assertSame(
            -581215,
            $armourer->getDefenseNumberMalusByStrengthWithWeaponOrShield($meleeWeaponCode, Strength::getIt($strength))
        );

        $meleeWeaponSanctionsTable->shouldReceive('getBaseOfWoundsSanction')
            ->with($expectedMissingStrength)
            ->andReturn(-55671);
        self::assertSame(
            -55671,
            $armourer->getBaseOfWoundsMalusByStrengthWithWeaponlike($meleeWeaponCode, Strength::getIt($strength))
        );

        $tables->shouldReceive('getArmamentStrengthSanctionsTableByCode')
            ->andReturn($meleeWeaponSanctionsTable);
        $meleeWeaponSanctionsTable->shouldReceive('canUseIt')
            ->with($expectedMissingStrength)
            ->andReturn(false);
        self::assertFalse(
            $armourer->canUseArmament($meleeWeaponCode, Strength::getIt($strength), $this->createSize())
        );
    }

    public function provideStrengthAndMeleeWeaponGroup(): array
    {
        return [
            [50, 10, 40, 'axe'],
            [-66, -65, 0, 'knifeOrDagger'],
            [-88, -200, 112, 'maceOrClub'],
            [1, 2, 0, 'morningstarOrMorgenstern'],
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
    private function createMeleeWeaponsTable()
    {
        return $this->mockery(MeleeWeaponsTable::class);
    }

    /**
     * @return \Mockery\MockInterface|ShieldsTable
     */
    private function createShieldsTable()
    {
        return $this->mockery(ShieldsTable::class);
    }

    /**
     * @return \Mockery\MockInterface|MeleeWeaponStrengthSanctionsTable
     */
    private function createMeleeWeaponSanctionsTable()
    {
        return $this->mockery(MeleeWeaponStrengthSanctionsTable::class);
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
        $code->shouldReceive('isWeapon')
            ->andReturn(true);
        $code->shouldReceive('isShootingWeapon')
            ->andReturn(false);
        $code->shouldReceive('isMelee')
            ->andReturn(true);

        return $code;
    }

    /**
     * @return array|string[]
     */
    private function getMeleeWeaponGroups(): array
    {
        return [
            'axe', 'knifeOrDagger', 'maceOrClub', 'morningstarOrMorgenstern',
            'saberOrBowieKnife', 'staffOrSpear', 'sword', 'unarmed', 'voulgeOrTrident',
        ];
    }

    /**
     * @test
     */
    public function I_get_defense_number_malus_by_missing_strength_for_spear_always_as_melee()
    {
        $armourer = new Armourer($tables = $this->createTables());
        $tables->shouldReceive('getWeaponlikeStrengthSanctionsTableByCode')
            ->andReturn($meleeWeaponSanctionsTable = $this->createMeleeWeaponSanctionsTable());
        /** @var RangedWeaponCode|\Mockery\MockInterface $rangedSpear */
        $rangedSpear = $this->mockery(RangedWeaponCode::class);
        $rangedSpear->shouldReceive('isMelee')
            ->andReturn(true);
        $rangedSpear->shouldReceive('convertToMeleeWeaponCodeEquivalent')
            ->andReturn($meleeSpear = $this->mockery(MeleeWeaponCode::class));
        $tables->shouldReceive('getMeleeWeaponlikeCodeStrengthSanctionsTableByCode')
            ->andReturn($meleeWeaponSanctionsTable);
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($meleeSpear)
            ->andReturn($meleeWeaponTable = $this->createMeleeWeaponsTable());
        $meleeWeaponTable->shouldReceive('getRequiredStrengthOf')
            ->with($meleeSpear)
            ->andReturn(5);
        $meleeWeaponSanctionsTable->shouldReceive('getDefenseNumberSanction')
            ->with(5)
            ->andReturn(-7915);
        self::assertSame(
            -7915,
            $armourer->getDefenseNumberMalusByStrengthWithWeaponOrShield($rangedSpear, Strength::getIt(0))
        );
    }

    /**
     * @test
     */
    public function I_can_get_missing_strength_and_sanction_values_for_shield()
    {
        $armourer = new Armourer($tables = $this->createTables());
        $shield = $this->createShield();
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($shield)
            ->andReturn($shieldsTable = $this->createShieldsTable());
        $shieldsTable->shouldReceive('getRequiredStrengthOf')
            ->with($shield)
            ->andReturn(5);
        self::assertSame(
            1,
            $armourer->getMissingStrengthForArmament($shield, Strength::getIt(4), $this->createSize())
        );
        $tables->shouldReceive('getArmamentStrengthSanctionsTableByCode')
            ->with($shield)
            ->andReturn($shieldStrengthSanctionsTable = $this->mockery(ShieldStrengthSanctionsTable::class));

        $tables->shouldReceive('getWeaponlikeStrengthSanctionsTableByCode')
            ->with($shield)
            ->andReturn($shieldStrengthSanctionsTable);

        $shieldStrengthSanctionsTable->shouldReceive('getFightNumberSanction')
            ->with(1 /* required strength - strength */)
            ->andReturn(-751057);
        self::assertSame(
            -751057,
            $armourer->getFightNumberMalusByStrengthWithWeaponOrShield($shield, Strength::getIt(4))
        );

        $shieldStrengthSanctionsTable->shouldReceive('getAttackNumberSanction')
            ->with(2 /* required strength - strength */)
            ->andReturn(-745);
        self::assertSame(
            -745,
            $armourer->getAttackNumberMalusByStrengthWithWeaponlike($shield, Strength::getIt(3))
        );

        $tables->shouldReceive('getMeleeWeaponlikeCodeStrengthSanctionsTableByCode')
            ->andReturn($shieldStrengthSanctionsTable);
        $shieldStrengthSanctionsTable->shouldReceive('getDefenseNumberSanction')
            ->with(3 /* required strength - strength */)
            ->andReturn(56);
        self::assertSame(
            56,
            $armourer->getDefenseNumberMalusByStrengthWithWeaponOrShield($shield, Strength::getIt(2))
        );

        $shieldStrengthSanctionsTable->shouldReceive('getBaseOfWoundsSanction')
            ->with(4 /* required strength - strength */)
            ->andReturn(-7569);
        self::assertSame(
            -7569,
            $armourer->getBaseOfWoundsMalusByStrengthWithWeaponlike($shield, Strength::getIt(1))
        );

        $shieldStrengthSanctionsTable->shouldReceive('canUseIt')
            ->with(8 /* required strength - strength */)
            ->andReturn(true);
        self::assertTrue(
            $armourer->canUseArmament($shield, Strength::getIt(-3), $this->createSize())
        );
    }

    /**
     * @test
     * @dataProvider provideStrengthAndRangedWeaponGroup
     * @param int $requiredStrength
     * @param int $strength
     * @param mixed $expectedMissingStrength
     * @param string $weaponGroup
     */
    public function I_can_get_missing_strength_and_sanction_values_for_range_weapon(
        $requiredStrength,
        $strength,
        $expectedMissingStrength,
        $weaponGroup
    )
    {
        $armourer = new Armourer($tables = $this->createTables());
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->andReturn($rangedWeaponsTable = $this->createRangedWeaponsTable());
        $weaponlikeCode = $this->createRangedWeaponCode('foo', $weaponGroup);
        $rangedWeaponsTable->shouldReceive('getRequiredStrengthOf')
            ->with($weaponlikeCode)
            ->andReturn($requiredStrength);
        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForArmament($weaponlikeCode, Strength::getIt($strength), $this->createSize())
        );
        $tables->shouldReceive('getArmamentStrengthSanctionsTableByCode')
            ->andReturn($rangeWeaponSanctionsTable = $this->createRangedWeaponSanctionsTable());

        $rangeWeaponSanctionsTable->shouldReceive('canUseIt')
            ->with($expectedMissingStrength)
            ->andReturn(false);
        self::assertFalse(
            $armourer->canUseArmament($weaponlikeCode, Strength::getIt($strength), $this->createSize())
        );

        $tables->shouldReceive('getWeaponlikeStrengthSanctionsTableByCode')
            ->andReturn($rangeWeaponSanctionsTable);
        $rangeWeaponSanctionsTable->shouldReceive('getFightNumberSanction')
            ->with($expectedMissingStrength)
            ->andReturn(147);
        self::assertSame(
            147,
            $armourer->getFightNumberMalusByStrengthWithWeaponOrShield($weaponlikeCode, Strength::getIt($strength))
        );

        $rangeWeaponSanctionsTable->shouldReceive('getAttackNumberSanction')
            ->with($expectedMissingStrength)
            ->andReturn(335);
        self::assertSame(
            335,
            $armourer->getAttackNumberMalusByStrengthWithWeaponlike($weaponlikeCode, Strength::getIt($strength))
        );

        $rangeWeaponSanctionsTable->shouldReceive('getDefenseNumberSanction')
            ->with($expectedMissingStrength)
            ->andReturn(1121);
        self::assertSame(
            1121,
            $armourer->getDefenseNumberMalusByStrengthWithWeaponOrShield($weaponlikeCode, Strength::getIt($strength))
        );

        $tables->shouldReceive('getRangedWeaponStrengthSanctionsTable')
            ->andReturn($rangeWeaponSanctionsTable);
        $rangeWeaponSanctionsTable->shouldReceive('getLoadingInRounds')
            ->with($expectedMissingStrength)
            ->andReturn(44454);
        self::assertSame(
            44454,
            $armourer->getLoadingInRoundsByStrengthWithRangedWeapon($weaponlikeCode, Strength::getIt($strength))
        );

        $rangeWeaponSanctionsTable->shouldReceive('getLoadingInRoundsSanction')
            ->with($expectedMissingStrength)
            ->andReturn(55565);
        self::assertSame(
            55565,
            $armourer->getLoadingInRoundsMalusByStrengthWithRangedWeapon($weaponlikeCode, Strength::getIt($strength))
        );

        $rangeWeaponSanctionsTable->shouldReceive('getBaseOfWoundsSanction')
            ->with($expectedMissingStrength)
            ->andReturn(44344);
        self::assertSame(
            44344,
            $armourer->getBaseOfWoundsMalusByStrengthWithWeaponlike($weaponlikeCode, Strength::getIt($strength))
        );
    }

    public function provideStrengthAndRangedWeaponGroup(): array
    {
        return [
            [222, 333, 0, 'bow'],
            [222, 110, 112, 'bow'],
            [1, 0, 1, 'crossbow'],
            [-100, 34, 0, 'crossbow'],
        ];
    }

    /**
     * @return \Mockery\MockInterface|RangedWeaponsTable
     */
    private function createRangedWeaponsTable()
    {
        return $this->mockery(RangedWeaponsTable::class);
    }

    /**
     * @return \Mockery\MockInterface|RangedWeaponStrengthSanctionsTable
     */
    private function createRangedWeaponSanctionsTable()
    {
        return $this->mockery(RangedWeaponStrengthSanctionsTable::class);
    }

    /**
     * @return \Mockery\MockInterface|ShieldStrengthSanctionsTable
     */
    private function createShieldSanctionsTable()
    {
        return $this->mockery(ShieldStrengthSanctionsTable::class);
    }

    /**
     * @param $value
     * @param string $matchingWeaponGroup
     * @param bool $isAlsoMeleeArmament
     * @return \Mockery\MockInterface|RangedWeaponCode
     */
    private function createRangedWeaponCode($value, $matchingWeaponGroup, $isAlsoMeleeArmament = false)
    {
        $code = $this->mockery(RangedWeaponCode::class);
        $code->shouldReceive('getValue')
            ->andReturn($value);
        $code->shouldReceive('__toString')
            ->andReturn((string)$value);
        foreach ($this->getRangedWeaponGroups() as $weaponGroup) {
            $code->shouldReceive('is' . ucfirst($weaponGroup))
                ->andReturn($weaponGroup === $matchingWeaponGroup);
        }
        $code->shouldReceive('isShootingWeapon')
            ->andReturn(in_array($matchingWeaponGroup, $this->getShootingWeaponGroups(), false));
        $code->shouldReceive('isMelee')
            ->andReturn($isAlsoMeleeArmament);
        $code->shouldReceive('isRanged')
            ->andReturn(true);

        return $code;
    }

    private function getRangedWeaponGroups(): array
    {
        return ['bow', 'crossbow', 'throwingWeapon'];
    }

    private function getShootingWeaponGroups(): array
    {
        return ['bow', 'crossbow'];
    }

    /**
     * @test
     */
    public function I_can_get_attack_number_modifier_by_distance()
    {
        $armourer = new Armourer($tables = $this->createTables());
        $distance = $this->createDistanceWithBonus(123);
        $tables->shouldReceive('getContinuousAttackNumberByDistanceTable')
            ->andReturn($continuousAttackNumberByDistanceTable = $this->mockery(ContinuousAttackNumberByDistanceTable::class));
        $continuousAttackNumberByDistanceTable->shouldReceive('getAttackNumberModifierByDistance')
            ->with($distance)
            ->andReturn(112233);
        self::assertSame(
            112233,
            $armourer->getAttackNumberModifierByDistance(
                $distance,
                $this->createEncounterRange(456),
                $this->createMaximalRange(789)
            ),
            'Should match to modification from' . ContinuousAttackNumberByDistanceTable::class
        );

        self::assertSame(
            112233,
            $armourer->getAttackNumberModifierByDistance(
                $distance,
                $this->createEncounterRange(123), // distance is on edge of encounter range
                $this->createMaximalRange(789)
            )
        );
        self::assertSame(
            112233 + (1 /* encounter range */ - 123 /* distance */),
            $armourer->getAttackNumberModifierByDistance(
                $distance,
                $this->createEncounterRange(1), // distance is out of encounter range but still in maximal range
                $this->createMaximalRange(789)
            )
        );
    }

    /**
     * @param int $bonusValue
     * @param $inMeters
     * @return \Mockery\MockInterface|Distance
     */
    private function createDistanceWithBonus($bonusValue, $inMeters = false)
    {
        $distance = $this->mockery(Distance::class);
        $distance->shouldReceive('getBonus')
            ->andReturn($distanceBonus = $this->mockery(DistanceBonus::class));
        $distanceBonus->shouldReceive('getValue')
            ->andReturn($bonusValue);
        $distanceBonus->shouldReceive('__toString')
            ->andReturn((string)$bonusValue);
        if ($inMeters !== false) {
            $distance->shouldReceive('getMeters')
                ->andReturn($inMeters);
        }

        return $distance;
    }

    /**
     * @param int $value
     * @return \Mockery\MockInterface|EncounterRange
     */
    private function createEncounterRange($value)
    {
        $encounterRange = $this->mockery(EncounterRange::class);
        $encounterRange->shouldReceive('getValue')
            ->andReturn($value);
        $encounterRange->shouldReceive('__toString')
            ->andReturn((string)$value);

        return $encounterRange;
    }

    /**
     * @param int $value
     * @param $inMeters = false
     * @param DistanceTable $distanceTable = null
     * @return \Mockery\MockInterface|MaximalRange
     */
    private function createMaximalRange($value, $inMeters = false, DistanceTable $distanceTable = null)
    {
        $maximalRange = $this->mockery(MaximalRange::class);
        $maximalRange->shouldReceive('getValue')
            ->andReturn($value);
        $maximalRange->shouldReceive('__toString')
            ->andReturn((string)$value);
        if ($inMeters !== false) {
            $maximalRange->shouldReceive('getInMeters')
                ->with($this->type(Tables::class))
                ->andReturnUsing(function (Tables $tables) use ($inMeters, $distanceTable) {
                    self::assertSame($distanceTable, $tables->getDistanceTable());

                    return $inMeters;
                });
        }

        return $maximalRange;
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\EncounterRangeCanNotBeGreaterThanMaximalRange
     * @expectedExceptionMessageRegExp ~456~
     */
    public function I_can_not_get_attack_number_modifier_with_greater_encounter_than_maximal_range()
    {
        (new Armourer($this->createTables()))->getAttackNumberModifierByDistance(
            $this->createDistanceWithBonus(123),
            $this->createEncounterRange(456),
            $this->createMaximalRange(455)
        );
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\DistanceIsOutOfMaximalRange
     * @expectedExceptionMessageRegExp ~457~
     */
    public function I_can_not_get_attack_number_modifier_with_greater_distance_than_maximal_range()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getDistanceTable')
            ->andReturn($distanceTable = $this->mockery(DistanceTable::class));
        (new Armourer($tables))->getAttackNumberModifierByDistance(
            $this->createDistanceWithBonus(457, 987654321),
            $this->createEncounterRange(123),
            $this->createMaximalRange(456, 6655443322, $distanceTable)
        );
    }

    /**
     * @test
     * @dataProvider provideSizeAndExpectedAttackModifier
     * @param $sizeValue
     * @param $expectedModifier
     */
    public function I_can_get_attack_number_modifier_by_target_size($sizeValue, $expectedModifier)
    {
        self::assertSame(
            $expectedModifier,
            (new Armourer($this->createTables()))->getAttackNumberModifierBySize($this->createSize($sizeValue))
        );
    }

    public function provideSizeAndExpectedAttackModifier(): array
    {
        return [
            [-5, -3],
            [0, 0],
            [1, 1],
            [2, 1],
            [5, 3],
        ];
    }

    /**
     * @test
     * @dataProvider provideWeaponsForRangeEncounter
     * @param RangedWeaponCode $rangedWeaponCode
     * @param Tables $tables
     * @param int $strengthValue
     * @param int $speedValue
     * @param int $expectedEncounterRangeValue
     */
    public function I_can_get_encounter_range_of_any_range_weapon(
        RangedWeaponCode $rangedWeaponCode,
        Tables $tables,
        $strengthValue,
        $speedValue,
        $expectedEncounterRangeValue
    )
    {
        $armourer = new Armourer($tables);
        $encounterRangeWithWeaponlike = $armourer->getEncounterRangeWithWeaponlike(
            $rangedWeaponCode,
            Strength::getIt($strengthValue), $this->createSpeed($speedValue)
        );
        self::assertInstanceOf(EncounterRange::class, $encounterRangeWithWeaponlike);
        self::assertSame($expectedEncounterRangeValue, $encounterRangeWithWeaponlike->getValue());
    }

    public function provideWeaponsForRangeEncounter(): array
    {
        return [$this->provideBowForRangeEncounter()];
    }

    private function provideBowForRangeEncounter(): array
    {
        $tables = $this->createTables();
        $bow = $this->createRangedWeaponCode('bar', 'bow');
        $tables->shouldReceive('getRangedWeaponsTableByRangedWeaponCode')
            ->with($bow)
            ->andReturn($rangedWeaponsTable = $this->createRangedWeaponsTable());
        $rangedWeaponsTable->shouldReceive('getRangeOf')
            ->with($bow)
            ->andReturn(123); // base range

        $tables->shouldReceive('getBowsTable')
            ->andReturn($bowsTable = $this->createBowsTable());
        $bowsTable->shouldReceive('getMaximalApplicableStrengthOf')
            ->with($bow)
            ->andReturn(333); // bonus to range

        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($bow)
            ->andReturn($rangedWeaponsTable);
        $rangedWeaponsTable->shouldReceive('getRequiredStrengthOf')
            ->with($bow)
            ->andReturn(1000); // so missing strength would be (1000 - 456 = ) 544
        $tables->shouldReceive('getRangedWeaponStrengthSanctionsTable')
            ->andReturn($rangeWeaponSanctionsTable = $this->createRangedWeaponSanctionsTable());
        $rangeWeaponSanctionsTable->shouldReceive('getEncounterRangeSanction')
            ->with(544)
            ->andReturn(-258); // malus to range

        return [$bow, $tables, Strength::getIt(456), 789, 123 - 258 + 333];
    }

    /**
     * @return \Mockery\MockInterface|BowsTable
     */
    private function createBowsTable()
    {
        return $this->mockery(BowsTable::class);
    }

    /**
     * @param $value
     * @return \Mockery\MockInterface|Speed
     */
    private function createSpeed($value = null)
    {
        $speed = $this->mockery(Speed::class);
        if ($value !== null) {
            $speed->shouldReceive('getValue')
                ->andReturn($value);
        }

        return $speed;
    }

    /**
     * @test
     */
    public function I_get_always_zero_as_encounter_range_for_melee_weapon()
    {
        $armourer = new Armourer($this->createTables());
        foreach ($this->getMeleeWeaponlikeGroups() as $meleeWeaponlikeGroup) {
            $encounterRangeWithWeaponlike = $armourer->getEncounterRangeWithWeaponlike(
                $this->createMeleeWeaponlikeCode('foo', $meleeWeaponlikeGroup),
                $this->createStrength(),
                $this->createSpeed()
            );
            self::assertInstanceOf(EncounterRange::class, $encounterRangeWithWeaponlike);
            self::assertEquals(0, $encounterRangeWithWeaponlike->getValue());
        }
    }

    /**
     * @return \Mockery\MockInterface|Strength
     */
    private function createStrength()
    {
        return $this->mockery(Strength::class);
    }

    /**
     * @test
     * @dataProvider provideWeaponsForRangeEncounter
     * @param RangedWeaponCode $rangedWeaponCode
     * @param Tables $tables
     * @param int $strengthValue
     * @param int $speedValue
     * @param int $expectedEncounterRange
     */
    public function I_can_get_maximal_range_with_ranged_weapon(
        RangedWeaponCode $rangedWeaponCode,
        Tables $tables,
        $strengthValue,
        $speedValue,
        $expectedEncounterRange
    )
    {
        $maximalRange = (new Armourer($tables))->getMaximalRangeWithWeaponlike(
            $rangedWeaponCode,
            Strength::getIt($strengthValue),
            $this->createSpeed($speedValue)
        );

        self::assertInstanceOf(MaximalRange::class, $maximalRange);
        self::assertSame(
            MaximalRange::getItForRangedWeapon(EncounterRange::getIt($expectedEncounterRange))->getValue(),
            $maximalRange->getValue()
        );
    }

    /**
     * @test
     */
    public function I_can_get_maximal_range_same_as_encounter_for_melee_weapon()
    {
        $armourer = new Armourer($this->createTables());
        foreach ($this->getMeleeWeaponlikeGroups() as $meleeWeaponlikeGroup) {
            $maximalRange = $armourer->getMaximalRangeWithWeaponlike(
                $this->createMeleeWeaponlikeCode('foo', $meleeWeaponlikeGroup),
                $this->createStrength(),
                $this->createSpeed()
            );
            self::assertInstanceOf(MaximalRange::class, $maximalRange);
            self::assertSame(MaximalRange::getItForMeleeWeapon(EncounterRange::getIt(0))->getValue(), $maximalRange->getValue());
        }
    }

    /**
     * @test
     */
    public function I_can_find_out_if_can_hold_weapon_by_two_hands()
    {
        $armourer = new Armourer(Tables::getIt());
        // ranged
        self::assertTrue($armourer->canHoldItByTwoHands(RangedWeaponCode::getIt(RangedWeaponCode::LIGHT_CROSSBOW)));
        self::assertFalse($armourer->canHoldItByTwoHands(RangedWeaponCode::getIt(RangedWeaponCode::MINICROSSBOW)));
        // melee weapon
        self::assertTrue($armourer->canHoldItByTwoHands(MeleeWeaponCode::getIt(MeleeWeaponCode::AXE)));
        self::assertFalse($armourer->canHoldItByTwoHands(MeleeWeaponCode::getIt(MeleeWeaponCode::KNIFE)));
        self::assertTrue($armourer->canHoldItByTwoHands(MeleeWeaponCode::getIt(MeleeWeaponCode::HALBERD)));
        // shield
        self::assertFalse($armourer->canHoldItByTwoHands(ShieldCode::getIt(ShieldCode::BUCKLER)));
        self::assertFalse($armourer->canHoldItByTwoHands(ShieldCode::getIt(ShieldCode::PAVISE)));
    }

    /**
     * @return \Mockery\MockInterface|MeleeWeaponlikesTable
     */
    private function createMeleeWeaponlikesTable()
    {
        return $this->mockery(MeleeWeaponsTable::class);
    }

    /**
     * @test
     */
    public function I_can_find_out_if_can_hold_one_handed_weapon_by_two_hands()
    {
        $armourer = new Armourer(Tables::getIt());
        // one handed melee weapons longer than 1
        self::assertTrue($armourer->canHoldItByOneHandAsWellAsTwoHands(MeleeWeaponCode::getIt(MeleeWeaponCode::SHORT_SWORD)));
        self::assertTrue($armourer->canHoldItByOneHandAsWellAsTwoHands(MeleeWeaponCode::getIt(MeleeWeaponCode::AXE)));
        // shorter than 1
        self::assertFalse($armourer->canHoldItByOneHandAsWellAsTwoHands(MeleeWeaponCode::getIt(MeleeWeaponCode::HOBNAILED_BOOT)));
        self::assertFalse($armourer->canHoldItByOneHandAsWellAsTwoHands(ShieldCode::getIt(ShieldCode::HEAVY_SHIELD)));
        // not melee
        self::assertFalse($armourer->canHoldItByOneHandAsWellAsTwoHands(RangedWeaponCode::getIt(RangedWeaponCode::MILITARY_CROSSBOW)));
        // only both handed
        self::assertFalse($armourer->canHoldItByOneHandAsWellAsTwoHands(RangedWeaponCode::getIt(RangedWeaponCode::LONG_COMPOSITE_BOW)));
        self::assertFalse($armourer->canHoldItByOneHandAsWellAsTwoHands(MeleeWeaponCode::getIt(MeleeWeaponCode::HALBERD)));
    }

    /**
     * @test
     */
    public function I_can_get_required_strength_of_melee_weapons()
    {
        $tables = $this->createTables();
        $axe = $this->createMeleeWeaponCode('foo', 'axe');
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($axe)
            ->andReturn($axesTable = $this->createMeleeWeaponsTable());
        $axesTable->shouldReceive('getRequiredStrengthOf')
            ->with($axe)
            ->andReturn(123);
        self::assertSame(123, (new Armourer($tables))->getRequiredStrengthForArmament($axe));
    }

    /**
     * @test
     */
    public function I_can_get_required_strength_of_shield()
    {
        $tables = $this->createTables();
        $shield = $this->createShield();
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($shield)
            ->andReturn($shieldsTable = $this->createShieldsTable());
        $shieldsTable->shouldReceive('getRequiredStrengthOf')
            ->with($shield)
            ->andReturn(123);
        self::assertSame(123, (new Armourer($tables))->getRequiredStrengthForArmament($shield));
    }

    /**
     * @test
     */
    public function I_can_get_required_strength_of_range_weapons()
    {
        $tables = $this->createTables();
        $bow = $this->createRangedWeaponCode('foo', 'bow');
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($bow)
            ->andReturn($bowsTable = $this->createRangedWeaponsTable());
        $bowsTable->shouldReceive('getRequiredStrengthOf')
            ->with($bow)
            ->andReturn(123);
        self::assertSame(123, (new Armourer($tables))->getRequiredStrengthForArmament($bow));
    }

    /**
     * @test
     */
    public function I_can_get_length_of_melee_weapons_and_shields()
    {
        $tables = $this->createTables();
        $knife = $this->createMeleeWeaponlikeCode('foo', 'knifeOrDagger');
        $tables->shouldReceive('getMeleeWeaponlikeTableByMeleeWeaponlikeCode')
            ->with($knife)
            ->andReturn($knifesAndDaggersTable = $this->createMeleeWeaponsTable());
        $knifesAndDaggersTable->shouldReceive('getLengthOf')
            ->with($knife)
            ->andReturn(332);
        self::assertSame(332, (new Armourer($tables))->getLengthOfWeaponOrShield($knife));

        $shield = $this->createMeleeWeaponlikeCode('foo', 'shield');
        $tables->shouldReceive('getMeleeWeaponlikeTableByMeleeWeaponlikeCode')
            ->with($shield)
            ->andReturn($shieldsTable = $this->createMeleeWeaponsTable());
        $shieldsTable->shouldReceive('getLengthOf')
            ->with($shield)
            ->andReturn(123);
        self::assertSame(123, (new Armourer($tables))->getLengthOfWeaponOrShield($shield));
    }

    /**
     * @param $value
     * @param string $matchingMeleeWeaponlikeGroup
     * @return \Mockery\MockInterface|MeleeWeaponlikeCode
     */
    private function createMeleeWeaponlikeCode($value, $matchingMeleeWeaponlikeGroup)
    {
        $code = $this->mockery(MeleeWeaponlikeCode::class);
        $code->shouldReceive('getValue')
            ->andReturn($value);
        $code->shouldReceive('__toString')
            ->andReturn((string)$value);
        foreach ($this->getMeleeWeaponlikeGroups() as $meleeWeaponlikeGroup) {
            $code->shouldReceive('is' . ucfirst($meleeWeaponlikeGroup))
                ->andReturn($meleeWeaponlikeGroup === $matchingMeleeWeaponlikeGroup);
        }
        $code->shouldReceive('isMelee')
            ->andReturn(true);
        $code->shouldReceive('isMeleeWeapon')
            ->andReturn(true);

        return $code;
    }

    /**
     * @return array|string[]
     */
    private function getMeleeWeaponlikeGroups(): array
    {
        $meleeWeaponlikeGroups = $this->getMeleeWeaponGroups();
        $meleeWeaponlikeGroups[] = 'shield';

        return $meleeWeaponlikeGroups;
    }

    /**
     * @test
     */
    public function I_get_zero_as_length_of_ranged_weapons()
    {
        $crossbow = $this->createRangedWeaponCode('foo', 'crossbow');
        self::assertSame(0, (new Armourer($this->createTables()))->getLengthOfWeaponOrShield($crossbow));
    }

    /**
     * @test
     */
    public function I_can_get_offensiveness_of_melee_weapons()
    {
        $tables = $this->createTables();
        $club = $this->createMeleeWeaponCode('foo', 'maceOrClub');
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($club)
            ->andReturn($macesAndClubsTable = $this->createMeleeWeaponsTable());
        $macesAndClubsTable->shouldReceive('getOffensivenessOf')
            ->with($club)
            ->andReturn(123);
        self::assertSame(123, (new Armourer($tables))->getOffensivenessOfWeaponlike($club));
    }

    /**
     * @test
     */
    public function I_can_get_offensiveness_of_range_weapons()
    {
        $tables = $this->createTables();
        $crossbow = $this->createRangedWeaponCode('foo', 'crossbow');
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($crossbow)
            ->andReturn($rangedWeaponsTable = $this->createRangedWeaponsTable());
        $rangedWeaponsTable->shouldReceive('getOffensivenessOf')
            ->with($crossbow)
            ->andReturn(123);
        self::assertSame(123, (new Armourer($tables))->getOffensivenessOfWeaponlike($crossbow));
    }

    /**
     * @test
     */
    public function I_can_get_offensiveness_of_shield()
    {
        $tables = $this->createTables();
        $shield = $this->createShield();
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($shield)
            ->andReturn($shieldsTable = $this->createShieldsTable());
        $shieldsTable->shouldReceive('getOffensivenessOf')
            ->with($shield)
            ->andReturn(434);
        self::assertSame(434, (new Armourer($tables))->getOffensivenessOfWeaponlike($shield));
    }

    /**
     * @test
     */
    public function I_can_get_wounds_of_melee_weapons()
    {
        $tables = $this->createTables();
        $morgenstern = $this->createMeleeWeaponCode('foo', 'morningstarOrMorgenstern');
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($morgenstern)
            ->andReturn($morningstarsAndMorgensternsTable = $this->createMeleeWeaponsTable());
        $morningstarsAndMorgensternsTable->shouldReceive('getWoundsOf')
            ->with($morgenstern)
            ->andReturn(223);
        self::assertSame(223, (new Armourer($tables))->getWoundsOfWeaponlike($morgenstern));
    }

    /**
     * @test
     */
    public function I_can_get_wounds_of_range_weapons()
    {
        $tables = $this->createTables();
        $sling = $this->createRangedWeaponCode('foo', 'throwingWeapon');
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($sling)
            ->andReturn($throwingWeaponsTable = $this->createRangedWeaponsTable());
        $throwingWeaponsTable->shouldReceive('getWoundsOf')
            ->with($sling)
            ->andReturn(919);
        self::assertSame(919, (new Armourer($tables))->getWoundsOfWeaponlike($sling));
    }

    /**
     * @test
     */
    public function I_can_get_wounds_of_shield()
    {
        $tables = $this->createTables();
        $shield = $this->createShield();
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($shield)
            ->andReturn($shieldsTable = $this->createShieldsTable());
        $shieldsTable->shouldReceive('getWoundsOf')
            ->with($shield)
            ->andReturn(888);
        self::assertSame(888, (new Armourer($tables))->getWoundsOfWeaponlike($shield));
    }

    /**
     * @test
     */
    public function I_can_get_wounds_type_of_melee_weapons()
    {
        $tables = $this->createTables();
        $staff = $this->createMeleeWeaponCode('foo', 'staffOrSpear');
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($staff)
            ->andReturn($staffsAndSpearsTable = $this->createMeleeWeaponsTable());
        $staffsAndSpearsTable->shouldReceive('getWoundsTypeOf')
            ->with($staff)
            ->andReturn(678);
        self::assertSame(678, (new Armourer($tables))->getWoundsTypeOfWeaponlike($staff));
    }

    /**
     * @test
     */
    public function I_can_get_wounds_type_of_range_weapons()
    {
        $tables = $this->createTables();
        $shuriken = $this->createRangedWeaponCode('foo', 'throwingWeapon');
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($shuriken)
            ->andReturn($throwingWeaponsTable = $this->createRangedWeaponsTable());
        $throwingWeaponsTable->shouldReceive('getWoundsTypeOf')
            ->with($shuriken)
            ->andReturn(567);
        self::assertSame(567, (new Armourer($tables))->getWoundsTypeOfWeaponlike($shuriken));
    }

    /**
     * @test
     */
    public function I_can_get_wounds_type_of_shield()
    {
        $tables = $this->createTables();
        $shield = $this->createShield();
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($shield)
            ->andReturn($shieldsTable = $this->createShieldsTable());
        $shieldsTable->shouldReceive('getWoundsTypeOf')
            ->with($shield)
            ->andReturn(345);
        self::assertSame(345, (new Armourer($tables))->getWoundsTypeOfWeaponlike($shield));
    }

    /**
     * @test
     */
    public function I_can_get_cover_of_armament()
    {
        $tables = $this->createTables();

        $fist = $this->createMeleeWeaponCode('foo', 'unarmed');
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($fist)
            ->andReturn($unarmedTable = $this->createMeleeWeaponsTable());
        $unarmedTable->shouldReceive('getCoverOf')
            ->with($fist)
            ->andReturn(234);
        self::assertSame(234, (new Armourer($tables))->getCoverOfWeaponOrShield($fist));
    }

    /**
     * @test
     */
    public function I_get_cover_of_two_for_every_ranged_weapon_and_zero_for_projectile()
    {
        $armourer = new Armourer(Tables::getIt());
        foreach (RangedWeaponCode::getPossibleValues() as $rangedWeaponCode) {
            $rangedWeapon = RangedWeaponCode::getIt($rangedWeaponCode);
            if ($rangedWeapon->isProjectile()) {
                self::assertSame(0, $armourer->getCoverOfWeaponOrShield($rangedWeapon));
            } else {
                self::assertSame(
                    2,
                    $armourer->getCoverOfWeaponOrShield($rangedWeapon),
                    "'{$rangedWeapon}' should has cover of 2"
                );
            }
        }
    }

    /**
     * @test
     */
    public function I_can_get_weight_of_armament()
    {
        $tables = $this->createTables();
        $escalatorlibur = $this->createMeleeWeaponCode('foo', 'sword');
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($escalatorlibur)
            ->andReturn($swordsTable = $this->createMeleeWeaponsTable());
        $swordsTable->shouldReceive('getWeightOf')
            ->with($escalatorlibur)
            ->andReturn(123);
        self::assertSame(123, (new Armourer($tables))->getWeightOfArmament($escalatorlibur));
    }

    /**
     * @test
     */
    public function I_can_ask_if_weaponlike_has_to_be_hold_two_handed()
    {
        $tables = $this->createTables();
        $fork = $this->createMeleeWeaponCode('foo', 'staffOrSpear');
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($fork)
            ->andReturn($staffsAndSpearsTable = $this->createMeleeWeaponsTable());
        $staffsAndSpearsTable->shouldReceive('getTwoHandedOf')
            ->with($fork)
            ->andReturn(true);
        self::assertTrue((new Armourer($tables))->isTwoHandedOnly($fork));
    }

    /**
     * @test
     */
    public function I_can_ask_if_weaponlike_has_to_be_hold_one_handed()
    {
        $tables = $this->createTables();

        $fork = $this->createMeleeWeaponCode('foo', 'staffOrSpear');
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($fork)
            ->andReturn($staffsAndSpearsTable = $this->createMeleeWeaponsTable());
        $staffsAndSpearsTable->shouldReceive('getTwoHandedOf')
            ->with($fork)
            ->andReturn(true); // only two-handed
        self::assertFalse((new Armourer($tables))->isOneHandedOnly($fork), 'Fork has to be hold by both hands');

        $shortSword = $this->createMeleeWeaponCode('foo', 'sword');
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($shortSword)
            ->andReturn($swordsTable = $this->createMeleeWeaponsTable());
        $swordsTable->shouldReceive('getTwoHandedOf')
            ->with($shortSword)
            ->andReturn(false); // is not two-handed only
        $tables->shouldReceive('getMeleeWeaponlikeTableByMeleeWeaponlikeCode')
            ->with($shortSword)
            ->andReturn($swordsTable);
        $swordsTable->shouldReceive('getLengthOf')
            ->with($shortSword)
            ->andReturn(1);// long enough to be hold by two hands
        self::assertFalse((new Armourer($tables))->isOneHandedOnly($shortSword), 'Short sword can be hold by both hands');

        $stiletto = $this->createMeleeWeaponCode('foo', 'knifeOrDagger');
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($stiletto)
            ->andReturn($knifesAndDaggersTable = $this->createMeleeWeaponsTable());
        $knifesAndDaggersTable->shouldReceive('getTwoHandedOf')
            ->with($stiletto)
            ->andReturn(false); // is not two-handed only
        $tables->shouldReceive('getMeleeWeaponlikeTableByMeleeWeaponlikeCode')
            ->with($stiletto)
            ->andReturn($knifesAndDaggersTable);
        $knifesAndDaggersTable->shouldReceive('getLengthOf')
            ->with($stiletto)
            ->andReturn(0);// too short to be hold by two hands
        self::assertTrue((new Armourer($tables))->isOneHandedOnly($stiletto), 'Stiletto is too short to be hold by two hands');
    }

    /**
     * @test
     */
    public function I_can_get_restriction_of_protective_armament()
    {
        $tables = $this->createTables();
        $shield = $this->createShield();
        $tables->shouldReceive('getProtectiveArmamentsTable')
            ->with($shield)
            ->andReturn($shieldsTable = $this->createShieldsTable());
        $shieldsTable->shouldReceive('getRestrictionOf')
            ->with($shield)
            ->andReturn(123);
        self::assertSame(123, (new Armourer($tables))->getRestrictionOfProtectiveArmament($shield));
    }

    /**
     * @test
     */
    public function I_can_get_range_of_range_weapons()
    {
        $tables = $this->createTables();
        $bow = $this->createRangedWeaponCode('foo', 'bow');
        $tables->shouldReceive('getRangedWeaponsTableByRangedWeaponCode')
            ->with($bow)
            ->andReturn($bowsTable = $this->createRangedWeaponsTable());
        $bowsTable->shouldReceive('getRangeOf')
            ->with($bow)
            ->andReturn(123);
        self::assertSame(123, (new Armourer($tables))->getRangeOfRangedWeapon($bow));
    }

    // projectiles

    /**
     * @test
     */
    public function I_can_get_offensiveness_modifier_of_projectile()
    {
        $tables = $this->createTables();
        $projectileCode = $this->createProjectileCode();
        $tables->shouldReceive('getProjectilesTableByProjectiveCode')
            ->with($projectileCode)
            ->andReturn($projectilesTable = $this->createProjectilesTable());
        $projectilesTable->shouldReceive('getOffensivenessOf')
            ->with($projectileCode)
            ->andReturn(123);
        self::assertSame(123, (new Armourer($tables))->getOffensivenessModifierOfProjectile($projectileCode));
    }

    /**
     * @return \Mockery\MockInterface|ProjectileCode
     */
    private function createProjectileCode()
    {
        return $this->mockery(ProjectileCode::class);
    }

    /**
     * @return \Mockery\MockInterface|ProjectilesTable
     */
    private function createProjectilesTable()
    {
        return $this->mockery(ProjectilesTable::class);
    }

    /**
     * @test
     */
    public function I_can_get_wounds_modifier_of_projectile()
    {
        $tables = $this->createTables();
        $projectileCode = $this->createProjectileCode();
        $tables->shouldReceive('getProjectilesTableByProjectiveCode')
            ->with($projectileCode)
            ->andReturn($projectilesTable = $this->createProjectilesTable());
        $projectilesTable->shouldReceive('getWoundsOf')
            ->with($projectileCode)
            ->andReturn(9843);
        self::assertSame(9843, (new Armourer($tables))->getWoundsModifierOfProjectile($projectileCode));
    }

    /**
     * @test
     */
    public function I_can_get_wounds_type_of_projectile()
    {
        $tables = $this->createTables();
        $projectileCode = $this->createProjectileCode();
        $tables->shouldReceive('getProjectilesTableByProjectiveCode')
            ->with($projectileCode)
            ->andReturn($projectilesTable = $this->createProjectilesTable());
        $projectilesTable->shouldReceive('getWoundsTypeOf')
            ->with($projectileCode)
            ->andReturn(984153);
        self::assertSame(984153, (new Armourer($tables))->getWoundsTypeOfProjectile($projectileCode));
    }

    /**
     * @test
     */
    public function I_can_get_range_modifier_of_projectile()
    {
        $tables = $this->createTables();
        $projectileCode = $this->createProjectileCode();
        $tables->shouldReceive('getProjectilesTableByProjectiveCode')
            ->with($projectileCode)
            ->andReturn($projectilesTable = $this->createProjectilesTable());
        $projectilesTable->shouldReceive('getRangeOf')
            ->with($projectileCode)
            ->andReturn(3268);
        self::assertSame(3268, (new Armourer($tables))->getRangeModifierOfProjectile($projectileCode));
    }

    /**
     * @test
     */
    public function I_can_get_weight_of_projectile()
    {
        $tables = $this->createTables();
        $projectileCode = $this->createProjectileCode();
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($projectileCode)
            ->andReturn($projectilesTable = $this->createProjectilesTable());
        $projectilesTable->shouldReceive('getWeightOf')
            ->with($projectileCode)
            ->andReturn(123);
        self::assertSame(123, (new Armourer($tables))->getWeightOfArmament($projectileCode));
    }

    // strength effect

    /**
     * @test
     */
    public function I_can_get_applicable_strength_for_any_weapon()
    {
        $tables = $this->createTables();
        $bow = $this->createRangedWeaponCode('foo', 'bow');
        $tables->shouldReceive('getBowsTable')
            ->andReturn($bowsTable = $this->createBowsTable());
        $bowsTable->shouldReceive('getMaximalApplicableStrengthOf')
            ->with($bow)
            ->andReturn(4);
        $bowApplicableStrength = (new Armourer($tables))->getApplicableStrength($bow, Strength::getIt(5));
        self::assertInstanceOf(Strength::class, $bowApplicableStrength);
        self::assertSame(4, $bowApplicableStrength->getValue(), 'The lower strength should be used for a bow');

        $tables = $this->createTables();
        $anotherBow = $this->createRangedWeaponCode('bar', 'bow');
        $tables->shouldReceive('getBowsTable')
            ->andReturn($bowsTable = $this->createBowsTable());
        $bowsTable->shouldReceive('getMaximalApplicableStrengthOf')
            ->with($anotherBow)
            ->andReturn(6);
        self::assertSame(
            5,
            (new Armourer($tables))->getApplicableStrength($anotherBow, Strength::getIt(5))->getValue(),
            'The lower strength should be used for a bow'
        );

        $tables = $this->createTables();
        $crossbow = $this->createRangedWeaponCode('foo', 'crossbow');
        $tables->shouldReceive('getCrossbowsTable')
            ->andReturn($crossbowsTable = $this->createCrossbowsTable());
        $crossbowsTable->shouldReceive('getRequiredStrengthOf')
            ->with($crossbow)
            ->andReturn(123);
        $requiredStrength = Strength::getIt(123);
        self::assertSame(
            $requiredStrength->getValue(),
            (new Armourer($tables))->getApplicableStrength($crossbow, Strength::getIt(55))->getValue(),
            'The crossbow required strength should be used instead'
        );

        $axe = $this->createMeleeWeaponCode('foo', 'axe');
        $currentStrength = Strength::getIt(789);
        self::assertSame(
            $currentStrength->getValue(),
            (new Armourer($tables))->getApplicableStrength($axe, $currentStrength)->getValue(),
            'Only bows should be limited by applicable strength'
        );
    }

    /**
     * @return \Mockery\MockInterface|CrossbowsTable
     */
    private function createCrossbowsTable()
    {
        return $this->mockery(CrossbowsTable::class);
    }

    // MISSING WEAPON SKILL

    /**
     * @test
     */
    public function I_can_get_malus_to_fight_number()
    {
        $tables = $this->createTables();
        $skillRank = $this->createPositiveInteger(123);
        $tables->shouldReceive('getMissingWeaponSkillTable')
            ->andReturn($missingWeaponSkillTable = $this->mockery(MissingWeaponSkillTable::class));
        $missingWeaponSkillTable->shouldReceive('getFightNumberMalusForSkillRank')
            ->with(123)
            ->andReturn(125);
        self::assertSame(125, (new Armourer($tables))->getFightNumberMalusForSkillRank($skillRank));
    }

    /**
     * @param mixed $value
     * @return \Mockery\MockInterface|PositiveInteger
     */
    private function createPositiveInteger($value = null)
    {
        $positiveInteger = $this->mockery(PositiveInteger::class);
        if ($value !== null) {
            $positiveInteger->shouldReceive('getValue')
                ->andReturn($value);
        }

        return $positiveInteger;
    }

    /**
     * @test
     */
    public function I_can_get_malus_to_attack_number_by_skill_rank()
    {
        $tables = $this->createTables();
        $skillRank = $this->createPositiveInteger(123);
        $tables->shouldReceive('getMissingWeaponSkillTable')
            ->andReturn($missingWeaponSkillTable = $this->mockery(MissingWeaponSkillTable::class));
        $missingWeaponSkillTable->shouldReceive('getAttackNumberMalusForSkillRank')
            ->with(123)
            ->andReturn(5702);
        self::assertSame(5702, (new Armourer($tables))->getAttackNumberMalusForSkillRank($skillRank));
    }

    /**
     * @test
     */
    public function I_can_get_malus_to_cover_by_skill_rank()
    {
        $tables = $this->createTables();

        $tables->shouldReceive('getMissingWeaponSkillTable')
            ->andReturn($missingWeaponSkillTable = $this->mockery(MissingWeaponSkillTable::class));
        $missingWeaponSkillTable->shouldReceive('getCoverMalusForSkillRank')
            ->with(123)
            ->andReturn(98432);
        self::assertSame(
            98432,
            (new Armourer($tables))->getCoverMalusForSkillRank(
                $this->createPositiveInteger(123),
                $this->createMeleeWeaponCode('foo', 'knifeOrDagger')
            )
        );

        $tables->shouldReceive('getShieldUsageSkillTable')
            ->andReturn($shieldUsageSkillTable = $this->mockery(ShieldUsageSkillTable::class));
        $shieldUsageSkillTable->shouldReceive('getCoverMalusForSkillRank')
            ->with(456)
            ->andReturn(1249);
        self::assertSame(
            1249,
            (new Armourer($tables))->getCoverMalusForSkillRank(
                $this->createPositiveInteger(456),
                $this->createShield()
            )
        );
    }

    /**
     * @test
     */
    public function I_can_get_malus_to_base_of_wounds_by_skill_rank()
    {
        $tables = $this->createTables();
        $skillRank = $this->createPositiveInteger(123);
        $tables->shouldReceive('getMissingWeaponSkillTable')
            ->andReturn($missingWeaponSkillTable = $this->mockery(MissingWeaponSkillTable::class));
        $missingWeaponSkillTable->shouldReceive('getBaseOfWoundsMalusForSkillRank')
            ->with(123)
            ->andReturn(112);
        self::assertSame(112, (new Armourer($tables))->getBaseOfWoundsMalusForSkillRank($skillRank));
    }

    /**
     * @test
     */
    public function I_can_get_protective_armament_restriction_bonus_by_skill_rank()
    {
        $tables = $this->createTables();
        $skillRank = $this->createPositiveInteger(123);
        $shield = $this->createShield();
        $tables->shouldReceive('getProtectiveArmamentMissingSkillTableByCode')
            ->with($shield)
            ->andReturn($shieldUsageSkillTable = $this->mockery(ShieldUsageSkillTable::class));
        $shieldUsageSkillTable->shouldReceive('getRestrictionBonusForSkillRank')
            ->with(123)
            ->andReturn(4441);
        self::assertSame(
            4441,
            (new Armourer($tables))->getProtectiveArmamentRestrictionBonusForSkillRank($shield, $skillRank)
        );
    }

    /**
     * @test
     */
    public function I_can_get_protective_armament_restriction_by_skill_rank()
    {
        $tables = $this->createTables();
        $shield = $this->createShield();

        $tables->shouldReceive('getProtectiveArmamentsTable')
            ->with($shield)
            ->andReturn($shieldsTable = $this->createShieldsTable());
        $shieldsTable->shouldReceive('getRestrictionOf')
            ->with($shield)
            ->andReturn(-11);

        $skillRank = $this->createPositiveInteger(123);
        $tables->shouldReceive('getProtectiveArmamentMissingSkillTableByCode')
            ->with($shield)
            ->andReturn($shieldUsageSkillTable = $this->mockery(ShieldUsageSkillTable::class));
        $shieldUsageSkillTable->shouldReceive('getRestrictionBonusForSkillRank')
            ->with(123)
            ->andReturn(7);

        self::assertSame(-4, (new Armourer($tables))->getProtectiveArmamentRestrictionForSkillRank($shield, $skillRank));
    }

    /**
     * @test
     */
    public function I_can_get_zero_as_protective_armament_restriction_by_skill_rank_if_would_result_to_positive()
    {
        $tables = $this->createTables();
        $shield = $this->createShield();

        $tables->shouldReceive('getProtectiveArmamentsTable')
            ->with($shield)
            ->andReturn($shieldsTable = $this->createShieldsTable());
        $shieldsTable->shouldReceive('getRestrictionOf')
            ->with($shield)
            ->andReturn(456);

        $skillRank = $this->createPositiveInteger(123);
        $tables->shouldReceive('getProtectiveArmamentMissingSkillTableByCode')
            ->with($shield)
            ->andReturn($missingShieldSkillTable = $this->mockery(MissingProtectiveArmamentSkill::class));
        $missingShieldSkillTable->shouldReceive('getRestrictionBonusForSkillRank')
            ->with(123)
            ->andReturn(789);

        self::assertSame(0, (new Armourer($tables))->getProtectiveArmamentRestrictionForSkillRank($shield, $skillRank));
    }

    /**
     * @test
     */
    public function I_can_get_base_of_wounds_for_used_weapon_with_current_strength()
    {
        $axe = $this->createMeleeWeaponCode('foo', 'axe');
        $currentStrength = Strength::getIt(123);
        $tables = $this->createTables();
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($axe)
            ->andReturn($meleeWeaponlikesTable = $this->createMeleeWeaponlikesTable());
        $meleeWeaponlikesTable->shouldReceive('getWoundsOf')
            ->with($axe)
            ->andReturn(789);
        $tables->shouldReceive('getBaseOfWoundsTable')
            ->andReturn($baseOfWoundsTable = $this->mockery(BaseOfWoundsTable::class));
        /** @noinspection PhpUnusedParameterInspection */
        $baseOfWoundsTable->shouldReceive('getBaseOfWounds')
            ->with($currentStrength, $this->type(IntegerInterface::class))
            ->andReturnUsing(function (Strength $currentStrength, IntegerInterface $weaponBaseOfWounds) {
                self::assertSame(789, $weaponBaseOfWounds->getValue());

                return 456;
            });
        $tables->shouldReceive('getWeaponlikeStrengthSanctionsTableByCode')
            ->andReturn($meleeWeaponSanctionsTable = $this->createMeleeWeaponSanctionsTable());
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($axe)
            ->andReturn($meleeWeaponlikesTable);
        $meleeWeaponlikesTable->shouldReceive('getRequiredStrengthOf')
            ->with($axe)
            ->andReturn(555);
        $meleeWeaponSanctionsTable->shouldReceive('getBaseOfWoundsSanction')
            ->with(555 - 123)
            ->andReturn(234);

        self::assertSame(456 + 234, (new Armourer($tables))->getBaseOfWoundsUsingWeaponlike($axe, $currentStrength));
    }

    /**
     * @test
     */
    public function I_can_get_base_of_wounds_bonus_for_two_hand_holding_of_one_hand_melee_weapon()
    {
        $tables = $this->createTables();
        $armourer = new Armourer($tables);
        self::assertSame(
            0,
            $armourer->getBaseOfWoundsBonusForHolding($this->createMeleeWeaponlikeCode('foo', 'bar'), false)
        );

        $bow = $this->createRangedWeaponCode('foo', 'bow');
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($bow)
            ->andReturn($rangedWeaponsTable = $this->createRangedWeaponsTable());
        $rangedWeaponsTable->shouldReceive('getTwoHandedOf')
            ->with($bow)
            ->andReturn(true);
        self::assertSame(0, $armourer->getBaseOfWoundsBonusForHolding($bow, true));

        $pike = $this->createMeleeWeaponCode('foo', 'staffOrSpear');
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($pike)
            ->andReturn($meleeWeaponlikesTable = $this->createMeleeWeaponlikesTable());
        $meleeWeaponlikesTable->shouldReceive('getTwoHandedOf')
            ->with($pike)
            ->andReturn(true);
        self::assertSame(0, $armourer->getBaseOfWoundsBonusForHolding($pike, true));

        $shortSword = $this->createMeleeWeaponCode('foo', 'sword');
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($shortSword)
            ->andReturn($meleeWeaponlikesTable = $this->createMeleeWeaponlikesTable());
        $meleeWeaponlikesTable->shouldReceive('getTwoHandedOf')
            ->with($shortSword)
            ->andReturn(false);
        $tables->shouldReceive('getMeleeWeaponlikeTableByMeleeWeaponlikeCode')
            ->with($shortSword)
            ->andReturn($meleeWeaponlikesTable);
        $meleeWeaponlikesTable->shouldReceive('getLengthOf')
            ->with($shortSword)
            ->andReturn(1);
        self::assertSame(2, $armourer->getBaseOfWoundsBonusForHolding($shortSword, true));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\CanNotHoldWeaponByTwoHands
     * @expectedExceptionMessageRegExp ~stiletto~
     */
    public function I_can_not_get_base_of_wounds_bonus_for_too_short_melee_weapon()
    {
        $tables = $this->createTables();
        $dagger = $this->createMeleeWeaponCode('stiletto', 'knifeOrDagger');
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($dagger)
            ->andReturn($meleeWeaponlikesTable = $this->createMeleeWeaponlikesTable());
        $meleeWeaponlikesTable->shouldReceive('getTwoHandedOf')
            ->with($dagger)
            ->andReturn(false);
        $tables->shouldReceive('getMeleeWeaponlikeTableByMeleeWeaponlikeCode')
            ->with($dagger)
            ->andReturn($meleeWeaponlikesTable);
        $meleeWeaponlikesTable->shouldReceive('getLengthOf')
            ->with($dagger)
            ->andReturn(0);
        self::assertSame(0, (new Armourer($tables))->getBaseOfWoundsBonusForHolding($dagger, true));
    }

}