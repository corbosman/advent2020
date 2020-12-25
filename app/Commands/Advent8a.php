<?php

namespace App\Commands;

use App\Advent\Advent8\Computer;
use App\Advent\Advent8\State;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent8a extends Command
{
    protected $signature = '8a';
    protected $description = 'Advent 8a';

    public function handle()
    {
        $instructions = file(storage_path('8.txt'), FILE_IGNORE_NEW_LINES);

        $state = (new Computer(new State($instructions, 0, 0)))->run();

        $this->info($state->accumulator);
    }

}
