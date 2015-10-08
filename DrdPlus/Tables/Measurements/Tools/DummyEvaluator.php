<?php
namespace DrdPlus\Tables\Measurements\Tools;

use DrdPlus\Tables\Measurements\Exceptions\UnsupportedMethodCalled;

class DummyEvaluator implements EvaluatorInterface
{
    /**
     * @param float $maxRollToGetValue
     *
     * @return int
     */
    public function evaluate($maxRollToGetValue)
    {
        throw new UnsupportedMethodCalled('Dummy evaluator should never be called');
    }

}
