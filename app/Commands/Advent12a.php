<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Advent12a extends Command
{
    protected $signature = '12a';
    protected $description = 'Advent 12a';

    public function handle()
    {
        $input = collect(file(storage_path('12.txt'), FILE_IGNORE_NEW_LINES));

        $location = $input->reduce(function($location, $move) {
            $direction = $move[0];
            $distance = (int) substr($move, 1);

            switch ($direction) {
                case 'N':
                    $location['position'] = $this->north($location['position'], $distance);
                    break;
                case 'S':
                    $location['position'] = $this->south($location['position'], $distance);
                    break;
                case 'E':
                    $location['position'] = $this->east($location['position'], $distance);
                    break;
                case 'W':
                    $location['position'] = $this->west($location['position'], $distance);
                    break;
                case 'L':
                    $location['direction'] = $this->left($location['direction'], $distance);
                    break;
                case 'R':
                    $location['direction'] = $this->right($location['direction'], $distance);
                    break;
                case 'F':
                    $location['position'] = $this->forward($location['position'], $location['direction'], $distance);
                    break;
            }

            return $location;
        }, ['position' => [0,0], 'direction' => 0]);

        $this->info(abs($location['position'][0]) + abs($location['position'][1]));
    }

    public function north($position, $distance) : array
    {
        return [$position[0], $position[1] + $distance];
    }

    public function south($position, $distance) : array
    {
        return [$position[0], $position[1] - $distance];
    }

    public function east($position, $distance) : array
    {
        return [$position[0] + $distance, $position[1]];
    }

    public function west($position, $distance) : array
    {
        return [$position[0] - $distance, $position[1]];
    }

    public function left($direction, $degrees) : int
    {
        return ($direction + $degrees) % 360;
    }

    public function right($direction, $degrees) : int
    {
        return ($direction - $degrees + 360) % 360;
    }

    public function forward($direction, $degrees, $distance)
    {
        if ($degrees == 0) return $this->east($direction, $distance);
        if ($degrees == 90) return $this->north($direction, $distance);
        if ($degrees == 180) return $this->west($direction, $distance);
        if ($degrees == 270) return $this->south($direction, $distance);
    }
}
