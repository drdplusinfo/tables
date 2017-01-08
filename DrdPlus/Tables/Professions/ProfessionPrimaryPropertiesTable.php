<?php
namespace DrdPlus\Tables\Professions;

use DrdPlus\Codes\ProfessionCode;
use DrdPlus\Codes\PropertyCode;
use DrdPlus\Tables\Partials\AbstractFileTable;
use DrdPlus\Tables\Partials\Exceptions\RequiredRowNotFound;
use Granam\Tools\ValueDescriber;

class ProfessionPrimaryPropertiesTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/profession_primary_properties.csv';
    }

    const FIRST_PRIMARY_PROPERTY = 'first_primary_property';
    const SECOND_PRIMARY_PROPERTY = 'second_primary_property';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [self::FIRST_PRIMARY_PROPERTY => self::STRING, self::SECOND_PRIMARY_PROPERTY => self::STRING];
    }

    const PROFESSION = 'profession';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader()
    {
        return [self::PROFESSION];
    }

    /**
     * @param ProfessionCode $professionCode
     * @return array|PropertyCode[]
     * @throws \DrdPlus\Tables\Professions\Exceptions\UnknownProfession
     */
    public function getPrimaryPropertiesOf(ProfessionCode $professionCode)
    {
        try {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return array_map(
                function ($propertyValue) {
                    return PropertyCode::getIt($propertyValue);
                },
                array_values($this->getRow([$professionCode]))
            );
        } catch (RequiredRowNotFound $requiredRowNotFound) {
            throw new Exceptions\UnknownProfession(
                'Given profession is not known: ' . ValueDescriber::describe($professionCode)
            );
        }
    }
}