<?php

namespace Tests\Feature;

use App\Helpers\Calculator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalculatorTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_get_time_in_minutes_start_empty()
    {
        $service = new Calculator();

        $this->assertEquals($service->timeInMinutes(null, date('Y-m-d H:i:s')), 0);
    }

    public function test_get_time_in_minutes()
    {
        $service = new Calculator();

        $this->assertEquals($service->timeInMinutes('2021-04-04 13:25:00', '2021-04-04 15:50:00'), 145);
    }
}
