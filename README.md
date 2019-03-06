# Paper-Scissors-Rock

[Paper-Scissors-Rock][Paper-Scissors-Rock] Rock–paper–scissors (also known as scissors–rock–paper or other variants) 
is a hand game usually played between two people, in which each player simultaneously forms one 
of three shapes with an outstretched hand. 
These shapes are "rock" (a closed fist), "paper" (a flat hand), and "scissors" 
(a fist with the index finger and middle finger extended, forming a V). 
"Scissors" is identical to the two-fingered V sign (also indicating "victory" or "peace") 
except that it is pointed horizontally instead of being held upright in the air. 

### Installation

Paper-Scissors-Rock requires [PHP](https://php.net/) v7.1+ to run.

Install the dependencies and devDependencies and start the server.

```sh
$ git clone https://github.com/mykyta-b/paper-scissors-rock -d paper-scissors-rock
$ cd ./paper-scissors-rock
$ make install
```
### Configuration

```sh
config/game.ini
```
Here you can configure as follows:

* player name, type (could be computer for auto turn) and strategy for computer could be "paper" or "random"

### Play

```
$ make play
```

### Clear stat

```
$  rm /tmp/paper-scissors-rock.game.stat
```

Use your keyboard to input the cell number which you want to capture.
Cells have number for vertical lines and letters for horizontal lines.

### Tech

This version of Paper-Scissors-Rock was written with the respect of KISS and YAGNI principles.
The game consist Layers as follows:

* [Core] - Consists classes which deal with configs, game states and DTO (Data Transfer Objects) and objects builder
* [Mechanics] - The brain of the game. Consists the implementation of the command 
for each game state including AutoPlayer Class which allows to play with the computer. 
GameStateAnalyzer class makes a decision about the state of game
whether game is won or there is a draw in the game
* [UI] The game user interface, reads data from your input on CLI
You can use lower or upper character.

The game used CLI for user input-output.


#### Core

* State here you can find the simplified implementation of the state machine.

#### Mechanics

* GameStateAnalyzer allows to analyze turns and find if the game state is won or draw
* Commands contains implementation
* Commands/Play/AutoPlayer allows to do turns automatically.

#### UI

* InputReader reads input from cli
* InputRequest requests some input from user
* Renderer creates formatted output

And of course Paper-Scissors-Rock itself is open source with a [public repository][mykyta-b-paper-scissors-rock]
 on GitHub.


### Todos

 - Improve error handling

License
----

MIT


**Free Software, Hell Yeah!**

[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does its job. There is no need to format nicely because it shouldn't be seen. Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)


   [mykyta-b-paper-scissors-rock]: <https://github.com/mykyta-b/paper-scissors-rock>
   [Paper-Scissors-Rock]: <https://en.wikipedia.org/wiki/Rock%E2%80%93paper%E2%80%93scissors>
