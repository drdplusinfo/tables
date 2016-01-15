<?php
namespace DrdPlus\Tables;

interface Table
{
    /**
     * Values can be in any dept of wrapping arrays, but have to be scalar or to string convertible.
     *
     * @return array|\ArrayAccess|string[][]|string[][][]
     */
    public function getValues();

    /**
     * @return array|\ArrayAccess|string[]|string[][]
     */
    public function getRowsHeader();

    /**
     * @return array|\ArrayAccess|string[]|string[][]
     */
    public function getColumnsHeader();
}
