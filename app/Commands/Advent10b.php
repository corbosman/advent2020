<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Collection;
use LaravelZero\Framework\Commands\Command;

class Advent10b extends Command
{
    protected $signature = '10b';
    protected $description = 'Advent 10b';

    public function handle()
    {
        $adapters = collect(file(storage_path('10_test.txt'), FILE_IGNORE_NEW_LINES))
            ->sort()
            ->map(fn($adapter) => (int)$adapter)
            ->values();

        $highest = $adapters->max();

        /* add the wall adapter */
        $adapters->push($highest+3);

        $cache = [];

        $result = $this->connections(0, $adapters, $cache);

        $this->info($result);
    }

    public function connections(int $current, Collection $adapters, array $cache) : int
    {
        /* if we only have 1 adapter, we only have 1 option */
        if ($adapters->count() === 1) return 1;

        $count = 0;

        /* find the adapters that our current adapter can connect to */
        $connectable = $adapters->filter(fn($adapter) => $adapter <= $current+3)->values();

        /* for each adapter, find new connection possibilities */
        foreach($connectable as $index => $adapter) {
            if (!isset($cache[$adapter])) {
                $cache[$adapter] = $this->connections($adapter, $adapters->slice($index+1), $cache);
            }
            $count += $cache[$adapter];
        }

        return $count;
    }

}
