<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Collection;
use LaravelZero\Framework\Commands\Command;

class Advent10b extends Command
{
    protected $signature = '10b';
    protected $description = 'Advent 10b';
    protected $cache = [];

    public function handle()
    {
        $adapters = collect(file(storage_path('10.txt'), FILE_IGNORE_NEW_LINES))
            ->sort()
            ->map(fn($adapter) => (int)$adapter)
            ->values();

        /* add the wall adapter */
        $adapters->push($adapters->max()+3);

        /* find the results starting from adapter 0 */
        $result = $this->connections(0, $adapters);

        $this->info($result);
    }

    public function connections(int $current, Collection $adapters) : int
    {
        /* if we only have 1 adapter, we only have 1 option */
        if ($adapters->count() === 1) return 1;

        $count = 0;

        /* find the adapters that our current adapter can connect to */
        $connectable = $adapters->filter(fn($adapter) => $adapter <= $current+3)->values();

        /* for each adapter, find new connection possibilities */
        foreach($connectable as $index => $adapter) {
//            if (!isset($this->cache[$adapter])) {
//                $this->cache[$adapter] = $this->connections($adapter, $adapters->slice($index+1));
//            }
//            $count += $this->cache[$adapter];
              $count += $this->connections($adapter, $adapters->slice($index+1));
        }

        return $count;
    }

}
