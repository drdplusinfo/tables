<?php
namespace DrdPlus\Tables;

class DummyEvaluator implements EvaluatorInterface
{
    /**
     * @param float $maxRollToGetValue
     *
     * @return int
     */
    public function evaluate($maxRollToGetValue)
    {
        throw new Exceptions\UnsupportedMethodCalled('Dummy evaluator should never be called');
    }

}
