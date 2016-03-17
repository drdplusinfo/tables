<?php
namespace DrdPlus\Tests\Tables\Races;

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
        $reflection = new \ReflectionClass(Table::class);

        return $reflection->getNamespaceName();
    }

}
