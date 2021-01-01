<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

class Advent16b extends Command
{
    protected $signature = '16b';
    protected $description = 'Advent 16b';

    public function handle()
    {
        $input = trim(file_get_contents(storage_path('16.txt')));

        /* get all the ranges */
        $ranges = collect(explode("\n", trim(Str::before($input, 'your ticket:'))))
            ->reduce(function($carry, $item) {
                preg_match('/^(.*): (\d+)-(\d+) or (\d+)-(\d+)$/', $item, $matches);
                $range1 = range($matches[2], $matches[3]);
                $range2 = range($matches[4], $matches[5]);
                $carry[$matches[1]] = collect($range1)->merge(collect($range2))->unique()->sort()->values();
                return $carry;
            }, collect());

        /* get all the nearby ticket */
        $nearby = collect(explode("\n", trim(Str::after($input, 'nearby tickets:'))))
            ->map(fn($ticket) => explode(',', $ticket));

        /* get my ticket */
        $my_ticket = explode(',', explode("\n", trim(Str::after($input, 'your ticket:')))[0]);

        /* filter out the invalid nearby tickets */
        $valid_tickets = $this->filter_invalid($nearby, $ranges);

        /* find the correct field order */
        $fields = $this->match_fields($valid_tickets, $ranges, $nearby);

        /* and multiple the fields with departure in its name */
        $mult = $fields->filter(fn($field) => strstr($field, 'departure'))
                       ->keys()
                       ->reduce(fn($carry, $item) => $carry *= (int)$my_ticket[$item], 1);

        $this->info($mult);

    }

    /**
     * filter out the invalid tickets by diffing the ticket fields with all possible fields. If we end up with left over fields it's invalid
     *
     * @param $nearby
     * @param $ranges
     * @return mixed
     */
    private function filter_invalid($nearby, $ranges)
    {
        $all = $ranges->values()->flatten()->unique()->sort()->values();

        return $nearby->filter(function($ticket) use ($all) {
            return collect($ticket)->diff($all)->count() === 0;
        });
    }

    /**
     * Find the correct order of the fields.
     * My solution starts with giving each field all possible options, then removing options until all fields only have 1 option.
     *
     * @param $valid_tickets
     * @param $ranges
     * @param $nearby
     * @return \Illuminate\Support\Collection
     */
    private function match_fields($valid_tickets, $ranges, $nearby)
    {
        $positions = collect();
        for($p=0; $p<$ranges->count(); $p++) {
            $positions[$p] = $ranges->keys();
        }

        foreach($valid_tickets as $fields) {
            foreach($fields as $position => $field) {
                foreach($ranges as $name => $range) {
                    if (!$range->contains($field)) {
                        $positions[$position] = $positions[$position]->filter(fn($item) => $item !== $name);
                    }
                }
            }
        }

        $resolved = true;
        $found = collect();
        do {
            $pos = $positions;
            foreach($pos as $key1 => $p1) {
                if ($p1->count() === 1 and !$found->contains($p1->first())) {
                    $found->push($p1->first());
                    foreach($pos as $key2 => $p2) {
                        if ($key2 !== $key1) {
                            $positions[$key2] = $positions[$key2]->filter(fn($item) => $item !== $p1->first());
                        }
                    }
                }
            }

            /* check if we have any fields that have more than 1 option still open */
            $resolved = $positions->filter(fn($p) => $p->count() > 1)->count() === 0;

        } while($resolved === false);

        return $positions->map(fn($pos) => $pos->first());
    }
}
