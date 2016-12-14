<?php
namespace DrdPlus\Tests\Tables\Measurements\Weight;

use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use DrdPlus\Tests\Tables\Measurements\AbstractTestOfMeasurement;

class WeightTest extends AbstractTestOfMeasurement
{

    /**
     * @return string
     */
    protected function getDefaultUnit()
    {
        return Weight::KG;
    }

    /**
     * @test
     */
    public function I_can_get_explicitly_kilograms()
    {
        $weight = new Weight(123.876, Weight::KG, new WeightTable());
        self::assertSame(123.876, $weight->getKilograms());
    }
}