<?php
namespace DrdPlus\Tables;

interface Table
{
    /**
     * Values can be in any dept of wrapping arrays, but have to be scalar or to string convertible.
     *
     * @return array|string[][]|string[][][]|\ArrayAccess
     */
    public function getValues();
}
