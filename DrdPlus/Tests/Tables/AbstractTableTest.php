<?php
namespace DrdPlus\Tests\Tables;

use DrdPlus\Tables\AbstractTable;
use DrdPlus\Tables\EvaluatorInterface;
use DrdPlus\Tables\MeasurementInterface;

class AbstractTableTest extends TestWithMockery
{

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\FileCanNotBeRead
     */
    public function I_can_not_create_table_without_source_file()
    {
        $originalErrorReporting = error_reporting();
        try {
            error_reporting($originalErrorReporting ^ E_WARNING);
            TestOfBrokenAbstractTable::getIt('non-existing-file');
        } catch (\Exception $exception) {
            error_reporting($originalErrorReporting);
            $lastError = error_get_last();
            $this->assertSame(E_WARNING, $lastError['type']);
            throw $exception;
        }
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\FileIsEmpty
     */
    public function I_can_not_create_table_with_empty_source_file()
    {
        TestOfBrokenAbstractTable::getIt(tempnam(sys_get_temp_dir(), 'foo'));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\DataFromFileAreCorrupted
     */
    public function I_can_not_create_table_with_corrupted_data()
    {
        $filename = tempnam(sys_get_temp_dir(), 'foo');
        file_put_contents($filename, 'bar');
        TestOfBrokenAbstractTable::getIt($filename);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\DataRowsAreMissingInFile
     */
    public function I_can_not_create_table_without_data()
    {
        $filename = tempnam(sys_get_temp_dir(), 'foo');
        file_put_contents($filename, 'bonus');
        TestOfBrokenAbstractTable::getIt($filename);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\UnknownUnit
     */
    public function I_can_not_convert_bonus_to_unknown_unit()
    {
        $filename = tempnam(sys_get_temp_dir(), 'foo');
        $bonus = 123;
        file_put_contents($filename, "bonus\n$bonus");
        $table = TestOfBrokenAbstractTable::getIt($filename);
        $table->toMeasurement($bonus, 'non-existing-unit');
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\UnexpectedChangeNotation
     */
    public function I_can_not_convert_bonus_to_invalid_value_change()
    {
        $filename = tempnam(sys_get_temp_dir(), 'foo');
        $bonus = 123;
        $unit = 'bar';
        $invalidChance = '1/1';
        file_put_contents($filename, "bonus,$unit\n$bonus,$invalidChance");
        $table = TestOfBrokenAbstractTable::getIt($filename, $unit);
        $table->toMeasurement($bonus, $unit);
    }

}

/** inner */
class TestOfBrokenAbstractTable extends AbstractTable
{
    /**
     * @var string
     */
    private $dataFileName;
    private $dataHeader;

    public static function getIt($dataFileName, $unit = false)
    {
        $evaluator = \Mockery::mock(EvaluatorInterface::class);

        /** @var EvaluatorInterface $evaluator */

        return new static($evaluator, $dataFileName, $unit);
    }

    public function __construct(EvaluatorInterface $evaluator, $dataFileName = false, $unit = false)
    {
        $this->dataFileName = $dataFileName;
        $this->dataHeader = $unit !== false ? [$unit] : [];
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
        throw new \LogicException('This should not be called');
    }

}
