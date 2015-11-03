<?php
namespace DrdPlus\Tests\Tables\Races\Enums\Restrictions;

use DrdPlus\Tables\Races\Enums\Restrictions\RequiresDmAgreement;

class RequiresDmAgreementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_create_infravision()
    {
        $infravision = new RequiresDmAgreement(true);
        $this->assertSame(true, $infravision->getValue());
        $this->assertSame('requires_dm_agreement', $infravision->getCode());

        $infravision = new RequiresDmAgreement(false);
        $this->assertSame(false, $infravision->getValue());
    }
}
