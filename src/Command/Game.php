<?php

namespace App\Command;

use App\Entity\Hive;
use App\Entity\Hive\Bee;
use App\Entity\Player;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'game:play',
    description: 'Play Game',
    hidden: false,
)]
class Game extends Command
{
    private int $turnsCount = 0;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $player = new Player();
        $hive = new Hive();

        $output->writeln('<info>Welcome to Bees in the Trap Game!</info>');

        $helper = $this->getHelper('question');
        $question = new Question('Type "hit" to attack the hive or "auto" to run to the end: ');

        while ($player->isAlive() && $hive->isTeamAlive()) {
            $answer = $helper->ask($input, $output, $question);

            if ($answer === 'hit') {
                $this->turn($player, $hive, $output);
            } elseif ($answer === 'auto') {
                while ($player->isAlive() && $hive->isTeamAlive()) {
                    $this->turn($player, $hive, $output);
                }
                break;
            } else {
                $output->writeln('<comment>Invalid command. Type "hit" or "auto".</comment>');
            }
        }

        if (!$player->isAlive()) {
            $output->writeln("<error>Game Over! You were stung to death after {$this->turnsCount} stings.</error>");
        } else {
            $output->writeln("<info>Victory! It took {$this->turnsCount} hits to destroy the hive.</info>");
        }

        return Command::SUCCESS;
    }

    private function turn(Player &$player, Hive &$hive, OutputInterface $output): void
    {
        $player->attemptHit($hive);
        $hive->attemptSting($player);
        $this->turnsCount++;

        if ($player->isAlive()) {
            $output->writeln("<comment>Player HP: {$player->getLife()}</comment>");
        }

        /** @var Bee $bee */
        foreach ($hive->getMembers() as $bee) {
            if (!$bee->isAlive()) {
                continue;
            }

            $output->writeln("<comment>{$bee->getName()} HP: {$bee->getLife()}</comment>");
        }
    }
}