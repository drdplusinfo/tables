<?php
namespace DrdPlus\Tables\Measurements\Experiences;

use DrdPlus\Tables\Measurements\Parts\AbstractTable;
use DrdPlus\Tables\Measurements\Wounds\Wounds;
use DrdPlus\Tables\Measurements\Wounds\WoundsBonus;
use DrdPlus\Tables\Measurements\Wounds\WoundsTable;

/**
 * PPH page 44, top right
 */
class ExperiencesTable extends AbstractTable
{
    /** @var \DrdPlus\Tables\Measurements\Wounds\WoundsTable */
    private $woundsTable;

    public function __construct(WoundsTable $woundsTable)
    {
        // experiences have similar conversions as wounds have
        $this->woundsTable = $woundsTable;
    }

    public function getValues()
    {
        return $this->woundsTable->getValues();
    }

    public function getRowsHeader()
    {
        return $this->woundsTable->getRowsHeader();
    }

    public function getColumnsHeader()
    {
        return $this->woundsTable->getColumnsHeader();
    }

    /**
     * @param Experiences $experiences
     *
     * @return Level
     */
    public function toLevel(Experiences $experiences)
    {
        $woundsBonus = $this->toWoundsBonus($experiences);

        return new Level($this->bonusToLevelValue($woundsBonus), $this);
    }

    private function toWoundsBonus(Experiences $experiences)
    {
        $experiencesValue = $experiences->getValue();
        do {
            $woundsBonus = $this->woundsTable->toBonus(
                new Wounds($experiencesValue--, Wounds::WOUNDS, $this->woundsTable)
            );
            /**
             * avoiding standard bonus round-up, which is unacceptable for experiences to level conversion;
             * @see \DrdPlus\Tables\Measurements\Parts\AbstractFileTable::determineBonus
             */
        } while ($woundsBonus->getWounds()->getValue() > $experiences->getValue());

        return $woundsBonus;
    }

    private function bonusToLevelValue(WoundsBonus $woundsBonus)
    {
        /** @see calculation on PPH page 44 top right */
        return $woundsBonus->getValue() - 15;
    }

    /**
     * @param Experiences $experiences
     *
     * @return Level
     */
    public function toTotalLevel(Experiences $experiences)
    {
        $levelSum = 0;
        $remainingExperiences = $experiences->getValue();
        while ($remainingExperiences > 0 /* or conditioned break, see bellow */) {
            $level = $this->toLevel(new Experiences($remainingExperiences, Experiences::EXPERIENCES, $this));
            if ($level->getValue() > 0) {
                $levelSum += $level->getValue();
                $remainingExperiences -= $level->getExperiences()->getValue();
            } else {
                break;
            }
        }

        return new Level($levelSum, $this);
    }

    /**
     * @param Level $level
     *
     * @return Experiences
     */
    public function toExperiences(Level $level)
    {
        $wounds = $this->woundsTable->toWounds(
            new WoundsBonus($this->levelToBonusValue($level), $this->woundsTable)
        );
        $experiencesValue = $wounds->getValue();

        return new Experiences($experiencesValue, Experiences::EXPERIENCES, $this);
    }

    private function levelToBonusValue(Level $level)
    {
        /** @see calculation on PPH page 44 top right */
        return $level->getValue() + 15;
    }

    /**
     * @param Level $level
     * @param bool $isMainProfession
     *
     * @return Experiences
     */
    public function toTotalExperiences(Level $level, $isMainProfession)
    {
        $experiencesSum = 0;
        for ($levelValueToCast = $level->getValue(); $levelValueToCast > 0; $levelValueToCast--) {
            if ($levelValueToCast > 1 || !$isMainProfession) { // main profession has first level for free
                $currentLevel = new Level($levelValueToCast, $this);
                $experiencesSum += $currentLevel->getExperiences()->getValue();
            }
        }

        return new Experiences($experiencesSum, Experiences::EXPERIENCES, $this);
    }

}
