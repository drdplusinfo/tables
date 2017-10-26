<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tests\Tables\Measurements\Fatigue;

use DrdPlus\Tables\Measurements\Fatigue\Fatigue;
use DrdPlus\Tables\Measurements\Fatigue\FatigueTable;
use DrdPlus\Tables\Measurements\Measurement;
use DrdPlus\Tables\Table;
use DrdPlus\Tests\Tables\Measurements\AbstractTestOfMeasurement;

class FatigueTest extends AbstractTestOfMeasurement
{

    /**
     * @param string $sutClass
     * @param int $amount
     * @param string $unit
     * @param Table $table
     * @return Measurement
     */
    protected function createSutWithTable(string $sutClass, int $amount, string $unit, Table $table): Measurement
    {
        self::assertSame(Fatigue::FATIGUE, $unit);
        self::assertInstanceOf(FatigueTable::class, $table);

        /** @var $table FatigueTable */
        return new Fatigue($amount, $table);
    }
}