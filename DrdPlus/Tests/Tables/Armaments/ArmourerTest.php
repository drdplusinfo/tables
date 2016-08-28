<?php
namespace DrdPlus\Tests\Tables\Armaments;

use DrdPlus\Codes\ArmamentCode;
use DrdPlus\Codes\ArmorCode;
use DrdPlus\Codes\BodyArmorCode;
use DrdPlus\Codes\HelmCode;
use DrdPlus\Codes\MeleeArmamentCode;
use DrdPlus\Codes\MeleeWeaponCode;
use DrdPlus\Codes\RangeWeaponCode;
use DrdPlus\Codes\ShieldCode;
use DrdPlus\Codes\WeaponCode;
use DrdPlus\Properties\Body\Size;
use DrdPlus\Tables\Armaments\Armors\ArmorSanctionsByMissingStrengthTable;
use DrdPlus\Tables\Armaments\Armors\BodyArmorsTable;
use DrdPlus\Tables\Armaments\Armors\HelmsTable;
use DrdPlus\Tables\Armaments\Armourer;
use DrdPlus\Tables\Armaments\Shields\ShieldSanctionsByMissingStrengthTable;
use DrdPlus\Tables\Armaments\Shields\ShieldsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\AxesTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\MeleeWeaponSanctionsByMissingStrengthTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Range\BowsTable;
use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Range\RangeWeaponSanctionsByMissingStrengthTable;
use DrdPlus\Tables\Tables;
use Granam\Tests\Tools\TestWithMockery;

