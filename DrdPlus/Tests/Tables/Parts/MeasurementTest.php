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
