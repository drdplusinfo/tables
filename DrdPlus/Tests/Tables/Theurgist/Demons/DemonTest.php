<?php
declare(strict_types=1);

namespace DrdPlus\Tests\Tables\Theurgist\Demons;

use DrdPlus\Codes\Theurgist\DemonCode;
use DrdPlus\Codes\Theurgist\DemonMutableParameterCode;
use DrdPlus\Tables\Tables;
use DrdPlus\Tables\Theurgist\Demons\Demon;
use DrdPlus\Tables\Theurgist\Demons\DemonParameters\DemonKnack;
use DrdPlus\Tables\Theurgist\Demons\DemonParameters\DemonStrength;
use DrdPlus\Tables\Theurgist\Demons\DemonsTable;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\Difficulty;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\Evocation;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\Partials\CastingParameter;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\SpellSpeed;
use Granam\String\StringTools;
use Granam\Tests\Tools\TestWithMockery;
use Mockery\MockInterface;

class DemonTest extends TestWithMockery
{
    private static $demonParameterNamespace;
    private static $spellParameterNamespace;

    /**
     * @throws \ReflectionException
     */
    protected function setUp(): void
    {
        if (self::$demonParameterNamespace === null) {
            self::$demonParameterNamespace = (new \ReflectionClass(DemonStrength::class))->getNamespaceName();
        }
        if (self::$spellParameterNamespace === null) {
            self::$spellParameterNamespace = (new \ReflectionClass(SpellSpeed::class))->getNamespaceName();
        }
    }

    /**
     * @test
     */
    public function I_can_create_it_without_any_change_for_every_demon(): void
    {
        foreach (DemonCode::getPossibleValues() as $demonValue) {
            $demonCode = DemonCode::getIt($demonValue);
            $demonsTable = $this->createDemonsTable();
            $demon = $this->createDemon($demonCode, $this->createTables($demonsTable));
            self::assertSame($demonCode, $demon->getDemonCode());
            foreach (DemonMutableParameterCode::getPossibleValues() as $mutableParameterName) {
                /** like instance of @see DemonStrength */
                $baseParameter = $this->createExpectedParameter($mutableParameterName);
                $this->addBaseParameterGetter($mutableParameterName, $demonCode, $demonsTable, $baseParameter);

                $this->addWithAdditionGetter(0, $baseParameter, $baseParameter);
                $this->addValueGetter($baseParameter, 123);
                /** like @see Demon::getCurrentDemonCapacity() */
                $getCurrentParameter = StringTools::assembleGetterForName('current' . ucfirst($mutableParameterName));
                /** @var CastingParameter $currentParameter */
                $currentParameter = $demon->$getCurrentParameter();
                self::assertInstanceOf($this->getParameterClass($mutableParameterName), $currentParameter);
                self::assertSame(123, $currentParameter->getValue());
                /** @noinspection DisconnectedForeachInstructionInspection */
                self::assertSame($demonValue, (string)$demonCode);
            }
        }
    }

    private function createDemon(DemonCode $demonCode, Tables $tables, array $demonParameterValues = [], array $demonTraits = []): Demon
    {
        return new Demon($demonCode, $tables, $demonParameterValues, $demonTraits);
    }

    /**
     * @param DemonsTable $demonsTable
     * @return Tables|MockInterface
     */
    private function createTables(DemonsTable $demonsTable): Tables
    {
        $tables = $this->mockery(Tables::class);
        $tables->shouldReceive('getDemonsTable')
            ->andReturn($demonsTable);
        $tables->makePartial();
        return $tables;
    }

    private function addValueGetter(MockInterface $object, $value): void
    {
        $object->shouldReceive('getValue')
            ->andReturn($value);
    }

    /**
     * @return MockInterface|DemonsTable
     */
    private function createDemonsTable()
    {
        return $this->mockery(DemonsTable::class);
    }

    /**
     * @param string $parameterName
     * @return CastingParameter|MockInterface
     */
    private function createExpectedParameter(string $parameterName): CastingParameter
    {
        $parameterClass = $this->getParameterClass($parameterName);

        return $this->mockery($parameterClass);
    }

    private function getParameterClass(string $parameterName): string
    {
        $parameterClassBasename = ucfirst(StringTools::assembleMethodName($parameterName));
        $namespace = strpos($parameterName, 'demon') !== false
            ? self::$demonParameterNamespace
            : self::$spellParameterNamespace;

        $baseParameterClass = $namespace . '\\' . $parameterClassBasename;
        self::assertTrue(class_exists($baseParameterClass), 'Can not find class ' . $baseParameterClass);

        return $baseParameterClass;
    }

