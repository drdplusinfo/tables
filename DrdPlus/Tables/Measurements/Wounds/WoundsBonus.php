<?php
namespace DrdPlus\Tables\Measurements\Wounds;

use DrdPlus\Tables\Measurements\Partials\AbstractBonus;
use Granam\Integer\IntegerInterface;

class WoundsBonus extends AbstractBonus
{
    /**
     * @var WoundsTable
     */
    private $woundsTable;

    /**
     * @param int|IntegerInterface $value
     * @param WoundsTable $woundsTable
     */
    public function __construct($value, WoundsTable $woundsTable)
    {
        $this->woundsTable = $woundsTable;
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        parent::__construct($value);
    }

    /**
     * @return Wounds
     */
    public function getWounds(): Wounds
    {
        return $this->woundsTable->toWounds($this);
    }
}