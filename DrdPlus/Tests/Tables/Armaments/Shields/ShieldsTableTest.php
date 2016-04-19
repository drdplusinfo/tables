<?php
namespace DrdPlus\Tables\Armaments\Shields;

use DrdPlus\Tests\Tables\TableTest;

class ShieldsTableTest extends \PHPUnit_Framework_TestCase implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $shieldsTable = new ShieldsTable();
        self::assertSame(
            [['shield', 'required_strength', 'restriction', 'offensiveness', 'wounds', 'type', 'cover', 'weight']],
            $shieldsTable->getHeader()
        );
    }

}
