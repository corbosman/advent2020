<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent3a extends Command
{
    protected $signature = '3a';
    protected $description = 'Advent 3a';

    public function handle()
    {
        $input = collect(file(storage_path('3.txt'), FILE_IGNORE_NEW_LINES))->map(fn($line) => str_split($line));
        $width = count($input->first());
        $height = count($input);

        $w = 0;
        $h=0;
        $trees = 0;

        do {
            if ($input[$h][$w % $width] === '#') {
                $trees++;
            }
            $w+=3;
            $h+=1;
        } while ($h < $height);

        $this->info($trees);
    }
}
