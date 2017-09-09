<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Measurements\Tools;

use Drd\DiceRolls\Templates\Rollers\Roller1d6;

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
        if ($this->roller1d6->roll()->getValue() <= $maxRollToGetValue) {
            return 1;
        }

        return 0;
    }

}