    private function addBaseParameterGetter(
        string $parameterName,
        DemonCode $demonCode,
        MockInterface $demonsTable,
        CastingParameter $property = null
    ): void
    {
        $getProperty = StringTools::assembleGetterForName($parameterName);
        $demonsTable->shouldReceive($getProperty)
            ->with($demonCode)
            ->andReturn($property);
    }

    private function addDefaultValueGetter(MockInterface $property, int $defaultValue = 0): void
    {
        $property->shouldReceive('getDefaultValue')
            ->andReturn($defaultValue);
    }

    private function addWithAdditionGetter(
        int $addition,
        MockInterface $parameter,
        CastingParameter $modifiedParameter
    ): void
    {
        $parameter->shouldReceive('getWithAddition')
            ->with($addition)
            ->andReturn($modifiedParameter);
    }

    /**
     * @test
     */
    public function I_get_null_for_unused_parameters_for_every_demon(): void
    {
        foreach (DemonCode::getPossibleValues() as $demonValue) {
            $demonCode = DemonCode::getIt($demonValue);
            $demonsTable = $this->createDemonsTable();
            $demon = $this->createDemon($demonCode, $this->createTables($demonsTable));
            self::assertSame([], $demon->getDemonTraits());
            self::assertSame($demonCode, $demon->getDemonCode());
            foreach (DemonMutableParameterCode::getPossibleValues() as $mutableParameterName) {
                $this->addBaseParameterGetter($mutableParameterName, $demonCode, $demonsTable, null);
                /** like @see Demon::getCurrentDemonCapacity() */
                $getCurrentParameter = StringTools::assembleGetterForName('current' . $mutableParameterName);
                self::assertNull($demon->$getCurrentParameter());
            }
        }
    }

    /**
     * @test
     * @throws \Exception
     */
    public function I_can_create_it_with_addition_for_every_demon(): void
    {
        $parameterValues = [
            DemonMutableParameterCode::DEMON_CAPACITY => 1,
            DemonMutableParameterCode::DEMON_ENDURANCE => 2,
            DemonMutableParameterCode::DEMON_ACTIVATION_DURATION => 3,
            DemonMutableParameterCode::DEMON_QUALITY => 4,
            DemonMutableParameterCode::DEMON_RADIUS => 5,
            DemonMutableParameterCode::DEMON_AREA => 6,
            DemonMutableParameterCode::DEMON_INVISIBILITY => 7,
            DemonMutableParameterCode::DEMON_ARMOR => 8,
            DemonMutableParameterCode::SPELL_SPEED => 9,
            DemonMutableParameterCode::DEMON_STRENGTH => 10,
            DemonMutableParameterCode::DEMON_AGILITY => 11,
            DemonMutableParameterCode::DEMON_KNACK => 12,
        ];
        $missedParameters = array_diff(DemonMutableParameterCode::getPossibleValues(), array_keys($parameterValues));
        self::assertCount(
            0,
            $missedParameters,
            'We have missed some mutable parameters: ' . implode(',', $missedParameters)
        );
        $parameterChanges = [];
        foreach (DemonCode::getPossibleValues() as $demonValue) {
            $demonCode = DemonCode::getIt($demonValue);
            $demonsTable = $this->createDemonsTable();
            $baseParameters = [];
            foreach (DemonMutableParameterCode::getPossibleValues() as $mutableParameterName) {
                /** like instance of @see SpellSpeed */
                $baseParameter = $this->createExpectedParameter($mutableParameterName);
                $this->addBaseParameterGetter($mutableParameterName, $demonCode, $demonsTable, $baseParameter);
                $this->addDefaultValueGetter($baseParameter, $defaultValue = \random_int(-5, 5));
                $baseParameters[$mutableParameterName] = $baseParameter;
                $parameterChanges[$mutableParameterName] = $parameterValues[$mutableParameterName] - $defaultValue;
            }
            $demon = $this->createDemon($demonCode, $this->createTables($demonsTable), $parameterValues);
            self::assertSame($demonCode, $demon->getDemonCode());
            foreach (DemonMutableParameterCode::getPossibleValues() as $mutableParameterName) {
                $baseParameter = $baseParameters[$mutableParameterName];
                $change = $parameterChanges[$mutableParameterName];
                $this->addWithAdditionGetter(
                    $change,
                    $baseParameter,
                    $changedParameter = $this->createExpectedParameter($mutableParameterName)
                );
                $this->addValueGetter($changedParameter, 123);
                /** like @see Demon::getCurrentSpellRadius() */
                $getCurrentParameter = StringTools::assembleGetterForName('current' . $mutableParameterName);
                /** @var CastingParameter $currentParameter */
                $currentParameter = $demon->$getCurrentParameter();
                self::assertInstanceOf($this->getParameterClass($mutableParameterName), $currentParameter);
                self::assertSame(123, $currentParameter->getValue());
            }
        }
    }

