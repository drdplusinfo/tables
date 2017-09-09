<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Combat;

use DrdPlus\Codes\ProfessionCode;
use DrdPlus\Codes\Properties\PropertyCode;
use DrdPlus\Properties\Body\Height;
use DrdPlus\Properties\Combat\BaseProperties;
use DrdPlus\Properties\Combat\Fight;
use DrdPlus\Tables\Partials\AbstractTable;
use DrdPlus\Tables\Tables;

/**
 * See PPH page 34 left column, @link https://pph.drdplus.info/#tabulka_boje
 */
class FightTable extends AbstractTable
{
    const PROFESSION = 'profession';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader(): array
    {
        return [self::PROFESSION];
    }

    const FIRST_PROPERTY = 'first_property';
    const SECOND_PROPERTY = 'second_property';

    /**
     * @return array|string[]
     */
    protected function getColumnsHeader(): array
    {
        return [self::FIRST_PROPERTY, self::SECOND_PROPERTY];
    }

    /**
     * @return array
     */
    public function getIndexedValues(): array
    {
        return [
            ProfessionCode::FIGHTER => [self::FIRST_PROPERTY => PropertyCode::AGILITY, self::SECOND_PROPERTY => false],
            ProfessionCode::THIEF => [self::FIRST_PROPERTY => PropertyCode::KNACK, self::SECOND_PROPERTY => PropertyCode::AGILITY],
            ProfessionCode::RANGER => [self::FIRST_PROPERTY => PropertyCode::KNACK, self::SECOND_PROPERTY => PropertyCode::AGILITY],
            ProfessionCode::WIZARD => [self::FIRST_PROPERTY => PropertyCode::INTELLIGENCE, self::SECOND_PROPERTY => PropertyCode::AGILITY],
            ProfessionCode::THEURGIST => [self::FIRST_PROPERTY => PropertyCode::INTELLIGENCE, self::SECOND_PROPERTY => PropertyCode::AGILITY],
            ProfessionCode::PRIEST => [self::FIRST_PROPERTY => PropertyCode::CHARISMA, self::SECOND_PROPERTY => PropertyCode::AGILITY],
        ];
    }

    /**
     * @param ProfessionCode $professionCode
     * @param BaseProperties $baseProperties
     * @param Height $height
     * @param Tables $tables
     * @return Fight
     */
    public function getFightForProfession(
        ProfessionCode $professionCode,
        BaseProperties $baseProperties,
        Height $height,
        Tables $tables
    )
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return Fight::getIt($professionCode, $baseProperties, $height, $tables);
    }

}