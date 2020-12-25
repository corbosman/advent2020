<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

class Advent7b extends Command
{
    protected $signature = '7b';
    protected $description = 'Advent 7b';

    public function handle()
    {
        $rules = collect(file(storage_path('7.txt'), FILE_IGNORE_NEW_LINES))
            ->mapWithKeys(function($rule) {
                $bag = Str::before($rule, ' bags');
                $sub_bags = collect(explode(',', Str::after($rule, 'contain ')))
                    ->map(fn($sub) => trim($sub))
                    ->mapWithKeys(function($sub) {
                        if (str_contains($sub, 'no other')) return [];
                        preg_match('/^(\d+) (.*) bag/', $sub, $matches);
                        return [$matches[2] => $matches[1]];
                    });
                return [$bag => $sub_bags];
            });

        $count = $this->fits($rules, 'shiny gold');

        $this->info($count);
    }

    public function fits($rules, $color) : int
    {
        $count = 0;

        foreach ($rules[$color] as $key => $value) {
            $count += $value + ($value * $this->fits($rules, $key));
        }

        return $count;
    }
}
