<?php
namespace DrdPlus\Tests\Tables\Measurements\Parts;

use DrdPlus\Tables\Measurements\MeasurementInterface;
use DrdPlus\Tables\Measurements\Parts\AbstractMeasurement;
use Granam\Exceptions\Tests\Tools\AbstractTestOfExceptionsHierarchy;

class ExceptionsHierarchyTest extends AbstractTestOfExceptionsHierarchy
{
    protected function getTestedNamespace()
    {
        $abstractTableReflection = new \ReflectionClass(AbstractMeasurement::class);

        return $abstractTableReflection->getNamespaceName();
    }

    protected function getRootNamespace()
    {
        $measurementReflection = new \ReflectionClass(MeasurementInterface::class);

        return $measurementReflection->getNamespaceName();
    }
}
