<?php
namespace DrdPlus\Tables\Fatigue;

use DrdPlus\Tables\Parts\AbstractTable;
use DrdPlus\Tables\Wounds\Wounds;
use DrdPlus\Tables\Wounds\WoundsBonus;
use DrdPlus\Tables\Wounds\WoundsTable;

/**
 * PPH page 165, top
 */
class FatigueTable extends AbstractTable
{
    /**
     * @var \DrdPlus\Tables\Wounds\WoundsTable
     */
    private $woundsTable;

    public function __construct(WoundsTable $woundsTable)
    {
        // fatigue has the very same conversions as wounds have
        $this->woundsTable = $woundsTable;
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
