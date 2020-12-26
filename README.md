These are the solutions for Advent Of Code 2020, using PHP7.4. As I'm most familiar with Laravel, I used Laravel Zero.

If you want to check the code, run ```composer install``` to install all dependencies.

To see a solution run:

```./advent 1a```


Some notes about each solution.

1. Easy [link](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent1a.php)
   
2. Easy

3. Easy. To allow for wrapping of the line of trees, just use the modulo (%) of the line length (31).

4. Pretty easy using collections. You could make it more compact but separating each filter makes it more readable imo.

5a. It took me a while to realise that the boarding pass codes are their own seat/column value in binary! Just B/F swapped with 0/1. 
    I figured I'd solve it using bit shifting, but then I noticed I was basically XOR-ing the original value with 127, which gives you the original value.
    This makes the solution really simple.

5b. Now that we know the F/B code is basically a binary representation, you can see it's a 10 digit binary, or any numbers between 0 and 1023.
    So all seats are 0..1023, and we're looking the one not on the list, and no free seats next to you. 

6a. This kind of problem is really easy with Laravel Collections. We're looking for a count of all unique letters in an array.

6b. This is quite a bit harder. Lots of ways to solve it. I opted to count string sequences. 
    Assume it's a group of 3 people, then we're looking for sequences of 3 letters. Put all the letters
    in an array, sort them, then check for the sequence. 

7a. Recursive code doesn't grok well in my brain. There's probably a much better way.

7b. Once you have 7a, this is very similar. Just some minor tweaks.

8a. I opted to create a Computer class and a State class. The instruction set is passed as state and then executed by the computer.


8b. I kept a pointer stack in state, and then rewound the state, changing a jmp=>nop or nop=>jmp until it did not "crash". This is much faster than brute forcing.

9a. Just did a slight optimization by keeping a running cache of the additions of the previous 25 numbers. For fun I did it the brute force method as well and the cache method was 5x faster.

9b. Pretty easy once you have 9a. Only thing to realize is that you don't have to count above the invalid number. 


