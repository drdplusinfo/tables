<?php
namespace DrdPlus\Tests\Tables;

use DrdPlus\Tables\Parts\AbstractMeasurement;

class MeasurementTest extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_get_value_and_unit()
    {
        $measurement = new DeAbstractedMeasurement(
            $amount = 123,
            $unit = DeAbstractedMeasurement::POSSIBLE_UNIT
        );
        $this->assertSame((float)$amount, $measurement->getValue());
        $this->assertSame($unit, $measurement->getUnit());
    }

    /**
     * @test
     */
    public function I_can_get_measurement_value_by_to_string_conversion()
    {
        $measurement = new DeAbstractedMeasurement($value = 123, DeAbstractedMeasurement::POSSIBLE_UNIT);
        $this->assertSame((string)$value, (string)$measurement);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\UnknownUnit
     */
    public function I_cannot_create_measurement_with_unknown_unit()
    {
        new DeAbstractedMeasurement(123, 'non-existing unit');
    }

}

/** inner */
class DeAbstractedMeasurement extends AbstractMeasurement
{
    const POSSIBLE_UNIT = 'foo';

    public function __construct($value, $unit)
    {
        parent::__construct($value, $unit);
    }

    /**
     * @return array|string[]
     */
    public function getPossibleUnits()
    {
        return [self::POSSIBLE_UNIT];
    }

}
