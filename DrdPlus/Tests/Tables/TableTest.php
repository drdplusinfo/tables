<?php
namespace DrdPlus\Tests\Tables;

use Granam\Tests\Tools\TestWithMockery;

abstract class TableTest extends TestWithMockery
{
    /**
     * @test
     */
    abstract public function I_can_get_header();

    /**
     * @test
     */
    public function I_can_get_to_rules_both_by_page_reference_and_direct_link()
    {
        $reflectionClass = new \ReflectionClass(self::getSutClass());
        $docComment = $reflectionClass->getDocComment();
        self::assertNotEmpty(
            $docComment,
            'Missing annotation with PPH reference for table ' . self::getSutClass()
        );
        self::assertRegExp(
            '~\s+[Ss]ee PPH page \d+(,? ((left|right) column|top|bottom))?~',
            $docComment,
            'Missing PPH page reference for table ' . self::getSutClass()
        );
    }
}