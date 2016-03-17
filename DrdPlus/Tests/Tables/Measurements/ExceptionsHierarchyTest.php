<?php
namespace DrdPlus\Tests\Tables\Measurements;

use DrdPlus\Tables\Table;
use Granam\Tests\Exceptions\Tools\AbstractExceptionsHierarchyTest;

class ExceptionsHierarchyTest extends AbstractExceptionsHierarchyTest
{
    protected function getTestedNamespace()
    {
        return str_replace('\Tests', '', __NAMESPACE__);
    }

    protected function getRootNamespace()
    {
        $measurementReflection = new \ReflectionClass(Table::class);

        return $measurementReflection->getNamespaceName();
    }
}
