<?php
namespace DrdPlus\Tests\Tables;

use DrdPlus\Tables\Table;
use Granam\Tests\Exceptions\Tools\AbstractExceptionsHierarchyTest;

class TablesExceptionsHierarchyTest extends AbstractExceptionsHierarchyTest
{
    protected function getTestedNamespace()
    {
        return $this->getRootNamespace();
    }

    protected function getRootNamespace()
    {
        $reflection = new \ReflectionClass(Table::class);

        return $reflection->getNamespaceName();
    }

}