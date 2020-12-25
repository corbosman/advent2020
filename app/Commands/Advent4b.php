<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

class Advent4b extends Command
{
    protected $signature = '4b';
    protected $description = 'Advent 4b';

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
            ->filter(fn($passport) => collect(['byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid'])->diff($passport->keys())->count() === 0)
            /* check valid birth year */
            ->filter(fn($passport) => (int)$passport['byr'] >= 1920 and (int)$passport['byr'] <= 2002)
            /* check valid issue year */
            ->filter(fn($passport) => (int)$passport['iyr'] >= 2010 and (int)$passport['iyr'] <= 2020)
            /* check valid expire year */
            ->filter(fn($passport) => (int)$passport['eyr'] >= 2020 and (int)$passport['eyr'] <= 2030)
            /* check valid height, either cm or inches */
            ->filter(function ($passport) {
                preg_match('/^(\d+)(\w+)$/', $passport['hgt'], $matches);
                $height = $matches[1];
                $unit = $matches[2];

                return $unit == 'cm'
                    ? ($height >= 150 and $height <= 193)
                    : ($height >= 59 and $height <= 76);
            })
            /* check valid hair color */
            ->filter(fn ($passport) => preg_match('/^#[a-f0-9]{6}$/', $passport['hcl']))
            /* check valid eye color */
            ->filter(fn ($passport) => collect(['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth'])->contains($passport['ecl']))
            /* check valid passport id */
            ->filter(fn ($passport) => preg_match('/^[0-9]{9}$/', $passport['pid']));

        $this->info($valid->count());
    }
}
