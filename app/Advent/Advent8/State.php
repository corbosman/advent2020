<?php

namespace App\Advent\Advent8;

use Illuminate\Support\Collection;

class State
{
    public bool $halted = false;
    public int $pointer;
    public int $accumulator;
    public Collection $stack;
    public array $instructions;

    public function __construct($instructions, $pointer, $accumulator)
    {
        $this->instructions = $instructions;
        $this->pointer = $pointer;
        $this->accumulator = $accumulator;
        $this->stack = collect();
    }

    function instruction() {
        return $this->instructions[$this->pointer] ?? false;
    }

    function halt()
    {
        $this->halted = true;
    }
}
