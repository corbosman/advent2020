<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent6b extends Command
{
    protected $signature = '6b';
    protected $description = 'Advent 6b';

    public function handle()
    {
        /* read the file */
        $sum = collect(explode("\n\n", file_get_contents(storage_path('6.txt'))))
            /* put all letters on 1 line */
            ->map(fn($line) => collect(explode(' ', trim(str_replace(["\n"], [" "], $line)))))
            /* change to array */
            ->map(fn($answers) => $answers->map(fn($answer) => collect(str_split($answer))))
            /* find number of people, combine all letters then look for sequences of that amount */
            ->map(function($answer) {
                $people = $answer->count();
                $answers = $answer->reduce(function($carry, $item) {
                    return $carry->concat($item);
                },collect())->sort()->implode('');
                /* this preg_match_all looks for sequences */
                return preg_match_all('/([a-z])\1{' . ($people-1) . '}/', $answers, $matches);
            })->sum();

        $this->info($sum);
    }
}
