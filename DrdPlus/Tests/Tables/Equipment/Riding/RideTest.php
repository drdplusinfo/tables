<?php
namespace DrdPlus\Tests\Tables\Equipment\Riding;

use DrdPlus\Tables\Equipment\Riding\Ride;
use Granam\Integer\IntegerInterface;

class RideTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $ride = new Ride(123);
        self::assertSame(123, $ride->getValue());
        self::assertInstanceOf(IntegerInterface::class, $ride);
    }
}
