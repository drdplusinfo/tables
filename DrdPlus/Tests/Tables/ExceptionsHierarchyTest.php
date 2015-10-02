<?php
namespace DrdPlus\Tests\Tables;

use DrdPlus\Tables\MeasurementInterface;
use Granam\Exceptions\Tests\Tools\AbstractTestOfExceptionsHierarchy;

class ExceptionsHierarchyTest extends AbstractTestOfExceptionsHierarchy
{
    protected function getTestedNamespace()
    {
        $measurementReflection = new \ReflectionClass(MeasurementInterface::class);

        return $measurementReflection->getNamespaceName();
    }

    protected function getRootNamespace()
    {
        return $this->getTestedNamespace();
    }
}
