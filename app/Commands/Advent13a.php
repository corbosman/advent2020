<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent13a extends Command
{
    protected $signature = '13a';
    protected $description = 'Advent 13a';

    public function handle()
    {
        $input = file(storage_path('13.txt'), FILE_IGNORE_NEW_LINES);
        $timestamp = $input[0];
        $schedules = collect(explode(',', $input[1]))->filter(fn($line) => $line !== 'x')->values();

        $earliest = $schedules->mapWithKeys(fn($schedule) => [$schedule => ($schedule - $timestamp % $schedule)])
            ->sort();

        $this->info($earliest->first() * $earliest->keys()->first());

    }
}
