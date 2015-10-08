<?php
namespace DrdPlus\Tests\Tables\Measurements\Parts;

use DrdPlus\Tables\Measurements\MeasurementInterface;
use DrdPlus\Tables\Measurements\Parts\AbstractTable;
use Granam\Exceptions\Tests\Tools\AbstractTestOfExceptionsHierarchy;

class ExceptionsHierarchyTest extends AbstractTestOfExceptionsHierarchy
{
    protected function getTestedNamespace()
    {
        $abstractTableReflection = new \ReflectionClass(AbstractTable::class);

        return $abstractTableReflection->getNamespaceName();
    }

    protected function getRootNamespace()
    {
        $measurementReflection = new \ReflectionClass(MeasurementInterface::class);

        return $measurementReflection->getNamespaceName();
    }
}
