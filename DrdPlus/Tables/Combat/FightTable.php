<?php
namespace DrdPlus\Tables\Combat;

use DrdPlus\Codes\ProfessionCode;
use DrdPlus\Codes\Properties\PropertyCode;
use DrdPlus\Properties\Body\Height;
use DrdPlus\Properties\Combat\BaseProperties;
use DrdPlus\Properties\Combat\Fight;
use DrdPlus\Tables\Partials\AbstractTable;
use DrdPlus\Tables\Tables;

/**
 * See PPH page 34 left column, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_boje
 */
class FightTable extends AbstractTable
{
    const PROFESSION = 'profession';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [self::PROFESSION];
    }

    const FIRST_PROPERTY = 'first_property';
    const SECOND_PROPERTY = 'second_property';

    /**
     * @return array|string[]
     */
    protected function getColumnsHeader()
    {
        return [self::FIRST_PROPERTY, self::SECOND_PROPERTY];
    }

    /**
     * @return array
     */
    public function getIndexedValues()
    {
        return [
            ProfessionCode::FIGHTER => [PropertyCode::AGILITY, false],
            ProfessionCode::THIEF => [PropertyCode::KNACK, PropertyCode::AGILITY],
            ProfessionCode::RANGER => [PropertyCode::KNACK, PropertyCode::AGILITY],
            ProfessionCode::WIZARD => [PropertyCode::INTELLIGENCE, PropertyCode::AGILITY],
            ProfessionCode::THEURGIST => [PropertyCode::INTELLIGENCE, PropertyCode::AGILITY],
            ProfessionCode::PRIEST => [PropertyCode::CHARISMA, PropertyCode::AGILITY],
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
        return new Fight($professionCode, $baseProperties, $height, $tables);
    }

}