<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tests\Tables\Measurements\Volume;

use DrdPlus\Codes\Units\VolumeUnitCode;
use DrdPlus\Tables\Measurements\Volume\Volume;
use DrdPlus\Tables\Measurements\Volume\VolumeBonus;
use DrdPlus\Tables\Measurements\Volume\VolumeTable;
use DrdPlus\Tests\Tables\Measurements\MeasurementTableTest;

class VolumeTableTest extends MeasurementTableTest
{
    /**
     * @test
     */
    public function I_can_convert_bonus_to_value()
    {
        $volumeTable = new VolumeTable();

        $cubicMeterToKilometer = 10 ** 9;
        $bonus = new VolumeBonus(-40, $volumeTable);
        $volume = $volumeTable->toVolume($bonus);
        self::assertSame(0.01, $volume->getCubicMeters());
        self::assertSame(0.01 / $cubicMeterToKilometer, $volume->getCubicKilometers());
        self::assertSame($bonus->getValue(), $volume->getBonus()->getValue());

        $bonus = new VolumeBonus(0, $volumeTable);
        $volume = $volumeTable->toVolume($bonus);
        self::assertSame(1.0, $volume->getCubicMeters());
        self::assertSame(1.0 / $cubicMeterToKilometer, $volume->getCubicKilometers());
        self::assertSame($bonus->getValue(), $volume->getBonus()->getValue());

        $bonus = new VolumeBonus(119, $volumeTable);
        $volume = $volumeTable->toVolume($bonus);
        self::assertSame(0.9 * $cubicMeterToKilometer, $volume->getCubicMeters());
        self::assertSame(0.9, $volume->getCubicKilometers());
        self::assertSame($bonus->getValue(), $volume->getBonus()->getValue());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Partials\Exceptions\UnknownBonus
     */
    public function I_can_not_use_too_low_bonus_to_value()
    {
        $distanceTable = new VolumeTable();
        $distanceTable->toVolume(new VolumeBonus(-41, $distanceTable));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Partials\Exceptions\UnknownBonus
     */
    public function I_can_not_convert_too_high_bonus_into_too_detailed_unit()
    {
        $distanceTable = new VolumeTable();
        $distanceTable->toVolume(new VolumeBonus(120, $distanceTable));
    }

    /**
     * @test
     */
    public function I_can_convert_value_to_bonus()
    {
        $distanceTable = new VolumeTable();

        // 0.01 matches more bonuses - the lowest is taken
        $distance = new Volume(0.01, VolumeUnitCode::CUBIC_METER, $distanceTable);
        self::assertSame(-40, $distance->getBonus()->getValue());

        $distance = new Volume(1, VolumeUnitCode::CUBIC_METER, $distanceTable);
        self::assertSame(0, $distance->getBonus()->getValue());
        $distance = new Volume(1.5, VolumeUnitCode::CUBIC_METER, $distanceTable);
        self::assertSame(4, $distance->getBonus()->getValue());

        $distance = new Volume(104, VolumeUnitCode::CUBIC_METER, $distanceTable);
        self::assertSame(40, $distance->getBonus()->getValue()); // 40 is the closest bonus
        $distance = new Volume(105, VolumeUnitCode::CUBIC_METER, $distanceTable);
        self::assertSame(41, $distance->getBonus()->getValue()); // 40 and 41 are closest bonuses, 41 is taken because higher
        $distance = new Volume(106, VolumeUnitCode::CUBIC_METER, $distanceTable);
        self::assertSame(41, $distance->getBonus()->getValue()); // 41 is the closest bonus (higher in this case)

        $distance = new Volume(0.9, VolumeUnitCode::CUBIC_KILOMETER, $distanceTable);
        self::assertSame(119, $distance->getBonus()->getValue());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Partials\Exceptions\RequestedDataOutOfTableRange
     */
    public function I_can_not_convert_too_low_value_to_bonus()
    {
        $distanceTable = new VolumeTable();
        $distance = new Volume(0.009, VolumeUnitCode::CUBIC_METER, $distanceTable);
        $distance->getBonus();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Partials\Exceptions\RequestedDataOutOfTableRange
     */
    public function I_can_not_convert_too_high_value_to_bonus()
    {
        $distanceTable = new VolumeTable();
        $distance = new Volume(901, VolumeUnitCode::CUBIC_KILOMETER, $distanceTable);
        $distance->getBonus();
    }
}