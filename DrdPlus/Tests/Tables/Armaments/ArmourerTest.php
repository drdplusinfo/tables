<?php
namespace DrdPlus\Tests\Tables\Armaments;

use DrdPlus\Codes\Armaments\BodyArmorCode;
use DrdPlus\Codes\Armaments\HelmCode;
use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Codes\Armaments\ShieldCode;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Body\Size;
use DrdPlus\Tables\Armaments\Armors\ArmorSanctionsByMissingStrengthTable;
use DrdPlus\Tables\Armaments\Armors\HelmsTable;
use DrdPlus\Tables\Armaments\Armourer;
use DrdPlus\Tables\Armaments\Partials\AbstractArmamentsTable;
use DrdPlus\Tables\Armaments\Shields\ShieldSanctionsByMissingStrengthTable;
use DrdPlus\Tables\Armaments\Shields\ShieldsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\MeleeWeaponSanctionsByMissingStrengthTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Ranged\RangedWeaponSanctionsByMissingStrengthTable;
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
        $tables->shouldReceive('getArmamentSanctionsByMissingStrengthTableByCode')
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
        $tables->shouldReceive('getArmamentSanctionsByMissingStrengthTableByCode')
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
        $tables->shouldReceive('getArmamentSanctionsByMissingStrengthTableByCode')
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
        $tables->shouldReceive('getArmamentSanctionsByMissingStrengthTableByCode')
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
        $tables->shouldReceive('getArmorSanctionsByMissingStrengthTable')
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
     * @return \Mockery\MockInterface|ArmorSanctionsByMissingStrengthTable
     */
    private function createArmorSanctionsTable()
    {
        return $this->mockery(ArmorSanctionsByMissingStrengthTable::class);
    }

    /**
     * @return \Mockery\MockInterface|HelmsTable
     */
    private function createHelmsTable()
    {
        return $this->mockery(HelmsTable::class);
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

        $tables->shouldReceive('getWeaponlikeSanctionsByMissingStrengthTableByCode')
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

        $tables->shouldReceive('getMeleeWeaponlikeCodeSanctionsByMissingStrengthTableByCode')
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

        $tables->shouldReceive('getArmamentSanctionsByMissingStrengthTableByCode')
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
     * @return \Mockery\MockInterface|MeleeWeaponSanctionsByMissingStrengthTable
     */
    private function createMeleeWeaponSanctionsTable()
    {
        return $this->mockery(MeleeWeaponSanctionsByMissingStrengthTable::class);
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
        $tables->shouldReceive('getWeaponlikeSanctionsByMissingStrengthTableByCode')
            ->andReturn($meleeWeaponSanctionsTable = $this->createMeleeWeaponSanctionsTable());
        $rangedSpear = $this->mockery(RangedWeaponCode::class);
        $rangedSpear->shouldReceive('isMeleeArmament')
            ->andReturn(true);
        $rangedSpear->shouldReceive('convertToMeleeWeaponCodeEquivalent')
            ->andReturn($meleeSpear = $this->mockery(MeleeWeaponCode::class));
        $tables->shouldReceive('getMeleeWeaponlikeCodeSanctionsByMissingStrengthTableByCode')
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
        $tables->shouldReceive('getArmamentSanctionsByMissingStrengthTableByCode')
            ->with($shield)
            ->andReturn($shieldSanctionsByMissingStrengthTable = $this->mockery(ShieldSanctionsByMissingStrengthTable::class));

        $tables->shouldReceive('getWeaponlikeSanctionsByMissingStrengthTableByCode')
            ->with($shield)
            ->andReturn($shieldSanctionsByMissingStrengthTable);

        $shieldSanctionsByMissingStrengthTable->shouldReceive('getFightNumberSanction')
            ->with(1 /* required strength - strength */)
            ->andReturn('baz');
        self::assertSame(
            'baz',
            $armourer->getFightNumberMalusByStrengthWithWeaponlike($shield, Strength::getIt(4))
        );

        $shieldSanctionsByMissingStrengthTable->shouldReceive('getAttackNumberSanction')
            ->with(2 /* required strength - strength */)
            ->andReturn('qux');
        self::assertSame(
            'qux',
            $armourer->getAttackNumberMalusByStrengthWithWeaponlike($shield, Strength::getIt(3))
        );

        $tables->shouldReceive('getMeleeWeaponlikeCodeSanctionsByMissingStrengthTableByCode')
            ->andReturn($shieldSanctionsByMissingStrengthTable);
        $shieldSanctionsByMissingStrengthTable->shouldReceive('getDefenseNumberSanction')
            ->with(3 /* required strength - strength */)
            ->andReturn('foobar');
        self::assertSame(
            'foobar',
            $armourer->getDefenseNumberMalusByStrengthWithWeaponlike($shield, Strength::getIt(2))
        );

        $shieldSanctionsByMissingStrengthTable->shouldReceive('getBaseOfWoundsSanction')
            ->with(4 /* required strength - strength */)
            ->andReturn('foobaz');
        self::assertSame(
            'foobaz',
            $armourer->getBaseOfWoundsMalusByStrengthWithWeaponlike($shield, Strength::getIt(1))
        );

        $shieldSanctionsByMissingStrengthTable->shouldReceive('canUseIt')
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
        $tables->shouldReceive('getArmamentSanctionsByMissingStrengthTableByCode')
            ->andReturn($rangeWeaponSanctionsTable = $this->createRangedWeaponSanctionsTable());

        $rangeWeaponSanctionsTable->shouldReceive('canUseIt')
            ->with($expectedMissingStrength)
            ->andReturn('bazbaz');
        self::assertSame(
            'bazbaz',
            $armourer->canUseArmament($weaponlikeCode, Strength::getIt($strength), $this->mockery(Size::class))
        );

        $tables->shouldReceive('getWeaponlikeSanctionsByMissingStrengthTableByCode')
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

        $tables->shouldReceive('getRangedWeaponSanctionsByMissingStrengthTable')
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

        $rangeWeaponSanctionsTable->shouldReceive('getEncounterRangeSanction')
            ->with($expectedMissingStrength)
            ->andReturn('fooqux');
        self::assertSame(
            'fooqux',
            $armourer->getEncounterRangeMalusByStrengthWithRangedWeapon($weaponlikeCode, Strength::getIt($strength))
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
     * @return \Mockery\MockInterface|RangedWeaponSanctionsByMissingStrengthTable
     */
    private function createRangedWeaponSanctionsTable()
    {
        return $this->mockery(RangedWeaponSanctionsByMissingStrengthTable::class);
    }

    /**
     * @return \Mockery\MockInterface|ShieldSanctionsByMissingStrengthTable
     */
    private function createShieldSanctionsTable()
    {
        return $this->mockery(ShieldSanctionsByMissingStrengthTable::class);
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
        $code->shouldReceive('isMeleeArmament')
            ->andReturn($isMeleeArmament);

        return $code;
    }

    private function getRangedWeaponGroups()
    {
        return ['bow', 'arrow', 'crossbow', 'dart', 'throwingWeapon', 'slingStone'];
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
    public function I_can_get_cover_of_every_armament()
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

        $shield = $this->createShield();
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($shield)
            ->andReturn($shieldsTable = $this->createShieldsTable());
        $shieldsTable->shouldReceive('getCoverOf')
            ->with($shield)
            ->andReturn('baz');
        self::assertSame('baz', (new Armourer($tables))->getCoverOfWeaponlike($shield));

        $bow = $this->createRangedWeaponCode('qux', 'bow');
        $tables->shouldReceive('getWeaponlikeTableByWeaponlikeCode')
            ->with($bow)
            ->andReturn($shieldsTable = $this->createRangedWeaponsTable());
        $shieldsTable->shouldReceive('getCoverOf')
            ->with($bow)
            ->andReturn('foo bar');
        self::assertSame('foo bar', (new Armourer($tables))->getCoverOfWeaponlike($bow));
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

        $arrow = $this->createRangedWeaponCode('foo', 'arrow');
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($arrow)
            ->andReturn($arrowsTable = $this->createRangedWeaponsTable());
        $arrowsTable->shouldReceive('getWeightOf')
            ->with($arrow)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getWeightOfArmament($arrow));

        $shield = $this->createShield();
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($shield)
            ->andReturn($shieldsTable = $this->createShieldsTable());
        $shieldsTable->shouldReceive('getWeightOf')
            ->with($shield)
            ->andReturn('baz');
        self::assertSame('baz', (new Armourer($tables))->getWeightOfArmament($shield));

        $helm = $this->createHelmCode();
        $tables->shouldReceive('getArmamentsTableByArmamentCode')
            ->with($helm)
            ->andReturn($helmsTable = $this->createHelmsTable());
        $helmsTable->shouldReceive('getWeightOf')
            ->with($helm)
            ->andReturn('qux');
        self::assertSame('qux', (new Armourer($tables))->getWeightOfArmament($helm));
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