<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Collection;
use LaravelZero\Framework\Commands\Command;

class Advent14b extends Command
{
    protected $signature = '14b';
    protected $description = 'Advent 14b';

    public function handle()
    {
        $input = file(storage_path('14_test.txt'), FILE_IGNORE_NEW_LINES);
        $mem = [];
        $mask = 0;

        foreach($input as $i) {
            if (preg_match('/^mask = (.*)$/', $i, $matches)) {
                $mask = $matches[1];
            } else {
                preg_match('/^mem\[(\d+)] = (.*)$/', $i, $matches);
                $address = (int)$matches[1];
                $value = (int)$matches[2];

                /* first apply the bitmask */
                $address = $this->apply_bitmask($address, $mask);

                /* the floats can only affect their own value, so mask out any existing 0/1 with a Y */
                $new_mask = str_replace(['1', '0'], ['Y', 'Y', ], $mask);

                /* now for each float, basically do what we did in 14a */
                foreach($this->floats($new_mask) as $float) {
                    $result = ($address & $this->and_mask($float)) | $this->or_mask($float);
                    $mem[$result] = $value;
                }
            }
        }

        $this->info(collect($mem)->sum());
    }

    /**
     * First apply the bitmask. These are the bits that are not floating and follow an OR rule.
     * Just replace the X with a 0, so the original value remains intact on those spots.
     *
     * @param $address
     * @param $mask
     * @return int
     */
    private function apply_bitmask($address, $mask) : int
    {
        $mask = bindec(str_replace('X', '0', $mask));
        return $address | $mask;
    }

    /**
     * recursively return all possible floated masks
     *
     * @param $mask
     * @return Collection
     */
    public function floats($mask)  : Collection
    {
        $floats = collect();
        if (($pos = strpos($mask, 'X')) !== false) {
            $floats = $floats->merge($this->floats(substr_replace($mask, '0', $pos, 1)))
                             ->merge($this->floats(substr_replace($mask, '1', $pos, 1)));
        } else {
            return $floats->push($mask);
        }
        return $floats;
    }

    private function and_mask($mask)
    {
        return bindec(str_replace(['1', 'Y'], ['0', '1'], $mask));
    }

    private function or_mask($mask)
    {
        return bindec(str_replace('Y', '0', $mask));
    }

}
