<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent15b extends Command
{
    protected $signature = '15b';
    protected $description = 'Advent 15b';

    public function handle()
    {
        $input = explode(',', trim(file_get_contents(storage_path('15.txt'))));
        $history = [];
        $spoken = null;

        for($count=1; $count<count($input)+1; $count++) {
            $spoken = $input[$count-1];
            $history[$spoken] = isset($history[$spoken]) ? $history[$spoken]->prepend($count) : collect()->push($count);
        }

        for(; $count<=30000000; $count++) {
            if (!isset($history[$spoken]) or $history[$spoken]->count() === 1) {
                $spoken = 0;
            } else {
                $spoken = $count-1-$history[$spoken][1];
            }
            $history[$spoken] = isset($history[$spoken]) ? $history[$spoken]->prepend($count)->slice(0,2) : collect()->push($count);
        }
        $this->info($spoken);
    }
}
