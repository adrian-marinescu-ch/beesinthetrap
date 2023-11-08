<?php

namespace App\Entity;

use App\Entity\Hive as HiveEntities;
use App\Entity\Hive\Bee;
use App\Interface\Team;

class Hive implements Team
{
    private const MISS_CHANCE = 0.60; // 60% chance to miss

    private array $bees = [];

    public function __construct()
    {
        // Add 1 Queen Bee
        $this->bees[] = new HiveEntities\QueenBee();
        // Add 5 Worker Bees
        for ($i = 0; $i < 5; $i++) {
            $this->bees[] = new HiveEntities\WorkerBee();
        }
        // Add 25 Drone Bees
        for ($i = 0; $i < 25; $i++) {
            $this->bees[] = new HiveEntities\DroneBee();
        }
    }

    public function hitRandomMember(): void
    {
        // Filter out dead bees
        $livingBees = array_filter($this->bees, function ($bee) {
            return $bee->isAlive();
        });

        if (count($livingBees) === 0) {
            return; // No living bees to hit
        }

        // Select a random bee
        $randomBeeKey = array_rand($livingBees);
        /** @var Bee $randomBee */
        $randomBee = $livingBees[$randomBeeKey];
        $initialHitPoints = $randomBee->getLife();
        $randomBee->takeHit();
        $damageTaken = $initialHitPoints - $randomBee->getLife();
        if ($randomBee->isAlive()) {
            echo "Direct Hit! You took {$damageTaken} hit points from a " . $randomBee->getName() . "\n";
        } else {
            if (!$randomBee->isQueen()) {
                echo "Congrats! You exterminated one {$randomBee->getName()}! {$this->getAliveMembersCount()} bees more to win" . "\n";
            }
        }

        // Check if the Queen Bee has died and if so, kill all bees
        if (!$this->bees[0]->isAlive()) {
            $this->killAllBees();
        }
    }

    private function killAllBees(): void
    {
        /** @var Bee $bee */
        foreach ($this->bees as $bee) {
            if ($bee->isAlive()) {
                $bee->processDamage($bee->getLife());
            }
        }

        echo "The Queen Bee is dead! The hive is destroyed.\n";
    }

    public function isTeamAlive(): bool
    {
        // Check if there are any bees alive
        /** @var Bee $bee */
        foreach ($this->bees as $bee) {
            // The team is dead if the Queen Bee is dead or if there are no bees alive
            if ($bee->isQueen() && !$bee->isAlive()) {
                return false;
            }

            if ($bee->isAlive()) {
                return true;
            }
        }

        return false;
    }

    public function getMembers(): array
    {
        return $this->bees;
    }

    public function getAliveMembersCount(): int
    {
        return count(array_filter($this->bees, function (Bee $bee) {
            return $bee->isAlive();
        }));
    }

    public function attemptSting(Player $player): bool
    {
        $livingBees = array_filter($this->bees, function ($bee) {
            return $bee->isAlive();
        });

        if (count($livingBees) > 0) {
            $randomBeeKey = array_rand($livingBees);
            /** @var Bee $randomBee */
            $randomBee = $livingBees[$randomBeeKey];

            if (rand(0, 100) / 100 > self::MISS_CHANCE) {
                $player->processDamage($randomBee->getPlayerDamageAtStung());

                echo "Sting! You were stung by a " . $randomBee->getName() . "\n";

                return true;
            } else {
                echo "Buzz! That was close! The " . $randomBee->getName() . " just missed you!\n";
            }
        }

        return false;
    }
}