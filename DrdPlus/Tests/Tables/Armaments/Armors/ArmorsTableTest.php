<?php
namespace DrdPlus\Tables\Armaments\Armors;

use DrdPlus\Tests\Tables\FileTableTest;

class ArmorsTableTest extends \PHPUnit_Framework_TestCase implements FileTableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $armorsTable = new ArmorsTable();
        self::assertSame(
            [['armor','required strength','restriction','protection','weight']],
            $armorsTable->getHeader()
        );
    }
}
