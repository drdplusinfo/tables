<?php
namespace DrdPlus\Tables\Wounds;

use DrdPlus\Tables\Parts\AbstractBonus;

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
