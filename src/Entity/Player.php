<?php

namespace App\Entity;

use App\Interface\Lifespan;
use App\Interface\Team;
use App\Traits\HasLifespan;

class Player implements Lifespan
{
    use HasLifespan;

    private const MISS_CHANCE = 0.1; // 10% chance to miss

    public function __construct()
    {
        $this->life = 100;
    }

    public function attemptHit(Team $team): bool
    {
        if (rand(0, 100) / 100 > self::MISS_CHANCE) {
            $team->hitRandomMember();

            return true;
        } else {
            // Output a message indicating a miss
            echo "Miss! You just missed the hive, better luck next time!\n";
        }

        return false;
    }
}