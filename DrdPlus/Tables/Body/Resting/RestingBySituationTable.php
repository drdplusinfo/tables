<?php
namespace DrdPlus\Tables\Body\Resting;

use DrdPlus\Tables\Partials\AbstractFileTableWithPercents;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound;
use DrdPlus\Tables\Partials\Exceptions\UnexpectedPercents;
use Granam\Tools\ValueDescriber;

class RestingBySituationTable extends AbstractFileTableWithPercents
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/resting_by_situation.csv';
    }

    protected function getRowsHeader()
    {
        return ['situation'];
    }

    /**
     * @param string $situationCode
     * @param RestingSituationPercents $restingSituationPercents
     * @return int
     * @throws \DrdPlus\Tables\Body\Resting\Exceptions\UnknownCodeOfRestingInfluence
     * @throws \DrdPlus\Tables\Body\Resting\Exceptions\UnexpectedRestingSituationPercents
     */
    public function getRestingBonusBySituation($situationCode, RestingSituationPercents $restingSituationPercents)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return $this->getBonusBy($situationCode, $restingSituationPercents);
        } catch (RequiredRowDataNotFound $requiredRowDataNotFound) {
            throw new Exceptions\UnknownCodeOfRestingInfluence(
                'Unknown influence on healing code ' . ValueDescriber::describe($situationCode)
            );
        } catch (UnexpectedPercents $unexpectedPercents) {
            throw new Exceptions\UnexpectedRestingSituationPercents($unexpectedPercents->getMessage());
        }
    }

}