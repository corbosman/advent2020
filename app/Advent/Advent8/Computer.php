<?php

namespace App\Advent\Advent8;

use App\Advent\Advent8\State;

class Computer
{
    private State $memory;

    function __construct(State $state)
    {
        $this->memory = $state;
    }

    public function run()
    {
        while (true) {
            /* we don't have any more instructions left */
            if (!$this->memory->instruction()) {
                break;
            }

            /* we are trying to execute an instruction we've already seen */
            if ($this->memory->stack->contains($this->memory->pointer)) {
                $this->memory->halt();
                return $this->memory;
            }

            /* execute the instruction */
            [$operation, $parameter] = explode(' ', $this->memory->instruction());
            $this->{$operation}((int)$parameter);
        }

        return $this->memory;
    }

    private function nop($parameter)
    {
        $this->save();
        $this->memory->pointer++;
    }

    private function jmp($parameter)
    {
        $this->save();
        $this->memory->pointer += (int)$parameter;
    }

    private function acc($parameter)
    {
        $this->save();
        $this->memory->pointer++;
        $this->memory->accumulator += $parameter;
    }

    private function save() : void
    {
        $this->memory->stack->push($this->memory->pointer);
    }
}
