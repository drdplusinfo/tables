<?php
namespace DrdPlus\Tables\Measurements\Fatigue;

use DrdPlus\Tables\Measurements\Parts\AbstractTable;
use DrdPlus\Tables\Measurements\Wounds\Wounds;
use DrdPlus\Tables\Measurements\Wounds\WoundsBonus;
use DrdPlus\Tables\Measurements\Wounds\WoundsTable;

/**
 * PPH page 165, top
 */
class FatigueTable extends AbstractTable
{
    /**
     * @var \DrdPlus\Tables\Measurements\Wounds\WoundsTable
     */
    private $woundsTable;

    public function __construct(WoundsTable $woundsTable)
    {
        // fatigue has the very same conversions as wounds have
        $this->woundsTable = $woundsTable;
    }

    public function getValues()
    {
        return $this->woundsTable->getValues();
    }

    /**
     * @param Fatigue $fatigue
     *
     * @return FatigueBonus
     */
    public function toBonus(Fatigue $fatigue)
    {
        return new FatigueBonus(
            $this->woundsTable->toBonus(new Wounds($fatigue->getValue(), Wounds::WOUNDS, $this->woundsTable))->getValue(),
            $this
        );
    }

    /**
     * @param FatigueBonus $bonus
     *
     * @return Fatigue
     */
    public function toFatigue(FatigueBonus $bonus)
    {
        return new Fatigue(
            $this->woundsTable->toWounds(new WoundsBonus($bonus->getValue(), $this->woundsTable))->getValue(),
            Fatigue::FATIGUE,
            $this
        );
    }

}
