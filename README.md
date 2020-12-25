These are the solutions for Advent Of Code 2020, using PHP7.4. As I'm most familiar with Laravel, I used Laravel Zero.

If you want to check the code, run ```composer install``` to install all dependencies.

To see a solution run:

```./advent 1a```


Some notes about each solution.

1. Easy
   
2. Easy

3. Easy. To allow for wrapping of the line of trees, just use the modulo (%) of the line length (31).

4. Pretty easy using collections. You could make it more compact but separating each filter makes it more readable imo.

5a. It took me a while to realise that the boarding pass codes are their own seat/column value in binary! Just B/F swapped with 0/1. 
    I figured I'd solve it using bit shifting, but then I noticed I was basically XOR-ing the original value with 127, which gives you the original value.
    This makes the solution really simple.

5b. Now that we know the F/B code is basically a binary representation, you can see it's a 10 digit binary, or any numbers between 0 and 1023.
    So all seats are 0..1023, and we're looking the one not on the list, and no free seats next to you. 


8a. I opted to create a Computer class and a State class. The instruction set is passed as state and then executed by the computer.
8b. I kept a pointer stack in state, and then rewound the state, changing a jmp=>nop or nop=>jmp until it did not "crash". This is much faster than brute forcing.
