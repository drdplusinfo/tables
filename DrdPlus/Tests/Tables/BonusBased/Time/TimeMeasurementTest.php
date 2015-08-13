<?php
namespace DrdPlus\Tests\Tables\BonusBased\Time;

use DrdPlus\Tables\BonusBased\Time\Exceptions\LaterDefinedValueShouldBeLesser;
use DrdPlus\Tables\BonusBased\Time\Exceptions\PreviouslyDefinedUnitShouldBeGreater;
use DrdPlus\Tables\BonusBased\Time\TimeMeasurement;
use DrdPlus\Tests\Tables\AbstractTestOfMeasurement;

class TimeMeasurementTest extends AbstractTestOfMeasurement
{

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\DifferentValueExpectedForDifferentUnit
     */
    public function I_can_not_add_another_unit_with_same_value()
    {
        $time = new TimeMeasurement($value = 123, TimeMeasurement::ROUND);
        $time->addInDifferentUnit($value, TimeMeasurement::MINUTE);
    }

    /**
     * @test
     */
    public function I_can_not_add_greater_value_of_later_defined_unit()
    {
        $units = [TimeMeasurement::ROUND, TimeMeasurement::MINUTE, TimeMeasurement::HOUR, TimeMeasurement::DAY, TimeMeasurement::MONTH, TimeMeasurement::YEAR];
        while ($units) {
            $smallestUnit = array_shift($units);
            $time = new TimeMeasurement($value = 123, $smallestUnit);
            $catches = 0;
            foreach ($units as $greaterUnit) {
                try {
                    $time->addInDifferentUnit($value + 1, $greaterUnit);
                } catch (LaterDefinedValueShouldBeLesser $exception) {
                    $catches++;
                }
            }
            $this->assertSame(count($units), $catches);
        }
    }

    /**
     * @test
     */
    public function I_can_not_add_lesser_value_of_previously_defined_unit()
    {
        $units = [TimeMeasurement::ROUND, TimeMeasurement::MINUTE, TimeMeasurement::HOUR, TimeMeasurement::DAY, TimeMeasurement::MONTH, TimeMeasurement::YEAR];
        while ($units) {
            $greatestUnit = array_pop($units);
            $time = new TimeMeasurement($value = 123, $greatestUnit);
            $catches = 0;
            foreach ($units as $lesserUnit) {
                try {
                    $time->addInDifferentUnit($value - 1, $lesserUnit);
                } catch (PreviouslyDefinedUnitShouldBeGreater $exception) {
                    $catches++;
                }
            }
            $this->assertSame(count($units), $catches);
        }
    }

    protected function getDefaultUnit()
    {
        return TimeMeasurement::ROUND;
    }
}
