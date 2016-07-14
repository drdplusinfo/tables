<?php
namespace DrdPlus\Tests\Tables\Equipment\Riding;

use DrdPlus\Tables\Equipment\Riding\DefianceOfWildPercents;
use DrdPlus\Tests\Tables\Partials\PercentsTest;

class DefianceOfWildPercentsTest extends PercentsTest
{
    public function I_can_create_more_than_hundred_of_percents()
    {
        // intentionally empty, because I can not
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Equipment\Riding\Exceptions\UnexpectedDefianceOfWildPercents
     * @expectedExceptionMessageRegExp ~\s101~
     */
    public function I_can_not_create_more_than_hundred_of_percents()
    {
        new DefianceOfWildPercents(101);
    }

}