    /**
     * @test
     */
    public function I_get_basic_difficulty_change_without_any_parameter(): void
    {
        foreach (DemonCode::getPossibleValues() as $demonValue) {
            $demonCode = DemonCode::getIt($demonValue);
            $demonsTable = $this->createDemonsTable();
            foreach (DemonMutableParameterCode::getPossibleValues() as $mutableParameterName) {
                $baseParameter = null;
                $this->addBaseParameterGetter($mutableParameterName, $demonCode, $demonsTable, $baseParameter);
            }
            $this->addDemonDifficultyGetter($demonsTable, $demonCode, 0);
            $demon = $this->createDemon($demonCode, $this->createTables($demonsTable));
            self::assertSame(
                $demonsTable->getDifficulty($demonCode)->createWithChange(0),
                $demon->getCurrentDifficulty()
            );
        }
    }

    private function addDemonDifficultyGetter(
        MockInterface $demonTable,
        DemonCode $expectedDemonCode,
        int $expectedDifficultyChange,
        Difficulty $demonChangedDifficulty = null
    ): void
    {
        $demonTable->shouldReceive('getDifficulty')
            ->with($expectedDemonCode)
            ->andReturn($demonDifficulty = $this->mockery(Difficulty::class));
        $demonDifficulty->shouldReceive('createWithChange')
            ->with($expectedDifficultyChange)
            ->andReturn($demonChangedDifficulty ?? $this->mockery(Difficulty::class));
    }

    /**
     * @test
     */
    public function I_can_get_current_evocation()
    {
        $demonsTable = $this->createDemonsTable();
        $demon = $this->createDemon($demonCode = DemonCode::getIt(DemonCode::DEADY), $this->createTables($demonsTable));
        $demonsTable->shouldReceive('getEvocation')
            ->with($demonCode)
            ->andReturn($evocation = $this->mockery(Evocation::class));
        self::assertSame($evocation, $demon->getCurrentEvocation());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Theurgist\Demons\Exceptions\UnknownDemonParameter
     * @expectedExceptionMessageRegExp ~4~
     */
    public function I_can_not_add_non_zero_addition_to_unused_parameter()
    {
        $addParameterGetter = function (MockInterface $demonsTable, ?DemonKnack $demonKnack) {
            $this->addBaseParameterGetter(
                DemonMutableParameterCode::DEMON_KNACK,
                DemonCode::getIt(DemonCode::DEADY),
                $demonsTable,
                $demonKnack
            );
        };
        $createDemon = function (DemonsTable $demonsTable) {
            return new Demon(
                DemonCode::getIt(DemonCode::DEADY),
                $this->createTables($demonsTable),
                [DemonMutableParameterCode::DEMON_KNACK => 4],
                []
            );
        };
        try {
            $demonsTable = $this->createDemonsTable();
            $demonKnack = $this->createExpectedParameter(DemonMutableParameterCode::DEMON_KNACK);
            /** @var DemonKnack $demonKnack */
            $addParameterGetter($demonsTable, $demonKnack);
            $this->addDefaultValueGetter($demonKnack, 1);
            $createDemon($demonsTable);
        } catch (\Exception $exception) {
            self::fail('No exception expected so far: ' . $exception->getMessage() . '; ' . $exception->getTraceAsString());
        }
        $demonsTable = $this->createDemonsTable();
        $addParameterGetter($demonsTable, null /* unused */);
        $createDemon($demonsTable);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Theurgist\Demons\Exceptions\UnknownDemonParameter
     * @expectedExceptionMessageRegExp ~fat~
     */
    public function I_can_not_create_it_with_unknown_parameter()
    {
        new Demon(
            DemonCode::getIt(DemonCode::GOLEM),
            $this->createTables($this->createDemonsTable()),
            ['fat' => 0],
            []
        );
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Theurgist\Demons\Exceptions\InvalidDemonTrait
     * @expectedExceptionMessageRegExp ~stdClass~
     */
    public function I_can_not_create_it_with_invalid_demon_trait()
    {
        new Demon(
            DemonCode::getIt(DemonCode::IMP),
            $this->createTables($this->createDemonsTable()),
            [],
            [new \stdClass()]
        );
    }

}