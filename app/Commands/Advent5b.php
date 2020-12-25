<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent5b extends Command
{
    protected $signature = '5b';
    protected $description = 'Advent 5b';

    public function handle()
    {
        /* all seats are basically 7 bits + 3 bits is 10 bits, or 1024 seats */
        $all = collect(range(0,1023));

        /* all the taken seats */
        $taken = collect(file(storage_path('5.txt'), FILE_IGNORE_NEW_LINES))
            ->map(function($pass) {
                $row = str_replace(['F','B'], ['0','1'], substr($pass, 0, 7));
                $column = str_replace(['L','R'], ['0','1'], substr($pass, 7, 3));
                return bindec($row.$column);
            })->sort()->values();

        /* take the difference */
        $free = $all->diff($taken);

        /* and find the one which does not have adjacent taken seats */
        $mine = $free->filter(function($seat) use ($free) {
            return $seat > 0 and $seat < 1023 and !isset($free[$seat-1]) and !isset($free[$seat+1]);
        })->first();

        $this->info($mine);
    }
}
