<?php
namespace DrdPlus\Tables\Measurements\Wounds;

use DrdPlus\Tables\Measurements\Partials\AbstractBonus;

class WoundsBonus extends AbstractBonus
{
    /**
     * @var WoundsTable
     */
    private $woundsTable;

    public function __construct($value, WoundsTable $woundsTable)
    {
        $this->woundsTable = $woundsTable;
        parent::__construct($value);
    }

    /**
     * @return Wounds
     */
    public function getWounds()
    {
        return $this->woundsTable->toWounds($this);
    }
}
