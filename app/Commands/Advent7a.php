<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

class Advent7a extends Command
{
    protected $signature = '7a';
    protected $description = 'Advent 7a';

    public function handle()
    {
        /* get some kind of array of bag data we can work with */
        $rules = collect(file(storage_path('7.txt'), FILE_IGNORE_NEW_LINES))
            ->mapWithKeys(function($rule) {
                $bag = Str::before($rule, ' bags');
                $sub_bags = collect(explode(',', Str::after($rule, 'contain ')))
                    ->map(fn($sub) => trim($sub))
                    ->map(function($sub) {
                        if (str_contains($sub, 'no other')) return null;
                        preg_match('/^\d+ (.*) bag/', $sub, $matches);
                        return $matches[1];
                    })
                    ->filter(fn($rule) => $rule !== null);
                return [$bag => $sub_bags];
            });

        $count = 0;

        /* recursively check if it fits */
        foreach ($rules as $bag => $rule) {
            if ($this->fitsShinyGold($rules, $rule)) {
                $count++;
            }
        }

        $this->info($count);
    }

    public function fitsShinyGold($rules, $rule) : bool
    {
        if ($rule->contains('shiny gold')) {
            return true;
        }

        foreach ($rule as $color) {
            if ($this->fitsShinyGold($rules, $rules[$color])) {
                return true;
            }
        }

        return false;
    }
}
