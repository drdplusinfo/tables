<?php
namespace DrdPlus\Tables;

interface Table
{
    /**
     * Values can be in any dept of wrapping arrays, but have to be scalar or to string convertible.
     *
     * @return array|\ArrayAccess|string[][]|string[][][]
     */
    public function getIndexedValues();

    /**
     * Same values but in simplified structure of two-level array only.
     *
     * @return array|\ArrayAccess|string[][]
     */
    public function getValues();

    /**
     * Simplified structure of header names in two-level array.
     *
     * @return array|\ArrayAccess|string[][]
     */
    public function getHeader();
}
