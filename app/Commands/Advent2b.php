<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent2b extends Command
{
    protected $signature = '2b';
    protected $description = 'Advent 2b';

    public function handle()
    {
        $input = collect(file(storage_path('2.txt'), FILE_IGNORE_NEW_LINES));

        $valid = $input->filter(function($password) {
            preg_match('/^(\d+)-(\d+) ([a-z]): ([a-z]+)$/', $password, $matches);
            $first = $matches[1];
            $second = $matches[2];
            $char = $matches[3];
            $password = $matches[4];

            $count = 0;
            if ($password[$first-1] === $char) {
                $count++;
            }

            if ($password[$second-1] === $char) {
                $count++;
            }

            return $count === 1;
        });

        $this->info($valid->count());
    }
}
