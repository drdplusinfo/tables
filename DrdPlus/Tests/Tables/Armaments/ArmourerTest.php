<?php
namespace DrdPlus\Tests\Tables\Armaments;

use DrdPlus\Codes\Armaments\BodyArmorCode;
use DrdPlus\Codes\Armaments\HelmCode;
use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Codes\Armaments\ShieldCode;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Body\Size;
use DrdPlus\Properties\Derived\Speed;
use DrdPlus\Tables\Armaments\Armors\ArmorStrengthSanctionsTable;
use DrdPlus\Tables\Armaments\Armourer;
use DrdPlus\Tables\Armaments\Partials\AbstractArmamentsTable;
use DrdPlus\Tables\Armaments\Shields\ShieldStrengthSanctionsTable;
use DrdPlus\Tables\Armaments\Shields\ShieldsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\MeleeWeaponStrengthSanctionsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Ranged\RangedWeaponStrengthSanctionsTable;
use DrdPlus\Tables\Tables;
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
            ->andReturn('bar');
        self::assertSame('bar', $armourer->canUseArmament($bodyArmorCode, Strength::getIt(1), Size::getIt(2)));
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
            ->andReturn('baz');
        self::assertSame('baz', $armourer->canUseArmament($axe, Strength::getIt(-4), $this->mockery(Size::class)));
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
            ->andReturn('qux');
        self::assertSame('qux', $armourer->canUseArmament($bow, Strength::getIt(1), $this->mockery(Size::class)));
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
            ->andReturn('foo bar');
        self::assertSame('foo bar', $armourer->canUseArmament($shield, Strength::getIt(12), $this->mockery(Size::class)));
    }

    /**
     * @return \Mockery\MockInterface|ShieldCode
     */
    private function createShield()
    {
        return $this->mockery(ShieldCode::class);
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
            ->andReturn('qux');
        self::assertSame(
            'qux',
            $armourer->getSanctionDescriptionByStrengthWithArmor($helmCode, Strength::getIt($strength), Size::getIt($bodySize))
        );
        $armorSanctionsTable->shouldReceive('getAgilityMalus')
            ->with($expectedMissingStrength)
            ->andReturn('qux');
        self::assertSame(
            'qux',
            $armourer->getAgilityMalusByStrengthWithArmor($bodyArmorCode, Strength::getIt($strength), Size::getIt($bodySize))
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
            ->andReturn($meleeWeaponTable = $this->createMeleeWeaponTable());
        $meleeWeaponTable->shouldReceive('getRequiredStrengthOf')
            ->with($meleeWeaponCode)
            ->andReturn($requiredStrength);
        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForArmament($meleeWeaponCode, Strength::getIt($strength), $this->mockery(Size::class))
        );

        $tables->shouldReceive('getWeaponlikeStrengthSanctionsTableByCode')
            ->andReturn($meleeWeaponSanctionsTable = $this->createMeleeWeaponSanctionsTable());

        $meleeWeaponSanctionsTable->shouldReceive('getFightNumberSanction')
            ->with($expectedMissingStrength)
            ->andReturn('baz');
        self::assertSame(
            'baz',
            $armourer->getFightNumberMalusByStrengthWithWeaponlike($meleeWeaponCode, Strength::getIt($strength))
        );

        $meleeWeaponSanctionsTable->shouldReceive('getAttackNumberSanction')
            ->with($expectedMissingStrength)
            ->andReturn('qux');
        self::assertSame(
            'qux',
            $armourer->getAttackNumberMalusByStrengthWithWeaponlike($meleeWeaponCode, Strength::getIt($strength))
        );

        $tables->shouldReceive('getMeleeWeaponlikeCodeStrengthSanctionsTableByCode')
            ->andReturn($meleeWeaponSanctionsTable);
        $meleeWeaponSanctionsTable->shouldReceive('getDefenseNumberSanction')
            ->with($expectedMissingStrength)
            ->andReturn('foobar');
        self::assertSame(
            'foobar',
            $armourer->getDefenseNumberMalusByStrengthWithWeaponlike($meleeWeaponCode, Strength::getIt($strength))
        );

        $meleeWeaponSanctionsTable->shouldReceive('getBaseOfWoundsSanction')
            ->with($expectedMissingStrength)
            ->andReturn('foobaz');
        self::assertSame(
            'foobaz',
            $armourer->getBaseOfWoundsMalusByStrengthWithWeaponlike($meleeWeaponCode, Strength::getIt($strength))
        );

        $tables->shouldReceive('getArmamentStrengthSanctionsTableByCode')
            ->andReturn($meleeWeaponSanctionsTable);
        $meleeWeaponSanctionsTable->shouldReceive('canUseIt')
            ->with($expectedMissingStrength)
            ->andReturn('fooqux');
        self::assertSame(
            'fooqux',
            $armourer->canUseArmament($meleeWeaponCode, Strength::getIt($strength), $this->mockery(Size::class))
        );
    }

    public function provideStrengthAndMeleeWeaponGroup()
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
    private function createMeleeWeaponTable()
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

        return $code;
    }

    /**
     * @return array|string[]
     */
    private function getMeleeWeaponGroups()
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
        $rangedSpear = $this->mockery(RangedWeaponCode::class);
        $rangedSpear->shouldReceive('isMelee')
            ->andReturn(true);
        $rangedSpear->shouldReceive('convertToMeleeWeaponCodeEquivalent')
            ->andReturn($meleeSpear = $this->mockery(MeleeWeaponCode::class));
        $tables->shouldReceive('getMeleeWeaponlikeCodeStrengthSanctionsTableByCode')
            ->andReturn($meleeWeaponSanctionsTable);
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($meleeSpear)
            ->andReturn($meleeWeaponTable = $this->createMeleeWeaponTable());
        $meleeWeaponTable->shouldReceive('getRequiredStrengthOf')
            ->with($meleeSpear)
            ->andReturn(5);
        $meleeWeaponSanctionsTable->shouldReceive('getDefenseNumberSanction')
            ->with(5)
            ->andReturn('foobar');
        self::assertSame(
            'foobar',
            $armourer->getDefenseNumberMalusByStrengthWithWeaponlike($rangedSpear, Strength::getIt(0))
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
            $armourer->getMissingStrengthForArmament($shield, Strength::getIt(4), $this->mockery(Size::class))
        );
        $tables->shouldReceive('getArmamentStrengthSanctionsTableByCode')
            ->with($shield)
            ->andReturn($shieldStrengthSanctionsTable = $this->mockery(ShieldStrengthSanctionsTable::class));

        $tables->shouldReceive('getWeaponlikeStrengthSanctionsTableByCode')
            ->with($shield)
            ->andReturn($shieldStrengthSanctionsTable);

        $shieldStrengthSanctionsTable->shouldReceive('getFightNumberSanction')
            ->with(1 /* required strength - strength */)
            ->andReturn('baz');
        self::assertSame(
            'baz',
            $armourer->getFightNumberMalusByStrengthWithWeaponlike($shield, Strength::getIt(4))
        );

        $shieldStrengthSanctionsTable->shouldReceive('getAttackNumberSanction')
            ->with(2 /* required strength - strength */)
            ->andReturn('qux');
        self::assertSame(
            'qux',
            $armourer->getAttackNumberMalusByStrengthWithWeaponlike($shield, Strength::getIt(3))
        );

        $tables->shouldReceive('getMeleeWeaponlikeCodeStrengthSanctionsTableByCode')
            ->andReturn($shieldStrengthSanctionsTable);
        $shieldStrengthSanctionsTable->shouldReceive('getDefenseNumberSanction')
            ->with(3 /* required strength - strength */)
            ->andReturn('foobar');
        self::assertSame(
            'foobar',
            $armourer->getDefenseNumberMalusByStrengthWithWeaponlike($shield, Strength::getIt(2))
        );

        $shieldStrengthSanctionsTable->shouldReceive('getBaseOfWoundsSanction')
            ->with(4 /* required strength - strength */)
            ->andReturn('foobaz');
        self::assertSame(
            'foobaz',
            $armourer->getBaseOfWoundsMalusByStrengthWithWeaponlike($shield, Strength::getIt(1))
        );

        $shieldStrengthSanctionsTable->shouldReceive('canUseIt')
            ->with(8 /* required strength - strength */)
            ->andReturn('fooqux');
        self::assertSame(
            'fooqux',
            $armourer->canUseArmament($shield, Strength::getIt(-3), $this->mockery(Size::class))
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
            $armourer->getMissingStrengthForArmament($weaponlikeCode, Strength::getIt($strength), $this->mockery(Size::class))
        );
        $tables->shouldReceive('getArmamentStrengthSanctionsTableByCode')
            ->andReturn($rangeWeaponSanctionsTable = $this->createRangedWeaponSanctionsTable());

        $rangeWeaponSanctionsTable->shouldReceive('canUseIt')
            ->with($expectedMissingStrength)
            ->andReturn('bazbaz');
        self::assertSame(
            'bazbaz',
            $armourer->canUseArmament($weaponlikeCode, Strength::getIt($strength), $this->mockery(Size::class))
        );

        $tables->shouldReceive('getWeaponlikeStrengthSanctionsTableByCode')
            ->andReturn($rangeWeaponSanctionsTable);
        $rangeWeaponSanctionsTable->shouldReceive('getFightNumberSanction')
            ->with($expectedMissingStrength)
            ->andReturn('baz');
        self::assertSame(
            'baz',
            $armourer->getFightNumberMalusByStrengthWithWeaponlike($weaponlikeCode, Strength::getIt($strength))
        );

        $rangeWeaponSanctionsTable->shouldReceive('getAttackNumberSanction')
            ->with($expectedMissingStrength)
            ->andReturn('qux');
        self::assertSame(
            'qux',
            $armourer->getAttackNumberMalusByStrengthWithWeaponlike($weaponlikeCode, Strength::getIt($strength))
        );

        $rangeWeaponSanctionsTable->shouldReceive('getDefenseNumberSanction')
            ->with($expectedMissingStrength)
            ->andReturn('bar bar');
        self::assertSame(
            'bar bar',
            $armourer->getDefenseNumberMalusByStrengthWithWeaponlike($weaponlikeCode, Strength::getIt($strength))
        );

        $tables->shouldReceive('getRangedWeaponStrengthSanctionsTable')
            ->andReturn($rangeWeaponSanctionsTable);
        $rangeWeaponSanctionsTable->shouldReceive('getLoadingInRounds')
            ->with($expectedMissingStrength)
            ->andReturn('foobar');
        self::assertSame(
            'foobar',
            $armourer->getLoadingInRoundsByStrengthWithRangedWeapon($weaponlikeCode, Strength::getIt($strength))
        );

        $rangeWeaponSanctionsTable->shouldReceive('getLoadingInRoundsSanction')
            ->with($expectedMissingStrength)
            ->andReturn('foobaz');
        self::assertSame(
            'foobaz',
            $armourer->getLoadingInRoundsMalusByStrengthWithRangedWeapon($weaponlikeCode, Strength::getIt($strength))
        );

        $rangeWeaponSanctionsTable->shouldReceive('getBaseOfWoundsSanction')
            ->with($expectedMissingStrength)
            ->andReturn('foobarbar');
        self::assertSame(
            'foobarbar',
            $armourer->getBaseOfWoundsMalusByStrengthWithWeaponlike($weaponlikeCode, Strength::getIt($strength))
        );
    }

    public function provideStrengthAndRangedWeaponGroup()
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
     * @param bool $isMeleeArmament
     * @return \Mockery\MockInterface|RangedWeaponCode
     */
    private function createRangedWeaponCode($value, $matchingWeaponGroup, $isMeleeArmament = false)
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
        $code->shouldReceive('isMelee')
            ->andReturn($isMeleeArmament);

        return $code;
    }

    private function getRangedWeaponGroups()
    {
        return ['bow', 'arrow', 'crossbow', 'dart', 'throwingWeapon', 'slingStone'];
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
    public function I_can_get_encounter_range_of_any_range_weapon(
        RangedWeaponCode $rangedWeaponCode,
        Tables $tables,
        $strengthValue,
        $speedValue,
        $expectedEncounterRange
    )
    {
        $armourer = new Armourer($tables);
        self::assertSame(
            $expectedEncounterRange,
            $armourer->getEncounterRangeWithRangedWeapon($rangedWeaponCode, Strength::getIt($strengthValue), $this->createSpeed($speedValue))
        );
    }

    public function provideWeaponsForRangeEncounter()
    {
        return [
            $this->provideArrowForRangeEncounter(),
            $this->provideBowForRangeEncounter(),
        ];
    }

    private function provideArrowForRangeEncounter()
    {
        $tables = $this->createTables();
        $arrow = $this->createRangedWeaponCode('foo', 'arrow');
        $tables->shouldReceive('getRangedWeaponsTableByRangedWeaponCode')
            ->with($arrow)
            ->andReturn($rangedWeaponsTable = $this->createRangedWeaponsTable());
        $rangedWeaponsTable->shouldReceive('getRangeOf')
            ->with($arrow)
            ->andReturn(123);

        return [$arrow, $tables, Strength::getIt(456), 789, 123];
    }

    private function provideBowForRangeEncounter()
    {
        $tables = $this->createTables();
        $bow = $this->createRangedWeaponCode('bar', 'bow');
        $tables->shouldReceive('getRangedWeaponsTableByRangedWeaponCode')
            ->with($bow)
            ->andReturn($rangedWeaponsTable = $this->createRangedWeaponsTable());
        $rangedWeaponsTable->shouldReceive('getRangeOf')
            ->with($bow)
            ->andReturn(123);
        $tables->shouldReceive('getBowsTable')
            ->andReturn($bowsTable = $this->createRangedWeaponsTable());
        $bowsTable->shouldReceive('getMaximalApplicableStrengthOf')
            ->with($bow)
            ->andReturn(111); // de facto final strength because its smaller than current strength (456)
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($bow)
            ->andReturn($rangedWeaponsTable);
        $rangedWeaponsTable->shouldReceive('getRequiredStrengthOf')
            ->with($bow)
            ->andReturn(1000); // so missing strength would be (1000 - 111 = ) 899
        $tables->shouldReceive('getRangedWeaponStrengthSanctionsTable')
            ->andReturn($rangeWeaponSanctionsTable = $this->createRangedWeaponSanctionsTable());
        $rangeWeaponSanctionsTable->shouldReceive('getEncounterRangeSanction')
            ->with(889)
            ->andReturn(-333);
        $bowsTable->shouldReceive('getMaximalApplicableStrengthOf')
            ->with($bow)
            ->andReturn();

        return [$bow, $tables, Strength::getIt(456), 789, 123 - 333 + 111];
    }

    /**
     * @param $value
     * @return \Mockery\MockInterface|Speed
     */
    private function createSpeed($value)
    {
        $speed = $this->mockery(Speed::class);
        $speed->shouldReceive('getValue')
            ->andReturn($value);

        return $speed;
    }

    /**
     * @test
     */
    public function I_can_find_out_if_can_hold_weapon_by_two_hands()
    {
        $armourer = new Armourer(new Tables());
        // ranged
        self::assertTrue($armourer->canHoldItByTwoHands(RangedWeaponCode::getIt(RangedWeaponCode::LIGHT_CROSSBOW)));
        self::assertFalse($armourer->canHoldItByTwoHands(RangedWeaponCode::getIt(RangedWeaponCode::MINICROSSBOW)));
        self::assertFalse($armourer->canHoldItByTwoHands(RangedWeaponCode::getIt(RangedWeaponCode::CRIPPLING_ARROW)));
        // melee weapon
        self::assertTrue($armourer->canHoldItByTwoHands(MeleeWeaponCode::getIt(MeleeWeaponCode::AXE)));
        self::assertFalse($armourer->canHoldItByTwoHands(MeleeWeaponCode::getIt(MeleeWeaponCode::KNIFE)));
        self::assertTrue($armourer->canHoldItByTwoHands(MeleeWeaponCode::getIt(MeleeWeaponCode::HALBERD)));
        // shield
        self::assertFalse($armourer->canHoldItByTwoHands(ShieldCode::getIt(ShieldCode::BUCKLER)));
        self::assertFalse($armourer->canHoldItByTwoHands(ShieldCode::getIt(ShieldCode::PAVISE)));
    }

    /**
     * @test
     */
    public function I_can_find_out_if_weapon_code_means_empty_hand()
    {
        $armourer = new Armourer(new Tables());
        self::assertTrue($armourer->hasEmptyHand(MeleeWeaponCode::getIt(MeleeWeaponCode::HAND)));
        self::assertTrue($armourer->hasEmptyHand(MeleeWeaponCode::getIt(MeleeWeaponCode::LEG)));
        self::assertTrue($armourer->hasEmptyHand(MeleeWeaponCode::getIt(MeleeWeaponCode::HOBNAILED_BOOT)));
        self::assertTrue($armourer->hasEmptyHand(ShieldCode::getIt(ShieldCode::WITHOUT_SHIELD)));
        self::assertFalse($armourer->hasEmptyHand(RangedWeaponCode::getIt(RangedWeaponCode::BASIC_ARROW)));
        self::assertFalse($armourer->hasEmptyHand(RangedWeaponCode::getIt(RangedWeaponCode::LONG_COMPOSITE_BOW)));
        self::assertFalse($armourer->hasEmptyHand(MeleeWeaponCode::getIt(MeleeWeaponCode::CUDGEL)));
        self::assertFalse($armourer->hasEmptyHand(ShieldCode::getIt(ShieldCode::BUCKLER)));
    }

    /**
     * @test
     */
    public function I_can_find_out_if_can_hold_one_handed_weapon_by_two_hands()
    {
        $armourer = new Armourer(new Tables());
        // one handed melee weapons longer than 1
        self::assertTrue($armourer->canHoldItByOneHandAsWellAsTwoHands(MeleeWeaponCode::getIt(MeleeWeaponCode::SHORT_SWORD)));
        self::assertTrue($armourer->canHoldItByOneHandAsWellAsTwoHands(MeleeWeaponCode::getIt(MeleeWeaponCode::AXE)));
        // shorter than 1
        self::assertFalse($armourer->canHoldItByOneHandAsWellAsTwoHands(MeleeWeaponCode::getIt(MeleeWeaponCode::HOBNAILED_BOOT)));
        self::assertFalse($armourer->canHoldItByOneHandAsWellAsTwoHands(ShieldCode::getIt(ShieldCode::HEAVY_SHIELD)));
        // not melee
        self::assertFalse($armourer->canHoldItByOneHandAsWellAsTwoHands(RangedWeaponCode::getIt(RangedWeaponCode::BASIC_ARROW)));
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
            ->andReturn($axesTable = $this->createMeleeWeaponTable());
        $axesTable->shouldReceive('getRequiredStrengthOf')
            ->with($axe)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getRequiredStrengthForArmament($axe));
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
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getRequiredStrengthForArmament($shield));
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
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getRequiredStrengthForArmament($bow));
    }

    /**
     * @test
     */
    public function I_can_get_length_of_melee_weapons()
    {
        $tables = $this->createTables();
        $knife = $this->createMeleeWeaponCode('foo', 'knifeOrDagger');
        $tables->shouldReceive('getMeleeWeaponlikeTableByMeleeWeaponlikeCode')
            ->with($knife)
            ->andReturn($knifesAndDaggersTable = $this->createMeleeWeaponTable());
        $knifesAndDaggersTable->shouldReceive('getLengthOf')
            ->with($knife)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getLengthOfWeaponlike($knife));
    }

    /**
     * @test
     */
    public function I_get_zero_as_length_of_ranged_weapons()
    {
        $crossbow = $this->createRangedWeaponCode('foo', 'crossbow');
        self::assertSame(0, (new Armourer($this->createTables()))->getLengthOfWeaponlike($crossbow));
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
            ->andReturn($macesAndClubsTable = $this->createMeleeWeaponTable());
        $macesAndClubsTable->shouldReceive('getOffensivenessOf')
            ->with($club)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getOffensivenessOfWeaponlike($club));
    }

    /**
     * @test
     */
    public function I_can_get_offensiveness_of_range_weapons()
    {
        $tables = $this->createTables();
        $slingStone = $this->createRangedWeaponCode('foo', 'slingStone');
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($slingStone)
            ->andReturn($slingStonesTable = $this->createRangedWeaponsTable());
        $slingStonesTable->shouldReceive('getOffensivenessOf')
            ->with($slingStone)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getOffensivenessOfWeaponlike($slingStone));
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
            ->andReturn('foo');
        self::assertSame('foo', (new Armourer($tables))->getOffensivenessOfWeaponlike($shield));
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
            ->andReturn($morningstarsAndMorgensternsTable = $this->createMeleeWeaponTable());
        $morningstarsAndMorgensternsTable->shouldReceive('getWoundsOf')
            ->with($morgenstern)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getWoundsOfWeaponlike($morgenstern));
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
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getWoundsOfWeaponlike($sling));
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
            ->andReturn('foo');
        self::assertSame('foo', (new Armourer($tables))->getWoundsOfWeaponlike($shield));
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
            ->andReturn($staffsAndSpearsTable = $this->createMeleeWeaponTable());
        $staffsAndSpearsTable->shouldReceive('getWoundsTypeOf')
            ->with($staff)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getWoundsTypeOfWeaponlike($staff));
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
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getWoundsTypeOfWeaponlike($shuriken));
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
            ->andReturn('foo');
        self::assertSame('foo', (new Armourer($tables))->getWoundsTypeOfWeaponlike($shield));
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
            ->andReturn($unarmedTable = $this->createMeleeWeaponTable());
        $unarmedTable->shouldReceive('getCoverOf')
            ->with($fist)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getCoverOfWeaponlike($fist));
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
            ->andReturn($swordsTable = $this->createMeleeWeaponTable());
        $swordsTable->shouldReceive('getWeightOf')
            ->with($escalatorlibur)
            ->andReturn('foo');
        self::assertSame('foo', (new Armourer($tables))->getWeightOfArmament($escalatorlibur));
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
            ->andReturn($staffsAndSpearsTable = $this->createMeleeWeaponTable());
        $staffsAndSpearsTable->shouldReceive('getTwoHandedOf')
            ->with($fork)
            ->andReturn('foo');
        self::assertSame('foo', (new Armourer($tables))->isTwoHandedOnly($fork));
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
            ->andReturn('foo');
        self::assertSame('foo', (new Armourer($tables))->getRestrictionOfProtectiveArmament($shield));
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
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getRangeOfRangedWeapon($bow));
    }

    /**
     * @test
     */
    public function I_can_get_applicable_strength_for_any_weapon()
    {
        $tables = $this->createTables();
        $bow = $this->createRangedWeaponCode('foo', 'bow');
        $tables->shouldReceive('getBowsTable')
            ->andReturn($bowsTable = $this->createRangedWeaponsTable());
        $bowsTable->shouldReceive('getMaximalApplicableStrengthOf')
            ->with($bow)
            ->andReturn(4);
        self::assertEquals(
            Strength::getIt(4),
            (new Armourer($tables))->getApplicableStrength($bow, Strength::getIt(5)),
            'The lower strength should be used'
        );

        $tables = $this->createTables();
        $anotherBow = $this->createRangedWeaponCode('foo', 'bow');
        $tables->shouldReceive('getBowsTable')
            ->andReturn($bowsTable = $this->createRangedWeaponsTable());
        $bowsTable->shouldReceive('getMaximalApplicableStrengthOf')
            ->with($anotherBow)
            ->andReturn(6);
        $strength = Strength::getIt(5);
        self::assertSame(
            $strength,
            (new Armourer($tables))->getApplicableStrength($anotherBow, $strength),
            'The lower strength should be used'
        );

        $axe = $this->createRangedWeaponCode('foo', 'axe');
        $strength = Strength::getIt(789);
        self::assertSame(
            $strength,
            (new Armourer($tables))->getApplicableStrength($axe, Strength::getIt(789)),
            'Only bows should be limited by applicable strength'
        );
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
            ->andReturn($missingWeaponSkillTable = $this->mockery(\stdClass::class));
        $missingWeaponSkillTable->shouldReceive('getFightNumberMalusForSkill')
            ->with(123)
            ->andReturn('foo');
        self::assertSame('foo', (new Armourer($tables))->getFightNumberMalusForSkill($skillRank));
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
            ->andReturn($missingWeaponSkillTable = $this->mockery(\stdClass::class));
        $missingWeaponSkillTable->shouldReceive('getAttackNumberMalusForSkill')
            ->with(123)
            ->andReturn('foo');
        self::assertSame('foo', (new Armourer($tables))->getAttackNumberMalusForSkill($skillRank));
    }

    /**
     * @test
     */
    public function I_can_get_malus_to_cover_by_skill_rank()
    {
        $tables = $this->createTables();
        $skillRank = $this->createPositiveInteger(123);
        $tables->shouldReceive('getMissingWeaponSkillTable')
            ->andReturn($missingWeaponSkillTable = $this->mockery(\stdClass::class));
        $missingWeaponSkillTable->shouldReceive('getCoverMalusForSkill')
            ->with(123)
            ->andReturn('foo');
        self::assertSame('foo', (new Armourer($tables))->getCoverMalusForSkill($skillRank));
    }

    /**
     * @test
     */
    public function I_can_get_malus_to_base_of_wounds_by_skill_rank()
    {
        $tables = $this->createTables();
        $skillRank = $this->createPositiveInteger(123);
        $tables->shouldReceive('getMissingWeaponSkillTable')
            ->andReturn($missingWeaponSkillTable = $this->mockery(\stdClass::class));
        $missingWeaponSkillTable->shouldReceive('getBaseOfWoundsMalusForSkill')
            ->with(123)
            ->andReturn('foo');
        self::assertSame('foo', (new Armourer($tables))->getBaseOfWoundsMalusForSkill($skillRank));
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
            ->andReturn($missingShieldSkillTable = $this->mockery(\stdClass::class));
        $missingShieldSkillTable->shouldReceive('getRestrictionBonusForSkill')
            ->with(123)
            ->andReturn('foo');
        self::assertSame(
            'foo',
            (new Armourer($tables))->getProtectiveArmamentRestrictionBonusForSkill($shield, $skillRank)
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
            ->andReturn($missingShieldSkillTable = $this->mockery(\stdClass::class));
        $missingShieldSkillTable->shouldReceive('getRestrictionBonusForSkill')
            ->with(123)
            ->andReturn(7);

        self::assertSame(-4, (new Armourer($tables))->getProtectiveArmamentRestrictionForSkill($shield, $skillRank));
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
            ->andReturn($missingShieldSkillTable = $this->mockery(\stdClass::class));
        $missingShieldSkillTable->shouldReceive('getRestrictionBonusForSkill')
            ->with(123)
            ->andReturn(789);

        self::assertSame(0, (new Armourer($tables))->getProtectiveArmamentRestrictionForSkill($shield, $skillRank));
    }

}