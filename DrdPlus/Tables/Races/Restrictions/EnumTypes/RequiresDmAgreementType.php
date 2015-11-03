<?php
namespace DrdPlus\Tables\Races\Restrictions\EnumTypes;

use Doctrineum\Boolean\BooleanEnumType;
use DrdPlus\Tables\Races\Restrictions\RequiresDmAgreement;

class RequiresDmAgreementType extends BooleanEnumType
{
    const REQUIRES_DM_AGREEMENT = RequiresDmAgreement::REQUIRES_DM_AGREEMENT;
}
