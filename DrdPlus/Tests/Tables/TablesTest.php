<?php
namespace DrdPlus\Tables;

use DrdPlus\Codes\Armaments\ArmamentCode;
use DrdPlus\Codes\Armaments\ArmorCode;
use DrdPlus\Codes\Armaments\BodyArmorCode;
use DrdPlus\Codes\Armaments\HelmCode;
use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\Armaments\MeleeWeaponlikeCode;
use DrdPlus\Codes\Armaments\ProtectiveArmamentCode;
use DrdPlus\Codes\Armaments\RangeWeaponCode;
use DrdPlus\Codes\Armaments\ShieldCode;
use DrdPlus\Codes\Armaments\WeaponlikeCode;
use DrdPlus\Codes\Code;
use DrdPlus\Tables\Armaments\Armors\ArmorSanctionsByMissingStrengthTable;
use DrdPlus\Tables\Armaments\Armors\BodyArmorsTable;
use DrdPlus\Tables\Armaments\Armors\HelmsTable;
use DrdPlus\Tables\Armaments\Armors\MissingArmorSkillTable;
use DrdPlus\Tables\Armaments\Armourer;
use DrdPlus\Tables\Armaments\Shields\MissingShieldSkillTable;
use DrdPlus\Tables\Armaments\Shields\ShieldSanctionsByMissingStrengthTable;
use DrdPlus\Tables\Armaments\Shields\ShieldsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\MeleeWeaponSanctionsByMissingStrengthTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Range\RangeWeaponSanctionsByMissingStrengthTable;
use Granam\Tests\Tools\TestWithMockery;

class TablesTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_get_any_table()
    {
        $tables = new Tables();
        foreach ($this->getExpectedTableClasses() as $expectedTableClass) {
            $baseName = preg_replace('~(?:.+[\\\])?(\w+)$~', '$1', $expectedTableClass);
            $getTable = "get{$baseName}";
            self::assertTrue(
                method_exists($tables, $getTable),
                'Tables factory is missing getter for ' . $baseName . ' (or the class should be abstract?)'
            );
            $table = $tables->$getTable();
            self::assertInstanceOf($expectedTableClass, $table);
            $getterReflection = new \ReflectionMethod($tables, $getTable);
            self::assertContains("@return $baseName", $getterReflection->getDocComment());
        }
    }

    /**
     * @test
     */
    public function I_can_iterate_through_tables()
    {
        $tables = new Tables();
        $fetchedTableClasses = [];
        foreach ($tables as $table) {
            $fetchedTableClasses[] = get_class($table);
        }
        $expectedTableClasses = $this->getExpectedTableClasses();
        sort($expectedTableClasses);
        sort($fetchedTableClasses);

        self::assertSameSize(
            $expectedTableClasses,
            $fetchedTableClasses,
            'Tables factory should give ' . implode(',', array_diff($expectedTableClasses, $fetchedTableClasses))
            . ' on iterating'
        );
        self::assertEquals($expectedTableClasses, $fetchedTableClasses);
    }

    private function getExpectedTableClasses()
    {
        $tablesReflection = new \ReflectionClass(Tables::class);
        $rootDir = dirname($tablesReflection->getFileName());
        $rootNamespace = $tablesReflection->getNamespaceName();

        return $this->scanForTables($rootDir, $rootNamespace);
    }

    private function scanForTables($rootDir, $rootNamespace)
    {
        $tableClasses = [];
        foreach (scandir($rootDir) as $fileOrDir) {
            $fullPath = $rootDir . DIRECTORY_SEPARATOR . $fileOrDir;
            if ($fileOrDir !== '.' && $fileOrDir !== '..') {
                if (is_dir($fullPath)) {
                    foreach ($this->scanForTables($fullPath, $rootNamespace . '\\' . $fileOrDir) as $foundTable) {
                        $tableClasses[] = $foundTable;
                    }
                } else if (is_file($fullPath) && preg_match('~(?<tableBasename>\w+Table)\.php$~', $fileOrDir, $matches)) {
                    $tableReflection = new \ReflectionClass($rootNamespace . '\\' . $matches['tableBasename']);
                    if (!$tableReflection->isAbstract()) {
                        $tableClasses[] = $tableReflection->getName();
                    }
                }
            }
        }

        return $tableClasses;
    }

    /**
     * @test
     */
    public function I_can_get_armourer()
    {
        $tables = new Tables();
        self::assertInstanceOf(Armourer::class, $armourer = $tables->getArmourer());
        self::assertSame($armourer, $tables->getArmourer(), 'Expected the same instance of ' . Armourer::class);
    }

    /**
     * @test
     * @dataProvider provideArmamentCodeAndExpectedTableClass
     * @param ArmamentCode $armamentCode
     * @param string $expectedTableClass
     */
    public function I_can_get_every_armament_table_by_armament_code(ArmamentCode $armamentCode, $expectedTableClass)
    {
        self::assertInstanceOf($expectedTableClass, (new Tables())->getArmamentsTableByArmamentCode($armamentCode));
    }

    public function provideArmamentCodeAndExpectedTableClass()
    {
        $values = [];
        foreach ([
            BodyArmorCode::class => BodyArmorsTable::class,
            HelmCode::class => HelmsTable::class,
            ShieldCode::class => ShieldsTable::class,
            MeleeWeaponCode::class => MeleeWeaponsTable::class,
            RangeWeaponCode::class => RangeWeaponsTable::class,
        ] as $codeClass => $tableClass) {
            foreach ($this->pairCodesWithClass($this->getCodes($codeClass), $tableClass) as $pair) {
                $values[] = $pair;
            }
        }

        return $values;
    }

    /**
     * @param string $class
     * @return array
     */
    private function getCodes($class)
    {
        $codes = [];
        /** @var Code $class */
        $reflectionClass = new \ReflectionClass($class);
        foreach ($reflectionClass->getConstants() as $constant) {
            $codes[] = $class::getIt($constant);
        }

        return $codes;
    }

    /**
     * @param array $codes
     * @param $class
     * @return array
     */
    private function pairCodesWithClass(array $codes, $class)
    {
        return array_map(
            function ($code) use ($class) {
                return [$code, $class];
            },
            $codes
        );
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     */
    public function I_do_not_get_any_armament_table_by_unknown_code()
    {
        /** @var ArmamentCode $armamentCode */
        $armamentCode = $this->mockery(ArmamentCode::class);
        (new Tables())->getArmamentsTableByArmamentCode($armamentCode);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownWeaponlike
     */
    public function I_do_not_get_any_weaponlike_table_by_unknown_code()
    {
        /** @var WeaponlikeCode $weaponlikeCode */
        $weaponlikeCode = $this->mockery(WeaponlikeCode::class);
        (new Tables())->getWeaponlikeTableByWeaponlikeCode($weaponlikeCode);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeaponlike
     */
    public function I_do_not_get_any_melee_weaponlike_table_by_unknown_code()
    {
        /** @var MeleeWeaponlikeCode $meleeWeaponlikeCode */
        $meleeWeaponlikeCode = $this->mockery(MeleeWeaponlikeCode::class);
        (new Tables())->getMeleeWeaponlikeTableByMeleeWeaponlikeCode($meleeWeaponlikeCode);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeapon
     * @expectedExceptionMessageRegExp ~denigration~
     */
    public function I_do_not_get_any_melee_weapons_table_by_unknown_code()
    {
        /** @var MeleeWeaponCode $meleeWeaponCode */
        $meleeWeaponCode = $this->createMeleeWeaponCode('denigration', 'poisonous language');
        (new Tables())->getMeleeWeaponsTableByMeleeWeaponCode($meleeWeaponCode);
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
        $weaponGroups = [
            'axe', 'knifeOrDagger', 'maceOrClub', 'morningstarOrMorgenstern',
            'saberOrBowieKnife', 'staffOrSpear', 'sword', 'unarmed', 'voulgeOrTrident',
        ];
        foreach ($weaponGroups as $weaponGroup) {
            $code->shouldReceive('is' . ucfirst($weaponGroup))
                ->andReturn($weaponGroup === $matchingWeaponGroup);
        }

        return $code;
    }

    /**
     * @test
     * @dataProvider provideArmamentCodeAndExpectedSanctionsTable
     * @param ArmamentCode $armamentCode
     * @param string $expectedTableClass
     */
    public function I_can_get_table_with_sanctions_by_missing_strength_for_every_armament(
        ArmamentCode $armamentCode,
        $expectedTableClass
    )
    {
        self::assertInstanceOf(
            $expectedTableClass,
            (new Tables())->getArmamentSanctionsByMissingStrengthTableByCode($armamentCode)
        );
    }

    public function provideArmamentCodeAndExpectedSanctionsTable()
    {
        return [
            [BodyArmorCode::getIt(BodyArmorCode::HOBNAILED_ARMOR), ArmorSanctionsByMissingStrengthTable::class],
            [HelmCode::getIt(HelmCode::GREAT_HELM), ArmorSanctionsByMissingStrengthTable::class],
            [RangeWeaponCode::getIt(RangeWeaponCode::HEAVY_CROSSBOW), RangeWeaponSanctionsByMissingStrengthTable::class],
            [MeleeWeaponCode::getIt(MeleeWeaponCode::CLUB), MeleeWeaponSanctionsByMissingStrengthTable::class],
            [ShieldCode::getIt(ShieldCode::BUCKLER), ShieldSanctionsByMissingStrengthTable::class],
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     */
    public function I_do_not_get_any_sanctions_table_by_unknown_code()
    {
        /** @var ArmorCode $armamentCode */
        $armamentCode = $this->mockery(ArmamentCode::class);
        (new Tables())->getArmamentSanctionsByMissingStrengthTableByCode($armamentCode);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownWeaponlike
     */
    public function I_do_not_get_any_weaponlike_sanctions_table_by_unknown_code()
    {
        /** @var WeaponlikeCode $weaponlikeCode */
        $weaponlikeCode = $this->mockery(WeaponlikeCode::class);
        (new Tables())->getWeaponlikeSanctionsByMissingStrengthTableByCode($weaponlikeCode);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeaponlike
     */
    public function I_do_not_get_any_melee_weaponlike_sanctions_table_by_unknown_code()
    {
        /** @var MeleeWeaponlikeCode $meleeWeaponlikeCode */
        $meleeWeaponlikeCode = $this->mockery(MeleeWeaponlikeCode::class);
        (new Tables())->getMeleeWeaponlikeCodeSanctionsByMissingStrengthTableByCode($meleeWeaponlikeCode);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownRangeWeapon
     * @expectedExceptionMessageRegExp ~wallop~
     */
    public function I_do_not_get_range_weapons_table_by_unknown_code()
    {
        /** @var RangeWeaponCode $rangeWeaponCode */
        $rangeWeaponCode = $this->createRangeWeaponCode('wallop', 'bio weapons');
        (new Tables())->getRangeWeaponsTableByRangeWeaponCode($rangeWeaponCode);
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
        $rangeWeaponGroups = ['bow', 'arrow', 'crossbow', 'dart', 'throwingWeapon', 'slingStone'];
        foreach ($rangeWeaponGroups as $weaponGroup) {
            $code->shouldReceive('is' . ucfirst($weaponGroup))
                ->andReturn($weaponGroup === $matchingWeaponGroup);
        }

        return $code;
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownArmor
     */
    public function I_do_not_get_any_armors_table_by_unknown_code()
    {
        /** @var ArmorCode $armorCode */
        $armorCode = $this->mockery(ArmorCode::class);
        (new Tables())->getArmorsTableByArmorCode($armorCode);
    }

    /**
     * @test
     * @dataProvider provideProtectiveArmamentCodeAndExpectedSanctionsTable
     * @param ProtectiveArmamentCode $protectiveArmamentCode
     * @param string $expectedTableClass
     */
    public function I_can_get_table_with_sanctions_by_missing_skill_for_every_protective_armament(
        ProtectiveArmamentCode $protectiveArmamentCode,
        $expectedTableClass
    )
    {
        self::assertInstanceOf(
            $expectedTableClass,
            (new Tables())->getProtectiveArmamentMissingSkillTableByCode($protectiveArmamentCode)
        );
    }

    public function provideProtectiveArmamentCodeAndExpectedSanctionsTable()
    {
        return [
            [BodyArmorCode::getIt(BodyArmorCode::HOBNAILED_ARMOR), MissingArmorSkillTable::class],
            [HelmCode::getIt(HelmCode::GREAT_HELM), MissingArmorSkillTable::class],
            [ShieldCode::getIt(ShieldCode::BUCKLER), MissingShieldSkillTable::class],
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownProtectiveArmament
     */
    public function I_do_not_get_table_any_sanctions_by_missing_skill_for_unknown_code()
    {
        /** @var ProtectiveArmamentCode $protectiveArmamentCode */
        $protectiveArmamentCode = $this->mockery(ProtectiveArmamentCode::class);
        (new Tables())->getProtectiveArmamentMissingSkillTableByCode($protectiveArmamentCode);
    }
}