<?php
namespace DrdPlus\Tests\Tables\Armaments;

use DrdPlus\Codes\ArmorCode;
use DrdPlus\Codes\BodyArmorCode;
use DrdPlus\Codes\HelmCode;
use DrdPlus\Codes\MeleeWeaponCode;
use DrdPlus\Codes\RangeWeaponCode;
use DrdPlus\Codes\WeaponCode;
use DrdPlus\Tables\Armaments\Armors\ArmorSanctionsTable;
use DrdPlus\Tables\Armaments\Armors\BodyArmorsTable;
use DrdPlus\Tables\Armaments\Armors\HelmsTable;
use DrdPlus\Tables\Armaments\Armourer;
use DrdPlus\Tables\Armaments\Weapons\Melee\AxesTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\MeleeWeaponSanctionsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Range\BowsTable;
use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Range\RangeWeaponSanctionsTable;
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
        $bodyArmorCode = 'foo';
        $bodyArmorsTable->shouldReceive('getRequiredStrengthOf')
            ->with($bodyArmorCode)
            ->andReturn($requiredStrength);
        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForArmor($this->createBodyArmorCode($bodyArmorCode), $bodySize, $strength)
        );
        $helmCode = 'bar';
        $tables->shouldReceive('getHelmsTable')
            ->andReturn($helmsTable = $this->createHelmsTable());
        $helmsTable->shouldReceive('getRequiredStrengthOf')
            ->with($helmCode)
            ->andReturn($requiredStrength);
        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForArmor($this->createHelmCode($helmCode), $bodySize, $strength)
        );
        $tables->shouldReceive('getArmorSanctionsTable')
            ->andReturn($armorSanctionsTable = $this->createArmorSanctionsTable());
        $armorSanctionsTable->shouldReceive('getSanctionsForMissingStrength')
            ->with($expectedMissingStrength)
            ->andReturn('baz');
        self::assertSame(
            'baz',
            $armourer->getSanctionValuesForArmor($this->createBodyArmorCode($bodyArmorCode), $bodySize, $strength)
        );
        $armorSanctionsTable->shouldReceive('getSanctionDescription')
            ->with($expectedMissingStrength)
            ->andReturn('qux');
        self::assertSame(
            'qux',
            $armourer->getSanctionDescriptionForArmor($this->createHelmCode($helmCode), $bodySize, $strength)
        );
        $armorSanctionsTable->shouldReceive('getAgilityMalus')
            ->with($expectedMissingStrength)
            ->andReturn('qux');
        self::assertSame(
            'qux',
            $armourer->getAgilityMalusForArmor($this->createBodyArmorCode($bodyArmorCode), $bodySize, $strength)
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
     * @expectedException \DrdPlus\Tables\Armaments\Armors\Exceptions\UnknownArmorCode
     */
    public function I_can_not_use_unknown_armor_code()
    {
        $armourer = new Armourer($this->createTables());
        $potsAndPansArmorCode = $this->mockery(ArmorCode::class);
        $armourer->getMissingStrengthForArmor($potsAndPansArmorCode, 0, 0);
    }

    /**
     * @test
     */
    public function I_can_find_out_if_can_use_armor()
    {
        $armourer = new Armourer($tables = $this->createTables());
        $tables->shouldReceive('getBodyArmorsTable')
            ->andReturn($bodyArmorsTable = $this->createBodyArmorsTable());
        $bodyArmorCodeValue = 'foo';
        $bodyArmorsTable->shouldReceive('getRequiredStrengthOf')
            ->with($bodyArmorCodeValue)
            ->andReturn(5);
        $tables->shouldReceive('getArmorSanctionsTable')
            ->andReturn($armorSanctionsTable = $this->createArmorSanctionsTable());
        $armorSanctionsTable->shouldReceive('canMove')
            ->with(3)
            ->andReturn('bar');

        self::assertSame('bar', $armourer->canUseArmor($this->createBodyArmorCode($bodyArmorCodeValue), 0, 2));
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
        $weaponCodeValue = 'foo';
        $meleeWeaponTable->shouldReceive('getRequiredStrengthOf')
            ->with($weaponCodeValue)
            ->andReturn($requiredStrength);
        $meleeWeaponCode = $this->createMeleeWeaponCode($weaponCodeValue, $weaponGroup);
        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForMeleeWeapon($meleeWeaponCode, $strength)
        );
        $tables->shouldReceive('getMeleeWeaponSanctionsTable')
            ->andReturn($meleeWeaponSanctionsTable = $this->createMeleeWeaponSanctionsTable());
        $meleeWeaponSanctionsTable->shouldReceive('getSanctionsForMissingStrength')
            ->with($expectedMissingStrength)
            ->andReturn('bar');
        self::assertSame('bar', $armourer->getSanctionValuesForMeleeWeapon($meleeWeaponCode, $strength));

        $meleeWeaponSanctionsTable->shouldReceive('getFightNumberSanction')
            ->andReturn('baz');
        self::assertSame(
            'baz',
            $armourer->getMeleeWeaponFightNumberMalus($meleeWeaponCode, $strength)
        );

        $meleeWeaponSanctionsTable->shouldReceive('getAttackNumberSanction')
            ->andReturn('qux');
        self::assertSame(
            'qux',
            $armourer->getMeleeWeaponAttackNumberMalus($meleeWeaponCode, $strength)
        );

        $meleeWeaponSanctionsTable->shouldReceive('getDefenseNumberSanction')
            ->andReturn('foobar');
        self::assertSame(
            'foobar',
            $armourer->getMeleeWeaponDefenseNumberMalus($meleeWeaponCode, $strength)
        );

        $meleeWeaponSanctionsTable->shouldReceive('getBaseOfWoundsSanction')
            ->andReturn('foobaz');
        self::assertSame(
            'foobaz',
            $armourer->getMeleeWeaponBaseOfWoundsMalus($meleeWeaponCode, $strength)
        );

        $meleeWeaponSanctionsTable->shouldReceive('canUseWeapon')
            ->andReturn('fooqux');
        self::assertSame(
            'fooqux',
            $armourer->canUseMeleeWeapon($meleeWeaponCode, $strength)
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
            'axe', 'knifeOrDagger', 'maceOrClub', 'morningstarOrMorgenstern',
            'saberOrBowieKnife', 'staffOrSpear', 'sword', 'unarmed', 'voulgeOrTrident'
        ];
    }

    /**
     * @test
     */
    public function I_can_find_out_if_can_use_both_melee_or_range_weapon_by_single_question()
    {
        $armourer = new Armourer($tables = $this->createTables());

        $axe = $this->createMeleeWeaponCode('foo', 'axe');
        $tables->shouldReceive('getAxesTable')
            ->andReturn($axesTable = $this->mockery(AxesTable::class));
        $axesTable->shouldReceive('getRequiredStrengthOf')
            ->with('foo')
            ->andReturn(1);
        $tables->shouldReceive('getMeleeWeaponSanctionsTable')
            ->andReturn($meleeWeaponSanctionsTable = $this->createMeleeWeaponSanctionsTable());
        $meleeWeaponSanctionsTable->shouldReceive('canUseWeapon')
            ->with(5)
            ->andReturn('baz');
        self::assertSame('baz', $armourer->canUseWeapon($axe, -4));

        $bow = $this->createRangeWeaponCode('foo bar', 'bow');
        $tables->shouldReceive('getBowsTable')
            ->andReturn($bowsTable = $this->mockery(BowsTable::class));
        $bowsTable->shouldReceive('getRequiredStrengthOf')
            ->with('foo bar')
            ->andReturn(4);
        $tables->shouldReceive('getRangeWeaponSanctionsTable')
            ->andReturn($rangeWeaponSanctionsTable = $this->createRangeWeaponSanctionsTable());
        $rangeWeaponSanctionsTable->shouldReceive('canUseWeapon')
            ->with(3)
            ->andReturn('baz');
        self::assertSame('baz', $armourer->canUseWeapon($bow, 1));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Exceptions\UnknownWeaponCode
     */
    public function I_can_not_use_unknown_weapon_code_for_usage_question()
    {
        $armourer = new Armourer($tables = $this->createTables());
        /** @var WeaponCode $weaponCode */
        $weaponCode = $this->mockery(WeaponCode::class);
        $armourer->canUseWeapon($weaponCode, 123);
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
        $weaponCodeValue = ' foo';
        $rangeWeaponTable->shouldReceive('getRequiredStrengthOf')
            ->with($weaponCodeValue)
            ->andReturn($requiredStrength);
        $weaponCode = $this->createRangeWeaponCode($weaponCodeValue, $weaponGroup);
        self::assertSame(
            $expectedMissingStrength,
            $armourer->getMissingStrengthForRangeWeapon($weaponCode, $strength)
        );
        $tables->shouldReceive('getRangeWeaponSanctionsTable')
            ->andReturn($rangeWeaponSanctionsTable = $this->createRangeWeaponSanctionsTable());
        $rangeWeaponSanctionsTable->shouldReceive('getSanctionsForMissingStrength')
            ->with($expectedMissingStrength)
            ->andReturn('bar');
        self::assertSame(
            'bar',
            $armourer->getSanctionValuesForRangeWeapon($weaponCode, $strength)
        );

        $rangeWeaponSanctionsTable->shouldReceive('canUseWeapon')
            ->andReturn('bazbaz');
        self::assertSame(
            'bazbaz',
            $armourer->canUseRangeWeapon($weaponCode, $strength)
        );

        $rangeWeaponSanctionsTable->shouldReceive('getFightNumberSanction')
            ->andReturn('baz');
        self::assertSame(
            'baz',
            $armourer->getRangeWeaponFightNumberMalus($weaponCode, $strength)
        );

        $rangeWeaponSanctionsTable->shouldReceive('getAttackNumberSanction')
            ->andReturn('qux');
        self::assertSame(
            'qux',
            $armourer->getRangeWeaponAttackNumberMalus($weaponCode, $strength)
        );

        $rangeWeaponSanctionsTable->shouldReceive('getLoadingInRounds')
            ->andReturn('foobar');
        self::assertSame(
            'foobar',
            $armourer->getRangeWeaponLoadingInRounds($weaponCode, $strength)
        );

        $rangeWeaponSanctionsTable->shouldReceive('getLoadingInRoundsSanction')
            ->andReturn('foobaz');
        self::assertSame(
            'foobaz',
            $armourer->getRangeWeaponLoadingInRoundsMalus($weaponCode, $strength)
        );

        $rangeWeaponSanctionsTable->shouldReceive('getEncounterRangeSanction')
            ->andReturn('fooqux');
        self::assertSame(
            'fooqux',
            $armourer->getRangeWeaponEncounterRangeMalus($weaponCode, $strength)
        );

        $rangeWeaponSanctionsTable->shouldReceive('getBaseOfWoundsSanction')
            ->andReturn('foobarbar');
        self::assertSame(
            'foobarbar',
            $armourer->getRangeWeaponBaseOfWoundsMalus($weaponCode, $strength)
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
     * @return \Mockery\MockInterface|RangeWeaponSanctionsTable
     */
    private function createRangeWeaponSanctionsTable()
    {
        return $this->mockery(RangeWeaponSanctionsTable::class);
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
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode
     * @expectedExceptionMessageRegExp ~foo~
     */
    public function I_can_not_get_strength_sanction_for_unknown_range_weapon()
    {
        (new Armourer($this->createTables()))->getMissingStrengthForRangeWeapon($this->createRangeWeaponCode('foo', 'spit'), 0);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode
     * @expectedExceptionMessageRegExp ~foo~
     */
    public function I_can_not_get_sanctions_for_unknown_range_weapon()
    {
        (new Armourer($this->createTables()))->getSanctionValuesForRangeWeapon($this->createRangeWeaponCode('foo', 'spit'), 0);
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
        self::assertSame('bar', (new Armourer($tables))->getRequiredStrengthFor($axe));
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
        self::assertSame('bar', (new Armourer($tables))->getRequiredStrengthFor($bow));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Exceptions\UnknownWeaponCode
     */
    public function I_can_not_get_required_strength_for_unknown_weapon_code()
    {
        (new Armourer($this->createTables()))->getRequiredStrengthFor($this->mockery(WeaponCode::class));
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
        self::assertSame('bar', (new Armourer($tables))->getLengthOf($knife));
    }

    /**
     * @test
     */
    public function I_get_always_zero_as_length_of_range_weapons()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getCrossbowsTable')
            ->andReturn($crossbowsTable = $this->createRangeWeaponsTable());
        $knife = $this->createRangeWeaponCode('foo', 'crossbows');
        $crossbowsTable->shouldNotReceive('getLengthOf');
        self::assertSame(0, (new Armourer($tables))->getLengthOf($knife));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Exceptions\UnknownWeaponCode
     */
    public function I_can_not_get_length_for_unknown_weapon_code()
    {
        (new Armourer($this->createTables()))->getLengthOf($this->mockery(WeaponCode::class));
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
        self::assertSame('bar', (new Armourer($tables))->getOffensivenessOf($club));
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
        self::assertSame('bar', (new Armourer($tables))->getOffensivenessOf($slingStone));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Exceptions\UnknownWeaponCode
     */
    public function I_can_not_get_offensiveness_for_unknown_weapon_code()
    {
        (new Armourer($this->createTables()))->getOffensivenessOf($this->mockery(WeaponCode::class));
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
        self::assertSame('bar', (new Armourer($tables))->getWoundsOf($morgenstern));
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
        self::assertSame('bar', (new Armourer($tables))->getWoundsOf($sling));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Exceptions\UnknownWeaponCode
     */
    public function I_can_not_get_wounds_for_unknown_weapon_code()
    {
        (new Armourer($this->createTables()))->getWoundsOf($this->mockery(WeaponCode::class));
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
        self::assertSame('bar', (new Armourer($tables))->getWoundsTypeOf($staff));
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
        self::assertSame('bar', (new Armourer($tables))->getWoundsTypeOf($shuriken));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Exceptions\UnknownWeaponCode
     */
    public function I_can_not_get_wounds_type_for_unknown_weapon_code()
    {
        (new Armourer($this->createTables()))->getWoundsTypeOf($this->mockery(WeaponCode::class));
    }

    /**
     * @test
     */
    public function I_can_get_cover_of_melee_weapons()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getUnarmedTable')
            ->andReturn($unarmedTable = $this->createMeleeWeaponTable());
        $fist = $this->createMeleeWeaponCode('foo', 'unarmed');
        $unarmedTable->shouldReceive('getCoverOf')
            ->with($fist)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getCoverOf($fist));
    }

    /**
     * @test
     */
    public function I_get_always_zero_as_cover_of_range_weapons()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getDarts')
            ->andReturn($dartsTable = $this->createRangeWeaponsTable());
        $dart = $this->createRangeWeaponCode('foo', 'dart');
        $dartsTable->shouldNotReceive('getCoverOf');
        self::assertSame(0, (new Armourer($tables))->getCoverOf($dart));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Exceptions\UnknownWeaponCode
     */
    public function I_can_not_get_cover_for_unknown_weapon_code()
    {
        (new Armourer($this->createTables()))->getCoverOf($this->mockery(WeaponCode::class));
    }

    /**
     * @test
     */
    public function I_can_get_weight_of_melee_weapons()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getSwordsTable')
            ->andReturn($swordsTable = $this->createMeleeWeaponTable());
        $escalatorlibur = $this->createMeleeWeaponCode('foo', 'sword');
        $swordsTable->shouldReceive('getWeightOf')
            ->with($escalatorlibur)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getWeightOf($escalatorlibur));
    }

    /**
     * @test
     */
    public function I_can_get_weight_of_range_weapons()
    {
        $tables = $this->createTables();
        $tables->shouldReceive('getArrowsTable')
            ->andReturn($arrowsTable = $this->createRangeWeaponsTable());
        $arrow = $this->createRangeWeaponCode('foo', 'arrow');
        $arrowsTable->shouldReceive('getWeightOf')
            ->with($arrow)
            ->andReturn('bar');
        self::assertSame('bar', (new Armourer($tables))->getWeightOf($arrow));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Exceptions\UnknownWeaponCode
     */
    public function I_can_not_get_weight_for_unknown_weapon_code()
    {
        (new Armourer($this->createTables()))->getWeightOf($this->mockery(WeaponCode::class));
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
        self::assertSame(0, (new Armourer($tables))->getRangeOf($pitchfork));
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
        self::assertSame('bar', (new Armourer($tables))->getRangeOf($bow));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Exceptions\UnknownWeaponCode
     */
    public function I_can_not_get_range_for_unknown_weapon_code()
    {
        (new Armourer($this->createTables()))->getRangeOf($this->mockery(WeaponCode::class));
    }

}