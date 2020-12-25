<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent2a extends Command
{
    protected $signature = '2a';
    protected $description = 'Advent 2a';

    public function handle()
    {
        $input = collect(file(storage_path('2.txt'), FILE_IGNORE_NEW_LINES));

        $valid = $input->filter(function($password) {
            preg_match('/^(\d+)-(\d+) ([a-z]): ([a-z]+)$/', $password, $matches);
            $min = $matches[1];
            $max = $matches[2];
            $char = $matches[3];
            $password = $matches[4];

            $count = substr_count($password, $char);

            return $count >= $min and $count <= $max;
        });

        $this->info($valid->count());
    }
}
