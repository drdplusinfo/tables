<?php
namespace DrdPlus\Tests\Tables\Experiences;

use DrdPlus\Tables\Experiences\Experiences;
use DrdPlus\Tables\MeasurementInterface;
use Granam\Exceptions\Tests\Tools\AbstractTestOfExceptionsHierarchy;

class ExceptionsHierarchyTest extends AbstractTestOfExceptionsHierarchy
{
    protected function getTestedNamespace()
    {
        $reflection = new \ReflectionClass(Experiences::class);

        return $reflection->getNamespaceName();
    }

    protected function getRootNamespace()
    {
        $reflection = new \ReflectionClass(MeasurementInterface::class);

        return $reflection->getNamespaceName();
    }

}
