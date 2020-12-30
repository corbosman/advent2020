These are the solutions for Advent Of Code 2020, using PHP7.4. As I'm most familiar with Laravel, I used Laravel Zero.

If you want to check the code, run ```composer install``` to install all dependencies.

To see a solution run:

```./advent 1a```


Some notes about each solution.

1a. Easy [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent1a.php)

1b. Easy [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent1b.php)

2a. Easy [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent2a.php)

2b. Easy [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent2b.php)

3a. Easy. To allow for wrapping of the line of trees, just use the modulo (%) of the line length (31). [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent3a.php)

3b. Easy. Just loop 3a with multiple slopes. [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent3b.php)

4a. Pretty easy using collections. You could make it more compact but separating each filter makes it more readable imo. [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent4a.php)

4b. Similar to 4a, just with some extra filters for validation. [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent4b.php)

5a. It took me a while to realise that the boarding pass codes are their own seat/column value in binary! Just B/F swapped with 0/1. 
    I figured I'd solve it using bit shifting, but then I noticed I was basically XOR-ing the original value with 127, which gives you the original value.
    This makes the solution really simple. [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent5a.php)

5b. Now that we know the F/B code is basically a binary representation, you can see it's a 10 digit binary, or any numbers between 0 and 1023.
    So all seats are 0..1023, and we're looking the one not on the list, and no free seats next to you. [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent5b.php)

6a. This kind of problem is really easy with Laravel Collections. We're looking for a count of all unique letters in an array. [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent6a.php)

6b. This is quite a bit harder. Lots of ways to solve it. I opted to count string sequences. 
    Assume it's a group of 3 people, then we're looking for sequences of 3 letters. Put all the letters
    in an array, sort them, then check for the sequence.  [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent6b.php)

7a. Recursive code doesn't grok well in my brain. There's probably a much better way. [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent7a.php)

7b. Once you have 7a, this is very similar. Just some minor tweaks. [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent7b.php)

8a. I opted to create a Computer class and a State class. The instruction set is passed as state and then executed by the computer. [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent8a.php)

8b. I kept a pointer stack in state, and then rewound the state, changing a jmp=>nop or nop=>jmp until it did not "crash". This is much faster than brute forcing. [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent8b.php)

9a. Just did a slight optimization by keeping a running cache of the additions of the previous 25 numbers. For fun I did it the brute force method as well and the cache method was 5x faster. [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent9a.php)

9b. Pretty easy once you have 9a. Only thing to realize is that you don't have to count above the invalid number. [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent9b.php)

10a. Relatively straightforward. [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent10a.php)

10b. This was the first puzzle that stumped me. It took me several hours. I was getting the right solutions for the test data, but the final data took forever. 
  The puzzle mentioned there is a trick. So I ended up drawing one of the graphs, and then I realized that once you know the connections from a specific adapter, you don't have to calculate it again. Totally obvious once you see it. Doh.
  So the trick is to keep a global cache of all connections from a specific adapter, so you can just take it from the cache instead of recalculating it over and over. [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent10b.php)
  
11a. Not that difficult, just a lot of array manipulations. Maybe there's a smarter way. Reminds me of Game of Life. [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent11a.php)

11b. More of the same, with an extra loop for checking further into a direction. And even more array manipulations." [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent11b.php)

12a. More arrays. I keep the heading in degrees, seemed easiest to me. [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent12a.php)

12b. Similar to 12a, not that hard. Just have to know the way to rotate x,y coordinates around a central point. I also changed 270 to 90 so the rotation is easier. [code](https://github.com/corbosman/advent2020/blob/main/app/Commands/Advent12b.php)

13a. Easy. 

13b. Not easy at all. I started out trying the brute-force method. The examples solved just fine but the puzzle was too large for brute force. I knew there was a theorem about modulos but I just couldn't remember it.
     So I had a look at the reddit chat and saw "Chinese Remainder Theorem". Aha! And that solved it quickly, well.. after re-discovering that theorem. 

14a. Much more to my liking. Simple bitmasks. Wrote it and executed correctly with the right answer in 1 go. 

14b. Bit more difficult. You really have to think about how to apply all the masking. 
