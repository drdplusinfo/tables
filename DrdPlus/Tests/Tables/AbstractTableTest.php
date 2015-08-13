<?php
namespace DrdPlus\Tests\Tables\BonusBased;

use DrdPlus\Tables\BonusBased\AbstractTable;
use DrdPlus\Tables\EvaluatorInterface;
use DrdPlus\Tables\MeasurementInterface;
use DrdPlus\Tests\Tables\TestWithMockery;

class AbstractTableTest extends TestWithMockery
{

    /**
     * @var string
     */
    private $tempFilename;

    protected function tearDown()
    {
        if (file_exists($this->tempFilename)) {
            unlink($this->tempFilename);
        }
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\BonusBased\Exceptions\FileCanNotBeRead
     */
    public function I_can_not_create_table_without_source_file()
    {
        $originalErrorReporting = error_reporting();
        try {
            error_reporting($originalErrorReporting ^ E_WARNING);
            TestOfAbstractTable::getIt('non-existing-file');
        } catch (\Exception $exception) {
            error_reporting($originalErrorReporting);
            $lastError = error_get_last();
            $this->assertSame(E_WARNING, $lastError['type']);
            throw $exception;
        }
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\BonusBased\Exceptions\FileIsEmpty
     */
    public function I_can_not_create_table_with_empty_source_file()
    {
        TestOfAbstractTable::getIt($this->createTempFilename());
    }

    private function createTempFilename()
    {
        return $this->tempFilename = tempnam(sys_get_temp_dir(), 'foo');
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\BonusBased\Exceptions\DataFromFileAreCorrupted
     */
    public function I_can_not_create_table_with_corrupted_data()
    {
        $filename = $this->createTempFilename();
        file_put_contents($filename, 'bar');
        TestOfAbstractTable::getIt($filename);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\BonusBased\Exceptions\DataRowsAreMissingInFile
     */
    public function I_can_not_create_table_without_data()
    {
        $filename = $this->createTempFilename();
        file_put_contents($filename, 'bonus');
        TestOfAbstractTable::getIt($filename);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\UnknownUnit
     */
    public function I_can_not_convert_bonus_to_unknown_unit()
    {
        $filename = $this->createTempFilename();
        $bonus = 123;
        file_put_contents($filename, "bonus\n$bonus");
        $table = TestOfAbstractTable::getIt($filename);
        $table->toMeasurement($bonus, 'non-existing-unit');
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\BonusBased\Exceptions\UnexpectedChangeNotation
     */
    public function I_can_not_convert_bonus_to_invalid_value_change()
    {
        $filename = $this->createTempFilename();
        $bonus = 123;
        $unit = 'bar';
        $invalidChance = '1/1';
        file_put_contents($filename, "bonus,$unit\n$bonus,$invalidChance");
        $table = TestOfAbstractTable::getIt($filename, $unit);
        $table->toMeasurement($bonus, $unit);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\BonusBased\Exceptions\BonusAlreadyPaired
     */
    public function I_can_not_use_same_bonus_for_more_values()
    {
        $filename = $this->createTempFilename();
        $bonus = 123;
        $unit = 'bar';
        file_put_contents($filename, "bonus,$unit\n$bonus,1\n$bonus,2");
        TestOfAbstractTable::getIt($filename, $unit);
    }

    /**
     * @test
     */
    public function My_chance_is_evaluated_properly()
    {
        $filename = $this->createTempFilename();
        $bonuses = range(1, 6);
        $unit = 'bar';
        $chances = [];
        $rows = [];
        foreach ($bonuses as $bonus) {
            $chances[] = $chance = $this->createSomeChance($bonus);
            $rows[] = "$bonus,$chance/6";
        }
        file_put_contents($filename, "bonus,$unit\n" . implode("\n", $rows));
        $table = TestOfAbstractTable::getIt($filename, $unit, $evaluator = $this->mockery(EvaluatorInterface::class));
        $valuesToEvaluate = [];
        $evaluator->shouldReceive('evaluate')
            ->atLeast()->once()
            ->andReturnUsing(function () use (&$valuesToEvaluate) {
                $valuesToEvaluate[] = $toEvaluate = func_get_arg(0);

                return $toEvaluate;
            });
        foreach ($bonuses as $bonus) {
            $this->assertSame(
                [$unit => $this->createSomeChance($bonus)], /** @see \DrdPlus\Tests\Tables\TestOfAbstractTable::convertToMeasurement */
                $table->toMeasurement($bonus, $unit)
            );
        }
        $this->assertSame($chances, $valuesToEvaluate);
    }

    private function createSomeChance($referenceNumber)
    {
        return $referenceNumber * 2;
    }

}

/** inner */
class TestOfAbstractTable extends AbstractTable
{
    /**
     * @var string
     */
    private $dataFileName;
    private $dataHeader;

    public static function getIt($dataFileName, $unit = null, EvaluatorInterface $evaluator = null)
    {
        $evaluator = $evaluator ?: \Mockery::mock(EvaluatorInterface::class);

        /** @var EvaluatorInterface $evaluator */

        return new static($evaluator, $dataFileName, $unit);
    }

    public function __construct(EvaluatorInterface $evaluator, $dataFileName = false, $unit = false)
    {
        $this->dataFileName = $dataFileName;
        $this->dataHeader = $unit !== null ? [$unit] : [];
        parent::__construct($evaluator);
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
     * @return MeasurementInterface
     */
    protected function convertToMeasurement($value, $unit)
    {
        return [$unit => $value];
    }

}
