<?php
namespace DrdPlus\Tests\Tables\Parts;

use DrdPlus\Tables\MeasurementInterface;
use DrdPlus\Tables\Parts\AbstractTable;
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