class ArmourerTest extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_find_out_if_can_use_each_armament()
    {
        $armourer = new Armourer($tables = $this->createTables());
        $tables->shouldReceive('getBodyArmorsTable')
            ->andReturn($bodyArmorsTable = $this->createBodyArmorsTable());
        $bodyArmorCode = $this->createBodyArmorCode('foo');
        $bodyArmorsTable->shouldReceive('getRequiredStrengthOf')
            ->with($bodyArmorCode)
            ->andReturn(5);
        $tables->shouldReceive('getArmorSanctionsByMissingStrengthTable')
            ->andReturn($armorSanctionsTable = $this->createArmorSanctionsTable());
        $armorSanctionsTable->shouldReceive('canMove')
            ->with(7)
            ->andReturn('bar');
        self::assertSame('bar', $armourer->canUseArmament($bodyArmorCode, 0, Size::getIt(2)));

        $axe = $this->createMeleeWeaponCode('foo', 'axe');
        $tables->shouldReceive('getAxesTable')
            ->andReturn($axesTable = $this->mockery(AxesTable::class));
        $axesTable->shouldReceive('getRequiredStrengthOf')
            ->with($axe)
            ->andReturn(1);
        $tables->shouldReceive('getMeleeWeaponSanctionsByMissingStrengthTable')
            ->andReturn($meleeWeaponSanctionsTable = $this->createMeleeWeaponSanctionsTable());
        $meleeWeaponSanctionsTable->shouldReceive('canUseWeapon')
            ->with(5)
            ->andReturn('baz');
        self::assertSame('baz', $armourer->canUseArmament($axe, -4, $this->mockery(Size::class)));

        $bow = $this->createRangeWeaponCode('foo bar', 'bow');
        $tables->shouldReceive('getBowsTable')
            ->andReturn($bowsTable = $this->mockery(BowsTable::class));
        $bowsTable->shouldReceive('getRequiredStrengthOf')
            ->with($bow)
            ->andReturn(4);
        $tables->shouldReceive('getRangeWeaponSanctionsByMissingStrengthTable')
            ->andReturn($rangeWeaponSanctionsTable = $this->createRangeWeaponSanctionsTable());
        $rangeWeaponSanctionsTable->shouldReceive('canUseWeapon')
            ->with(3)
            ->andReturn('qux');
        self::assertSame('qux', $armourer->canUseArmament($bow, 1, $this->mockery(Size::class)));

        $shield = $this->createShield();
        $tables->shouldReceive('getShieldsTable')
            ->andReturn($shieldsTable = $this->createShieldsTable());
        $shieldsTable->shouldReceive('getRequiredStrengthOf')
            ->with($shield)
            ->andReturn(5);
        $tables->shouldReceive('getShieldSanctionsByMissingStrengthTable')
            ->andReturn($rangeWeaponSanctionsTable = $this->createRangeWeaponSanctionsTable());
        $rangeWeaponSanctionsTable->shouldReceive('canUseShield')
            ->with(4)
            ->andReturn('foo bar');
        self::assertSame('foo bar', $armourer->canUseArmament($shield, 1, $this->mockery(Size::class)));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     */
    public function I_can_not_ask_for_usage_of_unknown_armament()
    {
        (new Armourer($this->createTables()))
            ->canUseArmament($this->mockery(ArmamentCode::class), 0, $this->mockery(Size::class));
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
        $tables->shouldReceive('getBodyArmorsTable')
            ->andReturn($bodyArmorsTable = $this->createBodyArmorsTable());
        $bodyArmorCode = $this->createBodyArmorCode('foo');
        $bodyArmorsTable->shouldReceive('getRequiredStrengthOf')
            ->with($bodyArmorCode)
            ->andReturn($requiredStrength);
        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForArmament(
                $bodyArmorCode, $strength, Size::getIt($bodySize)
            )
        );
        $helmCode = $this->createHelmCode('bar');
        $tables->shouldReceive('getHelmsTable')
            ->andReturn($helmsTable = $this->createHelmsTable());
        $helmsTable->shouldReceive('getRequiredStrengthOf')
            ->with($helmCode)
            ->andReturn($requiredStrength);
        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForArmament(
                $helmCode,
                $strength,
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
            $armourer->getSanctionDescriptionWithArmor($helmCode, Size::getIt($bodySize), $strength)
        );
        $armorSanctionsTable->shouldReceive('getAgilityMalus')
            ->with($expectedMissingStrength)
            ->andReturn('qux');
        self::assertSame(
            'qux',
            $armourer->getAgilityMalusWithArmor($bodyArmorCode, Size::getIt($bodySize), $strength)
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
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownArmor
     */
    public function I_can_not_use_unknown_armor_code_to_get_missing_strength()
    {
        $armourer = new Armourer($this->createTables());
        $potsAndPansArmorCode = $this->mockery(ArmorCode::class);
        $armourer->getMissingStrengthForArmament($potsAndPansArmorCode, 0, $this->mockery(Size::class));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     */
    public function I_can_not_ask_for_unknown_armament_if_can_be_used()
    {
        $armourer = new Armourer($tables = $this->createTables());
        $armourer->canUseArmament($this->mockery(ArmamentCode::class), 0, $this->mockery(Size::class));
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
        $meleeWeaponCode = $this->createMeleeWeaponCode('foo', $weaponGroup);
        $meleeWeaponTable->shouldReceive('getRequiredStrengthOf')
            ->with($meleeWeaponCode)
            ->andReturn($requiredStrength);
        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForArmament($meleeWeaponCode, $strength, $this->mockery(Size::class))
        );
        $tables->shouldReceive('getMeleeWeaponSanctionsByMissingStrengthTable')
            ->andReturn($meleeWeaponSanctionsTable = $this->createMeleeWeaponSanctionsTable());

        $meleeWeaponSanctionsTable->shouldReceive('getFightNumberSanction')
            ->andReturn('baz');
        self::assertSame(
            'baz',
            $armourer->getFightNumberMalusWithWeapon($meleeWeaponCode, $strength)
        );

        $meleeWeaponSanctionsTable->shouldReceive('getAttackNumberSanction')
            ->andReturn('qux');
        self::assertSame(
            'qux',
            $armourer->getAttackNumberMalusWithWeapon($meleeWeaponCode, $strength)
        );

        $meleeWeaponSanctionsTable->shouldReceive('getDefenseNumberSanction')
            ->andReturn('foobar');
        self::assertSame(
            'foobar',
            $armourer->getDefenseNumberMalusWithMeleeArmament($meleeWeaponCode, $strength)
        );

        $meleeWeaponSanctionsTable->shouldReceive('getBaseOfWoundsSanction')
            ->andReturn('foobaz');
        self::assertSame(
            'foobaz',
            $armourer->getBaseOfWoundsMalusWithWeapon($meleeWeaponCode, $strength)
        );

        $meleeWeaponSanctionsTable->shouldReceive('canUseWeapon')
            ->andReturn('fooqux');
        self::assertSame(
            'fooqux',
            $armourer->canUseArmament($meleeWeaponCode, $strength, $this->mockery(Size::class))
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
            'saberOrBowieKnife', 'staffOrSpear', 'sword', 'unarmed', 'voulgeOrTrident'
        ];
    }

    /**
     * @test
     */
    public function I_can_get_missing_strength_and_sanction_values_for_shield()
    {
        $armourer = new Armourer($tables = $this->createTables());
        $tables->shouldReceive('getShieldsTable')
            ->andReturn($shieldsTable = $this->createShieldsTable());
        $shield = $this->createShield();
        $shieldsTable->shouldReceive('getRequiredStrengthOf')
            ->with($shield)
            ->andReturn(5);
        self::assertSame(
            1,
            $armourer->getMissingStrengthForArmament($shield, 4, $this->mockery(Size::class))
        );
        $tables->shouldReceive('getShieldSanctionsByMissingStrengthTable')
            ->andReturn($shieldSanctionsByMissingStrengthTable = $this->mockery(ShieldSanctionsByMissingStrengthTable::class));

        $shieldSanctionsByMissingStrengthTable->shouldReceive('getFightNumberSanction')
            ->andReturn('baz');
        self::assertSame(
            'baz',
            $armourer->getFightNumberMalusWithWeapon($shield, 4)
        );

        $shieldSanctionsByMissingStrengthTable->shouldReceive('getAttackNumberSanction')
            ->andReturn('qux');
        self::assertSame(
            'qux',
            $armourer->getAttackNumberMalusWithWeapon($shield, 4)
        );

        $shieldSanctionsByMissingStrengthTable->shouldReceive('getDefenseNumberSanction')
            ->andReturn('foobar');
        self::assertSame(
            'foobar',
            $armourer->getDefenseNumberMalusWithMeleeArmament($shield, 4)
        );

        $shieldSanctionsByMissingStrengthTable->shouldReceive('getBaseOfWoundsSanction')
            ->andReturn('foobaz');
        self::assertSame(
            'foobaz',
            $armourer->getBaseOfWoundsMalusWithWeapon($shield, 4)
        );

        $shieldSanctionsByMissingStrengthTable->shouldReceive('canUseShield')
            ->andReturn('fooqux');
        self::assertSame(
            'fooqux',
            $armourer->canUseArmament($shield, 4, $this->mockery(Size::class))
        );
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     */
    public function I_can_not_use_unknown_weapon_code_for_usage_question()
    {
        $armourer = new Armourer($tables = $this->createTables());
        /** @var WeaponCode $weaponCode */
        $weaponCode = $this->mockery(WeaponCode::class);
        $armourer->canUseArmament($weaponCode, 123, $this->mockery(Size::class));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeapon
     * @expectedExceptionMessageRegExp ~foo~
     */
    public function I_can_not_get_strength_sanction_for_unknown_melee_weapon()
    {
        (new Armourer($this->createTables()))->getMissingStrengthForArmament(
            $this->createMeleeWeaponCode('foo', 'sharpLanguage'), 0, $this->mockery(Size::class)
        );
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     * @expectedExceptionMessageRegExp ~foo~
     */
    public function I_can_not_get_strength_sanction_for_unknown_weapon_type()
    {
        (new Armourer($this->createTables()))->getMissingStrengthForArmament(
            $this->createWeaponCode('foo'), 0, $this->mockery(Size::class)
        );
    }

    /**
     * @param $value
     * @return \Mockery\MockInterface|WeaponCode
     */
    private function createWeaponCode($value)
    {
        $weaponCode = $this->mockery(WeaponCode::class);
        $weaponCode->shouldReceive('__toString')
            ->andReturn((string)$value);

        return $weaponCode;
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeArmament
     */
    public function I_can_not_get_defense_number_malus_for_unknown_melee_armament_type()
    {
        (new Armourer($this->createTables()))->getDefenseNumberMalusWithMeleeArmament(
            $this->mockery(MeleeArmamentCode::class), 0
        );
    }

    /**
     * @test
     * @dataProvider provideStrengthAndRangeWeaponGroup
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
        $weaponsTableBaseName = $weaponGroup . 'sTable';
        $tables->shouldReceive('get' . ucfirst($weaponsTableBaseName))
            ->andReturn($rangeWeaponTable = $this->createRangeWeaponsTable());
        $weaponCode = $this->createRangeWeaponCode('foo', $weaponGroup);
        $rangeWeaponTable->shouldReceive('getRequiredStrengthOf')
            ->with($weaponCode)
            ->andReturn($requiredStrength);
        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForArmament($weaponCode, $strength, $this->mockery(Size::class))
        );
        $tables->shouldReceive('getRangeWeaponSanctionsByMissingStrengthTable')
            ->andReturn($rangeWeaponSanctionsTable = $this->createRangeWeaponSanctionsTable());

        $rangeWeaponSanctionsTable->shouldReceive('canUseWeapon')
            ->andReturn('bazbaz');
        self::assertSame(
            'bazbaz',
            $armourer->canUseArmament($weaponCode, $strength, $this->mockery(Size::class))
        );

        $rangeWeaponSanctionsTable->shouldReceive('getFightNumberSanction')
            ->andReturn('baz');
        self::assertSame(
            'baz',
            $armourer->getFightNumberMalusWithWeapon($weaponCode, $strength)
        );

        $rangeWeaponSanctionsTable->shouldReceive('getAttackNumberSanction')
            ->andReturn('qux');
        self::assertSame(
            'qux',
            $armourer->getAttackNumberMalusWithWeapon($weaponCode, $strength)
        );

        $rangeWeaponSanctionsTable->shouldReceive('getLoadingInRounds')
            ->andReturn('foobar');
        self::assertSame(
            'foobar',
            $armourer->getLoadingInRoundsWithRangeWeapon($weaponCode, $strength)
        );

        $rangeWeaponSanctionsTable->shouldReceive('getLoadingInRoundsSanction')
            ->andReturn('foobaz');
        self::assertSame(
            'foobaz',
            $armourer->getLoadingInRoundsMalusWithRangeWeapon($weaponCode, $strength)
        );

        $rangeWeaponSanctionsTable->shouldReceive('getEncounterRangeSanction')
            ->andReturn('fooqux');
        self::assertSame(
            'fooqux',
            $armourer->getEncounterRangeMalusWithRangeWeapon($weaponCode, $strength)
        );

        $rangeWeaponSanctionsTable->shouldReceive('getBaseOfWoundsSanction')
            ->andReturn('foobarbar');
        self::assertSame(
            'foobarbar',
            $armourer->getBaseOfWoundsMalusWithWeapon($weaponCode, $strength)
        );
    }

    public function provideStrengthAndRangeWeaponGroup()
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
     * @return \Mockery\MockInterface|RangeWeaponsTable
     */
    private function createRangeWeaponsTable()
    {
        return $this->mockery(RangeWeaponsTable::class);
    }

    /**
     * @return \Mockery\MockInterface|RangeWeaponSanctionsByMissingStrengthTable
     */
    private function createRangeWeaponSanctionsTable()
    {
        return $this->mockery(RangeWeaponSanctionsByMissingStrengthTable::class);
    }

    /**
     * @param $value
     * @param string $matchingWeaponGroup
     * @return \Mockery\MockInterface|RangeWeaponCode
     */
    private function createRangeWeaponCode($value, $matchingWeaponGroup)
    {
        $code = $this->mockery(RangeWeaponCode::class);
        $code->shouldReceive('getValue')
            ->andReturn($value);
        $code->shouldReceive('__toString')
            ->andReturn((string)$value);
        foreach ($this->getRangeWeaponGroups() as $weaponGroup) {
            $code->shouldReceive('is' . ucfirst($weaponGroup))
                ->andReturn($weaponGroup === $matchingWeaponGroup);
        }

        return $code;
    }

    private function getRangeWeaponGroups()
    {
        return ['bow', 'arrow', 'crossbow', 'dart', 'throwingWeapon', 'slingStone'];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownWeapon
     * @expectedExceptionMessageRegExp ~foo~
     */
    public function I_can_not_get_fight_number_malus_for_weapon_of_armor()
    {
        (new Armourer($this->createTables()))->getFightNumberMalusWithWeapon($this->createWeaponCode('foo'), 0);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownWeapon
     * @expectedExceptionMessageRegExp ~foo~
     */
    public function I_can_not_get_attack_number_malus_for_weapon_of_unknown_type()
    {
        (new Armourer($this->createTables()))->getAttackNumberMalusWithWeapon($this->createWeaponCode('foo'), 0);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     * @expectedExceptionMessageRegExp ~foo~
     */
    public function I_can_not_get_base_of_wounds_malus_for_weapon_of_unknown_type()
    {
        (new Armourer($this->createTables()))->getBaseOfWoundsMalusWithWeapon($this->createWeaponCode('foo'), 0);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode
     * @expectedExceptionMessageRegExp ~foo~
     */
    public function I_can_not_get_missing_strength_for_unknown_range_weapon()
    {
        (new Armourer($this->createTables()))->getMissingStrengthForArmament(
            $this->createRangeWeaponCode('foo', 'spit'), 0, $this->mockery(Size::class)
        );
    }

    /**
     * @test
     */
    public function I_can_get_required_strength_of_melee_weapons()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getAxesTable')
            ->andReturn($axesTable = $this->createMeleeWeaponTable());
        $axe = $this->createMeleeWeaponCode('foo', 'axe');
        $axesTable->shouldReceive('getRequiredStrengthOf')
            ->with($axe)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getRequiredStrengthForWeapon($axe));
    }

    /**
     * @test
     */
    public function I_can_get_required_strength_of_shield()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getShieldsTable')
            ->andReturn($shieldsTable = $this->createShieldsTable());
        $shield = $this->createShield();
        $shieldsTable->shouldReceive('getRequiredStrengthOf')
            ->with($shield)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getRequiredStrengthForWeapon($shield));
    }

    /**
     * @test
     */
    public function I_can_get_required_strength_of_range_weapons()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getBowsTable')
            ->andReturn($bowsTable = $this->createRangeWeaponsTable());
        $bow = $this->createRangeWeaponCode('foo', 'bow');
        $bowsTable->shouldReceive('getRequiredStrengthOf')
            ->with($bow)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getRequiredStrengthForWeapon($bow));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownWeapon
     */
    public function I_can_not_get_required_strength_for_unknown_weapon_code()
    {
        (new Armourer($this->createTables()))->getRequiredStrengthForWeapon($this->mockery(WeaponCode::class));
    }

    /**
     * @test
     */
    public function I_can_get_length_of_melee_weapons()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getKnifesAndDaggersTable')
            ->andReturn($knifesAndDaggersTable = $this->createMeleeWeaponTable());
        $knife = $this->createMeleeWeaponCode('foo', 'knifeOrDagger');
        $knifesAndDaggersTable->shouldReceive('getLengthOf')
            ->with($knife)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getLengthOfMeleeArmament($knife));
    }

    /**
     * @test
     */
    public function I_get_zero_length_of_shield()
    {
        self::assertSame(0, (new Armourer($this->createTables()))->getLengthOfMeleeArmament($this->createShield()));
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
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeArmament
     */
    public function I_can_not_get_length_for_unknown_weapon_code()
    {
        (new Armourer($this->createTables()))->getLengthOfMeleeArmament($this->mockery(MeleeArmamentCode::class));
    }

    /**
     * @test
     */
    public function I_can_get_offensiveness_of_melee_weapons()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getMacesAndClubsTable')
            ->andReturn($macesAndClubsTable = $this->createMeleeWeaponTable());
        $club = $this->createMeleeWeaponCode('foo', 'maceOrClub');
        $macesAndClubsTable->shouldReceive('getOffensivenessOf')
            ->with($club)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getOffensivenessOfWeapon($club));
    }

    /**
     * @test
     */
    public function I_can_get_offensiveness_of_range_weapons()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getSlingStonesTable')
            ->andReturn($slingStonesTable = $this->createRangeWeaponsTable());
        $slingStone = $this->createRangeWeaponCode('foo', 'slingStone');
        $slingStonesTable->shouldReceive('getOffensivenessOf')
            ->with($slingStone)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getOffensivenessOfWeapon($slingStone));
    }

    /**
     * @test
     */
    public function I_can_get_offensiveness_of_shield()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getShieldsTable')
            ->andReturn($shieldsTable = $this->createShieldsTable());
        $shield = $this->createShield();
        $shieldsTable->shouldReceive('getOffensivenessOf')
            ->with($shield)
            ->andReturn('foo');
        self::assertSame('foo', (new Armourer($tables))->getOffensivenessOfWeapon($shield));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownWeapon
     */
    public function I_can_not_get_offensiveness_for_unknown_weapon_code()
    {
        (new Armourer($this->createTables()))->getOffensivenessOfWeapon($this->mockery(WeaponCode::class));
    }

    /**
     * @test
     */
    public function I_can_get_wounds_of_melee_weapons()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getMorningstarsAndMorgensternsTable')
            ->andReturn($morningstarsAndMorgensternsTable = $this->createMeleeWeaponTable());
        $morgenstern = $this->createMeleeWeaponCode('foo', 'morningstarOrMorgenstern');
        $morningstarsAndMorgensternsTable->shouldReceive('getWoundsOf')
            ->with($morgenstern)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getWoundsOfWeapon($morgenstern));
    }

    /**
     * @test
     */
    public function I_can_get_wounds_of_range_weapons()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getThrowingWeaponsTable')
            ->andReturn($throwingWeaponsTable = $this->createRangeWeaponsTable());
        $sling = $this->createRangeWeaponCode('foo', 'throwingWeapon');
        $throwingWeaponsTable->shouldReceive('getWoundsOf')
            ->with($sling)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getWoundsOfWeapon($sling));
    }

    /**
     * @test
     */
    public function I_can_get_wounds_of_shield()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getShieldsTable')
            ->andReturn($shieldsTable = $this->createShieldsTable());
        $shield = $this->createShield();
        $shieldsTable->shouldReceive('getWoundsOf')
            ->with($shield)
            ->andReturn('foo');
        self::assertSame('foo', (new Armourer($tables))->getWoundsOfWeapon($shield));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownWeapon
     */
    public function I_can_not_get_wounds_for_unknown_weapon_code()
    {
        (new Armourer($this->createTables()))->getWoundsOfWeapon($this->mockery(WeaponCode::class));
    }

    /**
     * @test
     */
    public function I_can_get_wounds_type_of_melee_weapons()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getStaffsAndSpearsTable')
            ->andReturn($staffsAndSpearsTable = $this->createMeleeWeaponTable());
        $staff = $this->createMeleeWeaponCode('foo', 'staffOrSpear');
        $staffsAndSpearsTable->shouldReceive('getWoundsTypeOf')
            ->with($staff)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getWoundsTypeOfWeapon($staff));
    }

    /**
     * @test
     */
    public function I_can_get_wounds_type_of_range_weapons()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getThrowingWeaponsTable')
            ->andReturn($throwingWeaponsTable = $this->createRangeWeaponsTable());
        $shuriken = $this->createRangeWeaponCode('foo', 'throwingWeapon');
        $throwingWeaponsTable->shouldReceive('getWoundsTypeOf')
            ->with($shuriken)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getWoundsTypeOfWeapon($shuriken));
    }

    /**
     * @test
     */
    public function I_can_get_wounds_type_of_shield()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getShieldsTable')
            ->andReturn($shieldsTable = $this->createShieldsTable());
        $shield = $this->createShield();
        $shieldsTable->shouldReceive('getWoundsTypeOf')
            ->with($shield)
            ->andReturn('foo');
        self::assertSame('foo', (new Armourer($tables))->getWoundsTypeOfWeapon($shield));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownWeapon
     */
    public function I_can_not_get_wounds_type_for_unknown_weapon_code()
    {
        (new Armourer($this->createTables()))->getWoundsTypeOfWeapon($this->mockery(WeaponCode::class));
    }

    /**
     * @test
     */
    public function I_can_get_cover_of_every_melee_armament()
    {
        $tables = $this->createTables();

        $tables->shouldReceive('getUnarmedTable')
            ->andReturn($unarmedTable = $this->createMeleeWeaponTable());
        $fist = $this->createMeleeWeaponCode('foo', 'unarmed');
        $unarmedTable->shouldReceive('getCoverOf')
            ->with($fist)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getCoverOfMeleeArmament($fist));

        $tables->shouldReceive('getShieldsTable')
            ->andReturn($shieldsTable = $this->createShieldsTable());
        $shield = $this->createShield();
        $shieldsTable->shouldReceive('getCoverOf')
            ->with($shield)
            ->andReturn('baz');
        self::assertSame('baz', (new Armourer($tables))->getCoverOfMeleeArmament($shield));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownWeapon
     */
    public function I_can_not_get_cover_for_unknown_weapon_code()
    {
        (new Armourer($this->createTables()))->getCoverOfMeleeArmament($this->mockery(MeleeArmamentCode::class));
    }

    /**
     * @test
     */
    public function I_can_get_weight_of_armament()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getSwordsTable')
            ->andReturn($swordsTable = $this->createMeleeWeaponTable());
        $escalatorlibur = $this->createMeleeWeaponCode('foo', 'sword');
        $swordsTable->shouldReceive('getWeightOf')
            ->with($escalatorlibur)
            ->andReturn('foo');
        self::assertSame('foo', (new Armourer($tables))->getWeightOfArmament($escalatorlibur));

        $tables->shouldReceive('getArrowsTable')
            ->andReturn($arrowsTable = $this->createRangeWeaponsTable());
        $arrow = $this->createRangeWeaponCode('foo', 'arrow');
        $arrowsTable->shouldReceive('getWeightOf')
            ->with($arrow)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getWeightOfArmament($arrow));

        $tables->shouldReceive('getShieldsTable')
            ->andReturn($shieldsTable = $this->createShieldsTable());
        $shield = $this->createShield();
        $shieldsTable->shouldReceive('getWeightOf')
            ->with($shield)
            ->andReturn('baz');
        self::assertSame('baz', (new Armourer($tables))->getWeightOfArmament($shield));

        $tables->shouldReceive('getHelmsTable')
            ->andReturn($helmsTable = $this->createHelmsTable());
        $helm = $this->createHelmCode();
        $helmsTable->shouldReceive('getWeightOf')
            ->with($helm)
            ->andReturn('qux');
        self::assertSame('qux', (new Armourer($tables))->getWeightOfArmament($helm));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     */
    public function I_can_not_get_weight_for_unknown_weapon_code()
    {
        (new Armourer($this->createTables()))->getWeightOfArmament($this->mockery(ArmamentCode::class));
    }

    /**
     * @test
     */
    public function I_get_zero_as_range_of_melee_weapons()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getVoulgesAndTridentsTable')
            ->andReturn($voulgesAndTridentsTable = $this->createMeleeWeaponTable());
        $pitchfork = $this->createMeleeWeaponCode('foo', 'voulgeOrTrident');
        $voulgesAndTridentsTable->shouldNotReceive('getRangeOf');
        self::assertSame(0, (new Armourer($tables))->getRangeOfRangeWeapon($pitchfork));
    }

    /**
     * @test
     */
    public function I_can_get_range_of_range_weapons()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getBowsTable')
            ->andReturn($bowsTable = $this->createRangeWeaponsTable());
        $bow = $this->createRangeWeaponCode('foo', 'bow');
        $bowsTable->shouldReceive('getRangeOf')
            ->with($bow)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getRangeOfRangeWeapon($bow));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownWeapon
     */
    public function I_can_not_get_range_for_unknown_weapon_code()
    {
        (new Armourer($this->createTables()))->getRangeOfRangeWeapon($this->mockery(WeaponCode::class));
    }

}