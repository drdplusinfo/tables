<?php
namespace DrdPlus\Tables\History;

use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound;
use Granam\String\StringInterface;
use Granam\Tools\ValueDescriber;

class BackgroundPointsTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/background_points.csv';
    }

    const BACKGROUND_POINTS = 'background_points';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::BACKGROUND_POINTS => self::POSITIVE_INTEGER,
        ];
    }

    const FATE = 'fate';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [
            self::FATE,
        ];
    }

    /**
     * @param string|StringInterface $choice
     * @return int
     * @throws \DrdPlus\Tables\History\Exceptions\UnknownChoice
     */
    public function getBackgroundPointsByChoice($choice)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->getValue($choice, self::BACKGROUND_POINTS);
        } catch (RequiredRowNotFound $requiredRowNotFound) {
            throw new Exceptions\UnknownChoice('Unknown choice ' . ValueDescriber::describe($choice));
        }
    }

}