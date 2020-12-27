<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent10a extends Command
{
    protected $signature = '10a';
    protected $description = 'Advent 10a';

    public function handle()
    {
        /* read in the file, */
        $adapters = collect(file(storage_path('10.txt'), FILE_IGNORE_NEW_LINES))
            /* add the wall charger */
            ->push(0)
            /* sort */
            ->sort()
            /* change to int */
            ->map(fn($adapter) => (int)$adapter)
            /* fix the keys */
            ->values();

        /* for each adapter, find the difference with the next adapter. For the last one just use 3. */
        $differences = $adapters->map(fn($adapter, $i) => isset($adapters[$i+1]) ? ($adapters[$i+1] - $adapter) : 3)
                                /* group by either 1 or 3 */
                                ->groupBy(fn($value) => $value);

        $this->info(count($differences[1]) * count($differences[3]));
    }
}
