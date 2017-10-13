<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tests\Tables\Measurements\Volume;

use DrdPlus\Codes\Units\VolumeUnitCode;
use DrdPlus\Tables\Measurements\Volume\Volume;
use DrdPlus\Tables\Measurements\Volume\VolumeTable;
use DrdPlus\Tests\Tables\Measurements\AbstractTestOfMeasurement;

class VolumeTest extends AbstractTestOfMeasurement
{
    protected function getDefaultUnit(): string
    {
        return VolumeUnitCode::CUBIC_METER;
    }

    public function getAllUnits(): array
    {
        return VolumeUnitCode::getPossibleValues();
    }

    /**
     * @test
     */
    public function I_can_get_unit_as_a_code_instance()
    {
        $distanceTable = new VolumeTable();
        foreach ($this->getAllUnits() as $unitName) {
            $volume = new Volume(123.456, $unitName, $distanceTable);
            self::assertSame(VolumeUnitCode::getIt($unitName), $volume->getUnitCode());
        }
    }

}