<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

class Advent16a extends Command
{
    protected $signature = '16a';
    protected $description = 'Advent 16a';

    public function handle()
    {
        $input = trim(file_get_contents(storage_path('16.txt')));

        /* get all the ranges into 1 array */
        $ranges = collect(explode("\n", trim(Str::before($input, 'your ticket:'))))
            ->reduce(function($carry, $item) {
                preg_match('/: (\d+)-(\d+) or (\d+)-(\d+)$/', $item, $matches);
                $range1 = range($matches[1], $matches[2]);
                $range2 = range($matches[3], $matches[4]);
                return $carry->merge(collect($range1))->merge(collect($range2))->unique()->sort();
            }, collect());

        /* get all the nearby ticket numbers into one array */
        $nearby = collect(explode("\n", trim(Str::after($input, 'nearby tickets:'))))
            ->map(fn($ticket) => explode(',', $ticket))
            ->flatten();

        $error_rate = $nearby->reduce(fn($carry, $item) => $ranges->contains($item) ? $carry : $carry+$item, 0);

        $this->info($error_rate);
    }

}
