<?php
namespace DrdPlus\Tables\Measurements\Tools;

use Drd\DiceRoll\Templates\Rollers\Roller1d6;

class DiceChanceEvaluator implements EvaluatorInterface
{
    /**
     * @var Roller1d6
     */
    private $roller1d6;

    public function __construct(Roller1d6 $roller1d6)
    {
        $this->roller1d6 = $roller1d6;
    }

    /**
     * @param int $maxRollToGetValue
     *
     * @return int
     */
    public function evaluate($maxRollToGetValue)
    {
        if ($maxRollToGetValue <= $this->roller1d6->roll()->getValue()) {
            return 1;
        }

        return 0;
    }

}
