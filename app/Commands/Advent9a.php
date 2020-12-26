<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent9a extends Command
{
    protected $signature = '9a';
    protected $description = 'Advent 9a';

    public function handle()
    {
        $input = file(storage_path('9.txt'), FILE_IGNORE_NEW_LINES);
        $cache = collect();

        /* fill the cache */
        for($i=0; $i<25; $i++) {
            for($j=0; $j<25; $j++) {
                if ($i!=$j) {
                    $cache->push($input[$j] + $input[$i]);
                }
            }
        }

        for($i=25; $i<count($input); $i++) {
            if(!$cache->contains($input[$i])) {
                $this->info("{$input[$i]} is not a count of the 25 numbers before it");
                exit;
            } else {
                $cache = $cache->slice(25);
                for($j=$i; $j>($i-25); $j--) {
                    $cache->push($input[$i] + $input[$j]);
                }
            }
        }

        $this->info("we did not find one!");
    }

}
