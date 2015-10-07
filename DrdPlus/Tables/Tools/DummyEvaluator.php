<?php
namespace DrdPlus\Tables\Tools;

use DrdPlus\Tables\Exceptions\UnsupportedMethodCalled;

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
