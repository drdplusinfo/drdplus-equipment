<?php
namespace DrdPlus\Tests\Equipment;

use Granam\Tests\Exceptions\Tools\AbstractExceptionsHierarchyTest;

class EquipmentExceptionsHierarchyTest extends AbstractExceptionsHierarchyTest
{
    protected function getTestedNamespace()
    {
        return $this->getRootNamespace();
    }

    protected function getRootNamespace()
    {
        return str_replace('\\Tests', '', __NAMESPACE__);
    }

}