<?php

namespace App\Helpers;

use DateTime;

use function PHPUnit\Framework\returnSelf;

class Calculator
{
    /**
     * Calculate difference between time in hours
     * 
     * @param string|null $start
     * @param string|null $stop
     * 
     * @return int
     */
    public function timeInMinutes($start, $stop)
    {
        if(empty($start))
            return 0;
        
        if(empty($stop))
            $stop = date("Y-m-d H:i:s");

        $time = new DateTime($start);
        $diff = $time->diff(new DateTime($stop));
        $minutes = ($diff->days * 24 * 60) +
                ($diff->h * 60) + $diff->i;
        
        return $minutes;
    }
}