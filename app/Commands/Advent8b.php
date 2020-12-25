<?php

namespace App\Commands;

use App\Advent\Advent8\Computer;
use App\Advent\Advent8\State;
use LaravelZero\Framework\Commands\Command;

class Advent8b extends Command
{
    protected $signature = '8b';
    protected $description = 'Advent 8b';

    public function handle()
    {
        $instructions = file(storage_path('8.txt'), FILE_IGNORE_NEW_LINES);

        $state = (new Computer(new State($instructions, 0, 0)))->run();

        /* if we halted, try and fix our instructions by going back through the stack and fixing the instructions
         * until we end up with a set of instructions that do not cause our computer to crash.
         */
        if ($state->halted) {

            $stack = $state->stack->reverse();
            $stack->pop();

            foreach($stack as $s) {

                $new_instructions = $instructions;

                [$operation, $parameter] = explode(' ', $new_instructions[$s]);

                if ($operation === 'jmp') {
                    $new_instructions[$s] = 'nop ' . $parameter;
                } elseif ($operation === 'nop') {
                    $new_instructions[$s] = 'jmp ' . $parameter;
                } else {
                    continue;
                }

                $state = (new Computer(new State($new_instructions, 0, 0)))->run();

                if (!$state->halted) {
                    break;
                }
            }
        }

        $this->info($state->accumulator);
    }
}
