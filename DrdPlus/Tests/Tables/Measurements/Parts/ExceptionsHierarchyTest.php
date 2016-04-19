<?php
namespace DrdPlus\Tests\Tables\Measurements\Partials;

use DrdPlus\Tables\Measurements\Measurement;
use DrdPlus\Tables\Measurements\Partials\AbstractMeasurement;
use Granam\Tests\Exceptions\Tools\AbstractExceptionsHierarchyTest;

class ExceptionsHierarchyTest extends AbstractExceptionsHierarchyTest
{
    protected function getTestedNamespace()
    {
        $abstractTableReflection = new \ReflectionClass(AbstractMeasurement::class);

        return $abstractTableReflection->getNamespaceName();
    }

    protected function getRootNamespace()
    {
        $measurementReflection = new \ReflectionClass(Measurement::class);

        return $measurementReflection->getNamespaceName();
    }
}
