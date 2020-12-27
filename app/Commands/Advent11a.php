<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Collection;
use LaravelZero\Framework\Commands\Command;

class Advent11a extends Command
{
    protected $signature = '11a';
    protected $description = 'Advent 11a';

    public function handle()
    {
        /* read all seats into an array of rows */
        $seats = collect(file(storage_path('11.txt'), FILE_IGNORE_NEW_LINES))->map(fn($row) => str_split($row))->toArray();

        do {
            /* get the new seat assignments */
            $new_seats = $this->run_through_rule($seats);

            /* see if they're the same, if so, we're done! */
            if (collect($seats)->flatten()->implode('') === collect($new_seats)->flatten()->implode('')) {
                break;
            }

            /* and try again */
            $seats = $new_seats;
        } while (true);

        $this->info(substr_count(collect($seats)->flatten()->implode(''), '#'));
    }

    public function run_through_rule($seats)
    {
        $rows = count($seats);
        $columns = count($seats[0]);

        $new_seats = $seats;

        for($row=0; $row<$rows; $row++) {
            for($column=0; $column<$columns; $column++) {

                if ($seats[$row][$column] === 'L' and $this->adjacent($seats, $row, $column, '#') === 0) {
                    $new_seats[$row][$column] = '#';
                }

                if ($seats[$row][$column] === '#' and $this->adjacent($seats, $row, $column, '#') >= 4) {
                    $new_seats[$row][$column] = 'L';
                }
            }
        }

        return $new_seats;

    }

    /**
     * Count the number of adjacent seats of a specific type
     *
     * @param $seats
     * @param $row
     * @param $column
     * @param $type
     * @return int
     */
    public function adjacent($seats, $row, $column, $type): int
    {
        $dir = [
            [-1,-1], [-1,0], [-1,1], [0,-1], [0,1], [1,-1], [1,0], [1,1]
        ];

        $count = 0;

        foreach($dir as $d) {
            if (isset($seats[$row+$d[0]][$column+$d[1]])
                and $seats[$row+$d[0]][$column+$d[1]] === $type) $count++;
        }

        return $count;
    }

    public function print($seats)
    {
        for($i=0; $i<count($seats); $i++) {
            for($j=0; $j<count($seats[0]); $j++) {
                print_r("{$seats[$i][$j]}");
            }
            print_r("\n");
        }
        print_r("\n");
    }
}
