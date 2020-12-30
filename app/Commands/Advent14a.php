<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent14a extends Command
{
    protected $signature = '14a';
    protected $description = 'Advent 14a';

    public function handle()
    {
        $input = file(storage_path('14.txt'), FILE_IGNORE_NEW_LINES);
        $mem = [];
        $mask = 0;

        foreach($input as $i) {
            if (preg_match('/^mask = (.*)$/', $i, $matches)) {
                $mask = ltrim($matches[1], 'X');
            } else {
                preg_match('/^mem\[(\d+)] = (.*)$/', $i, $matches);

                $mem[$matches[1]] = (((int) $matches[2]) & $this->and_mask($mask)) | $this->or_mask($mask);;
            }
        }
        $this->info(collect($mem)->sum());
    }

    private function and_mask($mask)
    {
        return bindec(str_replace(['1', 'X'], ['0', '1'], $mask));
    }

    private function or_mask($mask)
    {
        return bindec(str_replace('X', '0', $mask));
    }
}
