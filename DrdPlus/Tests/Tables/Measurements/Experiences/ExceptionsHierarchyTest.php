<?php
namespace DrdPlus\Tests\Tables\Measurements\Experiences;

use DrdPlus\Tables\Measurements\Experiences\Experiences;
use DrdPlus\Tables\Measurements\Measurement;
use Granam\Tests\Exceptions\Tools\AbstractExceptionsHierarchyTest;

class ExceptionsHierarchyTest extends AbstractExceptionsHierarchyTest
{
    protected function getTestedNamespace()
    {
        $reflection = new \ReflectionClass(Experiences::class);

        return $reflection->getNamespaceName();
    }

    protected function getRootNamespace()
    {
        $reflection = new \ReflectionClass(Measurement::class);

        return $reflection->getNamespaceName();
    }

}
