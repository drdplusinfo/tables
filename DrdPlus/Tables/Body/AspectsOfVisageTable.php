<?php
namespace DrdPlus\Tables\Body;

use DrdPlus\Codes\Properties\PropertyCode;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Base\Charisma;
use DrdPlus\Properties\Base\Intelligence;
use DrdPlus\Properties\Base\Knack;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Base\Will;
use DrdPlus\Properties\Derived\Beauty;
use DrdPlus\Properties\Derived\Dangerousness;
use DrdPlus\Properties\Derived\Dignity;
use DrdPlus\Tables\Partials\AbstractTable;

/**
 * See PPH page 41 right column, @link https://pph.drdplus.info/#tabulka_aspektu_vzhledu
 */
class AspectsOfVisageTable extends AbstractTable
{
    const ASPECT_OF_VISAGE = 'aspect_of_visage';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader(): array
    {
        return [self::ASPECT_OF_VISAGE];
    }

    const FIRST_PROPERTY = 'first_property';
    const SECOND_PROPERTY = 'second_property';
    const SUM_OF_FIRST_AND_SECOND_PROPERTY_DIVISOR = 'sum_of_first_and_second_property_divisor';
    const THIRD_PROPERTY = 'third_property';
    const THIRD_PROPERTY_DIVISOR = 'third_property_divisor';

    /**
     * @return array|string[]
     */
    protected function getColumnsHeader(): array
    {
        return [
            self::FIRST_PROPERTY,
            self::SECOND_PROPERTY,
            self::SUM_OF_FIRST_AND_SECOND_PROPERTY_DIVISOR,
            self::THIRD_PROPERTY,
            self::THIRD_PROPERTY_DIVISOR,
        ];
    }

    /**
     * @return array|string[]
     */
    public function getIndexedValues(): array
    {
        return [
            PropertyCode::BEAUTY => [
                self::FIRST_PROPERTY => PropertyCode::AGILITY,
                self::SECOND_PROPERTY => PropertyCode::KNACK,
                self::SUM_OF_FIRST_AND_SECOND_PROPERTY_DIVISOR => 2,
                self::THIRD_PROPERTY => PropertyCode::CHARISMA,
                self::THIRD_PROPERTY_DIVISOR => 2,
            ],
            PropertyCode::DANGEROUSNESS => [
                self::FIRST_PROPERTY => PropertyCode::STRENGTH,
                self::SECOND_PROPERTY => PropertyCode::WILL,
                self::SUM_OF_FIRST_AND_SECOND_PROPERTY_DIVISOR => 2,
                self::THIRD_PROPERTY => PropertyCode::CHARISMA,
                self::THIRD_PROPERTY_DIVISOR => 2,
            ],
            PropertyCode::DIGNITY => [
                self::FIRST_PROPERTY => PropertyCode::INTELLIGENCE,
                self::SECOND_PROPERTY => PropertyCode::WILL,
                self::SUM_OF_FIRST_AND_SECOND_PROPERTY_DIVISOR => 2,
                self::THIRD_PROPERTY => PropertyCode::CHARISMA,
                self::THIRD_PROPERTY_DIVISOR => 2,
            ],
        ];
    }

    /**
     * @param Agility $agility
     * @param Knack $knack
     * @param Charisma $charisma
     * @return Beauty
     */
    public function getBeauty(Agility $agility, Knack $knack, Charisma $charisma)
    {
        return Beauty::getIt($agility, $knack, $charisma);
    }

    /**
     * @param Strength $strength
     * @param Will $will
     * @param Charisma $charisma
     * @return Dangerousness
     */
    public function getDangerousness(Strength $strength, Will $will, Charisma $charisma)
    {
        return Dangerousness::getIt($strength, $will, $charisma);
    }

    /**
     * @param Intelligence $intelligence
     * @param Will $will
     * @param Charisma $charisma
     * @return Dignity
     */
    public function getDignity(Intelligence $intelligence, Will $will, Charisma $charisma)
    {
        return Dignity::getIt($intelligence, $will, $charisma);
    }

}