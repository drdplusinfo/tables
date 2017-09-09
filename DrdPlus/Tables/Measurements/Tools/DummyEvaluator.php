<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Measurements\Tools;

use DrdPlus\Tables\Measurements\Exceptions\UnsupportedMethodCalled;

class DummyEvaluator implements EvaluatorInterface
{
    /**
     * @param int $maxRollToGetValue
     * @throws \DrdPlus\Tables\Measurements\Exceptions\UnsupportedMethodCalled
     */
    public function evaluate($maxRollToGetValue)
    {
        throw new UnsupportedMethodCalled('Dummy evaluator should never be called');
    }

}
