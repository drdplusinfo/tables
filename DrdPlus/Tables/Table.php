<?php
namespace DrdPlus\Tables;

interface Table
{
    /**
     * @return array|string[][]|\ArrayAccess
     */
    public function getValues();
}
