<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent3b extends Command
{
    protected $signature = '3b';
    protected $description = 'Advent 3b';

    public function handle()
    {
        $input = collect(file(storage_path('3.txt'), FILE_IGNORE_NEW_LINES))->map(fn($line) => str_split($line));
        $width = count($input->first());
        $height = count($input);
        $answers = collect();

        $slopes = [
            ['w' => 1, 'h' => 1],
            ['w' => 3, 'h' => 1],
            ['w' => 5, 'h' => 1],
            ['w' => 7, 'h' => 1],
            ['w' => 1, 'h' => 2],
        ];

        foreach ($slopes as $slope) {
            $w = 0;
            $h = 0;
            $trees = 0;

            do {
                if ($input[$h][$w % $width] === '#') {
                    $trees++;
                }
                $w+=$slope['w'];
                $h+=$slope['h'];
            } while ($h < $height);

            $answers->push($trees);
        }

        /* multiply all answers */
        $multiplied = $answers->reduce(fn ($carry, $item) => $carry * $item, 1);

        $this->info($multiplied);
    }
}
