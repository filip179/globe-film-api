<?php

namespace App\Tests\Unit;

use App\Service\Movie\RateCalculator;
use App\Tests\Components\AppTestCase;

class RateCalculatorTest extends AppTestCase
{
    /** @test */
    function test_calculate()
    {
        $dataProvider = [
            //[sum,count,result]
            [20, 4, 5.0],
            [15, 4, 3.75],
            [5, 5, 1.0],
            [10, 5, 2.0]
        ];

        $calculator = new RateCalculator();

        foreach ($dataProvider as $row) {
            [$sum, $count, $result] = $row;
            $this->assertIsFloat($calculator->calculate($count, $sum));
            $this->assertEquals($calculator->calculate($count, $sum), $result);
        }
    }
}