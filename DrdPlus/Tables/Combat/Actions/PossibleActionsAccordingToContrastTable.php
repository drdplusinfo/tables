<?php
namespace DrdPlus\Tables\Combat\Actions;

use DrdPlus\Tables\Partials\AbstractFileTable;
use Granam\Integer\PositiveInteger;

/**
 * See PPH page 129, left column (table without name), @link https://pph.drdplus.jaroslavtyc.com/#tabulka_moznych_cinnosti_podle_kontrastu
 */
class PossibleActionsAccordingToContrastTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/possible_actions_according_to_contrast.csv';
    }

    const POSSIBLE_ACTIONS_EXAMPLE = 'possible_actions_example';
    const FIGHT_TYPE_BY_CONTRAST = 'fight_type_by_contrast';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [self::POSSIBLE_ACTIONS_EXAMPLE => self::STRING, self::FIGHT_TYPE_BY_CONTRAST => self::STRING];
    }

    const CONTRAST = 'contrast';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [self::CONTRAST];
    }

    /**
     * @param PositiveInteger $contrast
     * @return string
     */
    public function getPossibleActionsExample(PositiveInteger $contrast)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getPossibility($contrast, self::POSSIBLE_ACTIONS_EXAMPLE);
    }

    /**
     * @param PositiveInteger $contrast
     * @param string $actionName
     * @return string
     */
    private function getPossibility(PositiveInteger $contrast, $actionName)
    {
        $contrastValue = $contrast->getValue();
        if ($contrastValue > 6) {
            $contrastValue = 6;
        }

        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue($contrastValue, $actionName);
    }

    /**
     * @param PositiveInteger $contrast
     * @return string
     */
    public function getFightTypeByContrast(PositiveInteger $contrast)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getPossibility($contrast, self::FIGHT_TYPE_BY_CONTRAST);
    }
}