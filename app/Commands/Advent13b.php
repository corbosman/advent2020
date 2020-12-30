<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent13b extends Command
{
    protected $signature = '13b';
    protected $description = 'Advent 13b';

    public function handle()
    {
        $input = file(storage_path('13.txt'), FILE_IGNORE_NEW_LINES);

        $schedules = collect(explode(',', $input[1]))->filter(fn($line) => $line !== 'x')->map(fn($line) => (int) $line);

        $timestamp = 0;
        $lcm = 1;

        foreach($schedules as $start => $step) {
            while (($timestamp + $start) % $step != 0) {
                $timestamp += $lcm;
            }
            $lcm *= $step;
        }

        $this->info($timestamp);
    }
}
