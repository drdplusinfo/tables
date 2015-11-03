<?php
namespace DrdPlus\Tables\Races\Enums\Restrictions;

use Doctrineum\Boolean\BooleanEnum;
use DrdPlus\Properties\PropertyInterface;

class RequiresDmAgreement extends BooleanEnum implements PropertyInterface
{
    const REQUIRES_DM_AGREEMENT = 'requires_dm_agreement';

    public static function getIt($value)
    {
        return new static($value);
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return self::REQUIRES_DM_AGREEMENT;
    }

}
