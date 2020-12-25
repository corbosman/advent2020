<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent1a extends Command
{
    protected $signature = '1a';
    protected $description = 'Advent 1a';

    public function handle()
    {
        $input = file(storage_path('1.txt'), FILE_IGNORE_NEW_LINES);

        foreach ($input as $i) {
            foreach ($input as $j) {
                if (($i + $j) === 2020) {
                    $this->info($i*$j);
                    exit;
                }
            }
        }
    }
}
