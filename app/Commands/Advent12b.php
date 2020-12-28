<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent12b extends Command
{
    protected $signature = '12b';
    protected $description = 'Advent 12b';

    public function handle()
    {
        /* read input but convert 270 degree turns into 90 degree turns */
        $input = collect(file(storage_path('12.txt'), FILE_IGNORE_NEW_LINES))->map(function($line) {
            if ($line === 'R270') $line = 'L90';
            if ($line === 'L270') $line = 'R90';
            return $line;
        });

        $location = $input->reduce(function($location, $move) {
            $direction = $move[0];
            $distance = (int) substr($move, 1);

            switch ($direction) {
                case 'N':
                    $location['waypoint'] = $this->north($location['waypoint'], $distance);
                    break;
                case 'S':
                    $location['waypoint'] = $this->south($location['waypoint'], $distance);
                    break;
                case 'E':
                    $location['waypoint'] = $this->east($location['waypoint'], $distance);
                    break;
                case 'W':
                    $location['waypoint'] = $this->west($location['waypoint'], $distance);
                    break;
                case 'L':
                    $location['waypoint'] = $this->left($location['waypoint'], $distance);
                    break;
                case 'R':
                    $location['waypoint'] = $this->right($location['waypoint'], $distance);
                    break;
                case 'F':
                    $location['position'] = $this->forward($location['position'], $distance, $location['waypoint']);
                    break;
            }
            return $location;
        }, ['position' => [0,0], 'waypoint' => [10,1]]);

        $this->info(abs($location['position'][0]) + abs($location['position'][1]));
    }

    public function north($waypoint, $distance) : array
    {
        return [$waypoint[0], $waypoint[1] + $distance];
    }

    public function south($waypoint, $distance) : array
    {
        return [$waypoint[0], $waypoint[1] - $distance];
    }

    public function east($waypoint, $distance) : array
    {
        return [$waypoint[0] + $distance, $waypoint[1]];
    }

    public function west($waypoint, $distance) : array
    {
        return [$waypoint[0] - $distance, $waypoint[1]];
    }

    public function left($waypoint, $degrees) : array
    {
        if ($degrees === 90) return [-1*$waypoint[1], $waypoint[0]];
        if ($degrees === 180) return [-1*$waypoint[0], -1*$waypoint[1]];
    }

    public function right($waypoint, $degrees) : array
    {
        if ($degrees === 90) return [$waypoint[1], -1*$waypoint[0]];
        if ($degrees === 180) return [-1*$waypoint[0], -1*$waypoint[1]];
    }

    public function forward($position, $distance, $waypoint)
    {
        return [
            $position[0] + ($distance * $waypoint[0]),
            $position[1] + ($distance * $waypoint[1])
        ];
    }
}
