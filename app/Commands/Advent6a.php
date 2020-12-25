<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent6a extends Command
{
    protected $signature = '6a';
    protected $description = 'Advent 6a';

    public function handle()
    {
        $sum = collect(explode("\n\n", file_get_contents(storage_path('6.txt'))))
            ->map(fn($line) => str_replace(["\n", " "], ["", ""], $line))
            ->dump()
            ->map(fn($line) => collect(str_split($line))->unique()->count())
            ->sum();
    }
}
