<?php

namespace App\Service\Movie;

class RateCalculator
{
    public function calculate(float $count, float $sum): float
    {
        return bcdiv($sum, $count, 2);
    }
}
