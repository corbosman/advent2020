<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

class Advent4a extends Command
{
    protected $signature = '4a';
    protected $description = 'Advent 4a';

    public function handle()
    {
        /* read the file into an array of passport info */
        $passports = collect(explode("\n\n", file_get_contents(storage_path('4.txt'))));

        $valid = $passports
            /* put all passport data on 1 line */
            ->map(fn($line) => str_replace("\n", " ", $line))
            /* turn line into array */
            ->map(fn($line) => explode(" ", $line))
            /* turn array into key=>value pairs */
            ->map(fn($passport) => collect($passport)->mapWithKeys(fn($line) => [Str::before($line, ':') => Str::after($line, ':')]))
            /* filter out all passports that don't have all required fields */
            ->filter(fn($passport) => collect(['byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid'])->diff($passport->keys())->count() === 0);

        $this->info($valid->count());
    }
}
