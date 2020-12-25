<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent1b extends Command
{
    protected $signature = '1b';
    protected $description = 'Advent 1b';

    public function handle()
    {
        $input = file(storage_path('1.txt'), FILE_IGNORE_NEW_LINES);

        foreach ($input as $i) {
            foreach ($input as $j) {
                foreach ($input as $k) {
                    if (($i + $j + $k) === 2020) {
                        $this->info($i*$j*$k);
                        exit;
                    }
                }
            }
        }
    }
}
