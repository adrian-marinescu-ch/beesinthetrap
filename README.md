# 🐝 BeesInTheTrap

## Commands
1. Install dependencies - `composer install`
2. Run tests - `composer test`
3. Play game - `./beesinthetrap`

## Config
- If you want to alter chances to miss the target of either `Hive` or `Player` team, edit the `MISS_CHANCE` const
  - Make sure to alter Tests also

## Instructions

Write a simple game in PHP using the following rules. You should use modern  
PHP styles and design principles. You can use Symfony components (such as symfony/console) but you should avoid using a fully prebuilt framework. You should include tests.

## Rules

- The game must be run from the command line. (Setup and installation commands such as `composer install` are fine)
- The game should have an executable bash file called `beesinthetrap`
- The game should be turn by turn
- There is a `player`, and a hive of `bee`'s, each player starts with `100` HP.
- A player should type `hit` to have their turn awaiting input after each previous turn. Once a player has had their turn, the bees can take their turn. The bees are the computer against which players play.
- The game should show a message to the player after each turn, both computers and player turns, with the outcome of that turn. `e.g. Direct Hit! You took 12 hit points from a Drone bee` or `Sting! You just got stun by a drone bee` or `Miss! You just missed the hive, better luck next time!` or `Buzz! That was close! The Queen Bee just missed you!` ect…
- The game should be single player.
- The game should exit on game over, with a message informing the user of how many hits were needed to destroy the hive, or if they are dead, how many stings it took for the hive to kill them. As well as a summary of the game.
- The object of the game is to destroy a hive of bees before the bees sting you to death.
- The hive has three types of bee.
- The game is over when all bees are dead, or you are dead first.
- You are dead when your HP reaches 0.
- The player should sometimes be able to miss the hive entirely.
- The bees should sometimes be able to miss the player entirely.
- The bee a player hits should be picked at random, but should be statistically correct given the ratio of each bee type and miss chances.
- The bee that strings a player should be picked at random, but should be statistically correct given the ratio of each bee type and miss chances.
- You should include a way for the player to `auto spin` and let the game run through to an ending on their behalf.

### Queen Bee

- The Queen Bee has a lifespan of 100 Hit Points.
- When the Queen Bee is hit, 10 Hit Points are deducted from her lifespan.
- If/When the Queen Bee has run out of Hit Points, All remaining alive Bees automatically run out of hit points.
- When the Queen bee stings a player, the player loses 10 Hit Points.
- There is only 1 Queen Bee.

### Worker Bee

- Worker Bees have a lifespan of 75 Hit Points.
- When a Worker Bee is hit, 25 Hit Points are deducted from their lifespan.
- When a Worker Bee stings a player, the player loses 5 Hit Points.
- There are 5 Worker Bees.

### Drone Bee

- Drone Bees have a lifespan of 60 Hit Points.
- When a Drone Bee is hit, 30 Hit Points are deducted from his lifespan.
- When a Drone Bee stings a player, the player poses 1 Hit Point.
- There are 25 Drone Bees.