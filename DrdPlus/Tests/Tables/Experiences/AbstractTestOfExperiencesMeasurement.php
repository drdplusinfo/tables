<?php
namespace DrdPlus\Tests\Tables\Experiences;

use DrdPlus\Tables\Experiences\ExperiencesTable;
use DrdPlus\Tables\MeasurementInterface;
use DrdPlus\Tests\Tables\AbstractTestOfMeasurement;

abstract class AbstractTestOfExperiencesMeasurement extends AbstractTestOfMeasurement
{

    /**
     * @param int $amount
     * @param string $unit
     *
     * @return MeasurementInterface
     */
    protected function createSut($amount, $unit)
    {
        $sutClass = $this->getTestedClass();

        return new $sutClass($amount, $unit, $this->createExperiencesTable());
    }

    /**
     * @return \Mockery\MockInterface|ExperiencesTable
     */
    protected function createExperiencesTable()
    {
        return $this->mockery(ExperiencesTable::class);
    }
}
