<?php
namespace DrdPlus\Tables\Races\Restrictions\EnumTypes;

use DrdPlus\Properties\EnumTypes\AbstractBooleanType;
use DrdPlus\Tables\Races\Restrictions\RequiresDmAgreement;

class RequiresDmAgreementType extends AbstractBooleanType
{
    const REQUIRES_DM_AGREEMENT = RequiresDmAgreement::REQUIRES_DM_AGREEMENT;
}
