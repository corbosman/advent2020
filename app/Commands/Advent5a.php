<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent5a extends Command
{
    protected $signature = '5a';
    protected $description = 'Advent 5a';

    public function handle()
    {
        $answer = collect(file(storage_path('5.txt'), FILE_IGNORE_NEW_LINES))
            ->map(function($pass) {
                $row = bindec(str_replace(['F','B'], ['0','1'], substr($pass, 0, 7)));
                $column = bindec(str_replace(['L','R'], ['0','1'], substr($pass, 7, 3)));
                return ($row*8)+$column;
            })->max();

        $this->info($answer);
    }
}
