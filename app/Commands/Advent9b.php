<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent9b extends Command
{
    protected $signature = '9b';
    protected $description = 'Advent 9b';

    public function handle()
    {
        $input = collect(file(storage_path('9.txt'), FILE_IGNORE_NEW_LINES));
        $invalid = '1721308972'; // from 9a

        /* look for a sequence of numbers that add up to the invalid number we found earlier */
        for($i=0; $i<count($input); $i++) {
            $sum = 0;
            for($j=$i; $j<count($input); $j++) {
                $sum += (int)$input[$j];
                if ($sum > $invalid) break;
                if($sum == $invalid) break 2;
            }
        }

        /* now $i contains the start of the sequence, and $j the end */
        $numbers = $input->slice($i, $j-$i);

        $smallest = $numbers->min();
        $largest  = $numbers->max();

        $this->info($smallest+$largest);

    }
}
