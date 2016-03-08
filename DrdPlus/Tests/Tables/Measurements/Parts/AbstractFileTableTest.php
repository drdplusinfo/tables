<?php
namespace DrdPlus\Tests\Tables\Measurements\Parts;

use DrdPlus\Tables\Measurements\Parts\AbstractBonus;
use DrdPlus\Tables\Measurements\Parts\AbstractFileTable;
use DrdPlus\Tables\Measurements\Tools\EvaluatorInterface;
use DrdPlus\Tables\Parts\AbstractTable;
use Granam\Tests\Tools\TestWithMockery;

class AbstractFileTableTest extends TestWithMockery
{

    /**
     * @var string
     */
    private $tempFilename;

    protected function tearDown()
    {
        parent::tearDown();
        if (file_exists($this->tempFilename)) {
            unlink($this->tempFilename);
        }
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Exceptions\FileCanNotBeRead
     */
    public function I_can_not_create_table_without_source_file()
    {
        $originalErrorReporting = error_reporting();
        try {
            error_reporting($originalErrorReporting ^ E_WARNING);
            $table = TestOfAbstractTable::getIt('non-existing-file');
            $table->getIndexedValues();
        } catch (\Exception $exception) {
            error_reporting($originalErrorReporting);
            $lastError = error_get_last();
            self::assertSame(E_WARNING, $lastError['type']);
            throw $exception;
        }
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Exceptions\FileIsEmpty
     */
    public function I_can_not_create_table_with_empty_source_file()
    {
        $table = TestOfAbstractTable::getIt($this->createTempFilename());
        $table->getIndexedValues();
    }

    private function createTempFilename()
    {
        return $this->tempFilename = tempnam(sys_get_temp_dir(), 'foo');
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Exceptions\DataFromFileAreCorrupted
     */
    public function I_can_not_create_table_with_corrupted_data()
    {
        $filename = $this->createTempFilename();
        file_put_contents($filename, 'bar');
        $table = TestOfAbstractTable::getIt($filename);
        $table->getIndexedValues();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Exceptions\DataRowsAreMissingInFile
     */
    public function I_can_not_create_table_without_data()
    {
        $filename = $this->createTempFilename();
        file_put_contents($filename, 'bonus');
        $table = TestOfAbstractTable::getIt($filename);
        $table->getIndexedValues();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Exceptions\UnknownUnit
     */
    public function I_can_not_convert_bonus_to_unknown_unit()
    {
        $filename = $this->createTempFilename();
        $bonus = new BonusForTestOfAbstractTable(123);
        file_put_contents($filename, "bonus\n$bonus");
        $table = TestOfAbstractTable::getIt($filename);
        $table->toMeasurement($bonus, 'non-existing-unit');
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Exceptions\UnexpectedChangeNotation
     */
    public function I_can_not_convert_bonus_to_invalid_value_change()
    {
        $filename = $this->createTempFilename();
        $bonus = new BonusForTestOfAbstractTable(123);
        $unit = 'bar';
        $invalidChance = '1/1';
        file_put_contents($filename, "bonus,$unit\n$bonus,$invalidChance");
        $table = TestOfAbstractTable::getIt($filename, [$unit]);
        $table->toMeasurement($bonus, $unit);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Exceptions\BonusAlreadyPaired
     */
    public function I_can_not_use_same_bonus_for_more_values()
    {
        $filename = $this->createTempFilename();
        $bonus = 123;
        $unit = 'bar';
        file_put_contents($filename, "bonus,$unit\n$bonus,1\n$bonus,2");
        $table = TestOfAbstractTable::getIt($filename, [$unit]);
        $table->getIndexedValues();
    }

    /**
     * @test
     */
    public function I_can_get_measurement_with_auto_chosen_unit_by_bonus()
    {
        $filename = $this->createTempFilename();
        $bonusValue1 = 123;
        $bonusValue2 = 456;
        $bonusValue3 = 789;
        $unit1 = 'bar';
        $unit2 = 'baz';
        $values1 = [1, 2];
        $values2 = [10, 20, 30];
        file_put_contents(
            $filename,
            "bonus,$unit1,$unit2
            $bonusValue1,{$values1[0]},{$values2[1]}
            $bonusValue2,{$values1[1]},{$values2[1]}
            $bonusValue3,,{$values2[2]}"
        );
        $table = TestOfAbstractTable::getIt($filename, [$unit1, $unit2]);
        $measurementFromSecondRow = $table->toMeasurement(
            new BonusForTestOfAbstractTable($bonusValue2),
            null /* auto-select unit*/
        );
        self::assertSame(2.0, current($measurementFromSecondRow));
        self::assertSame($unit1, key($measurementFromSecondRow));
        $measurementFromThirdRow = $table->toMeasurement(
            new BonusForTestOfAbstractTable($bonusValue3),
            null /* auto-select unit*/
        );
        self::assertSame(30.0, current($measurementFromThirdRow));
        self::assertSame($unit2, key($measurementFromThirdRow));
    }

    /**
     * @test
     */
    public function My_chance_is_evaluated_properly()
    {
        $filename = $this->createTempFilename();
        $chances = range(0, 6);
        $unit = 'bar';
        $bonusValues = [];
        $rows = [];
        foreach ($chances as $chance) {
            $bonusValues[$chance] = $bonusValue = $this->createSomeBonus($chance);
            $rows[] = "$bonusValue,$chance/6";
        }
        file_put_contents($filename, "bonus,$unit\n" . implode("\n", $rows));
        $table = TestOfAbstractTable::getIt($filename, [$unit], $evaluator = $this->mockery(EvaluatorInterface::class));
        $valuesToEvaluate = [];
        $evaluator->shouldReceive('evaluate')
            ->atLeast()->once()
            ->andReturnUsing(function ($toEvaluate) use (&$valuesToEvaluate) {
                $valuesToEvaluate[] = $toEvaluate;

                return $toEvaluate;
            });
        foreach ($bonusValues as $chance => $bonusValue) {
            $bonus = new BonusForTestOfAbstractTable($bonusValue);
            self::assertSame(
            /** @see \DrdPlus\Tests\Tables\Measurements\TestOfAbstractTable::convertToMeasurement */
                [$unit => $chance],
                $table->toMeasurement($bonus, $unit)
            );
        }
        self::assertSame($chances, $valuesToEvaluate);
    }

    private function createSomeBonus($referenceNumber)
    {
        return $referenceNumber + 3;
    }

    /**
     * @test
     */
    public function I_can_get_simplified_header_with_more_row_header_rows_then_column_header()
    {
        $withLessColumnHeaderRowsThenRowHeader = new WithLessColumnHeaderRowsThenRowHeader();
        self::assertEquals(
            [
                ['foo', ''],
                ['bar', 'baz'],
            ],
            $withLessColumnHeaderRowsThenRowHeader->getHeader()
        );
    }

}

/** inner */
class TestOfAbstractTable extends AbstractFileTable
{
    /**
     * @var string
     */
    private $dataFileName;
    private $dataHeader;

    public static function getIt($dataFileName, $units = [], EvaluatorInterface $evaluator = null)
    {
        $evaluator = $evaluator ?: \Mockery::mock(EvaluatorInterface::class);

        /** @var EvaluatorInterface $evaluator */

        return new static($evaluator, $dataFileName, $units);
    }

    public function __construct(EvaluatorInterface $evaluator, $dataFileName = false, $units = [])
    {
        $this->dataFileName = $dataFileName;
        $this->dataHeader = $units;
        parent::__construct($evaluator);
    }

    public function getValues()
    {
        return [];
    }

    public function getHeader()
    {
        return [];
    }

    /**
     * @return \string[]
     */
    protected function getExpectedDataHeader()
    {
        return $this->dataHeader;
    }

    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return $this->dataFileName;
    }

    /**
     * @param float $value
     * @param string $unit
     *
     * @return array
     */
    protected function convertToMeasurement($value, $unit)
    {
        return [$unit => $value];
    }

    /**
     * @param int $bonusValue
     *
     * @return AbstractBonus
     */
    protected function createBonus($bonusValue)
    {
        return new BonusForTestOfAbstractTable($bonusValue);
    }

    /**
     * Just making it public.
     * @param AbstractBonus $bonus
     * @param null $unit
     * @return array (differs from parent, @see \DrdPlus\Tests\Tables\Measurements\Parts\TestOfAbstractTable::convertToMeasurement for exact return value)
     */
    public function toMeasurement(AbstractBonus $bonus, $unit = null)
    {
        return parent::toMeasurement($bonus, $unit);
    }

}

/**inner */
class BonusForTestOfAbstractTable extends AbstractBonus
{
    public function __construct($value)
    {
        parent::__construct($value);
    }
}

class WithLessColumnHeaderRowsThenRowHeader extends AbstractTable
{
    protected function getRowsHeader()
    {
        return [
            ['foo', 'bar']
        ];
    }

    protected function getColumnsHeader()
    {
        return ['baz'];
    }

    public function getIndexedValues()
    {
        throw new \LogicException;
    }

}