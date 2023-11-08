<?php

namespace App\Entity\Hive;

use App\Interface\Lifespan;
use App\Traits\HasLifespan;

abstract class Bee implements Lifespan
{
    use HasLifespan;

    private const MISS_CHANCE = 0.5; // 50% chance to miss

    private int $stingDamage;
    private int $hitDamage;
    private string $name;

    public function __construct(string $name, int $life, int $stingDamage, int $hitDamage)
    {
        $this->name = $name;
        $this->life = $life;
        $this->stingDamage = $stingDamage;
        $this->hitDamage = $hitDamage;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isQueen(): bool
    {
        return ($this instanceof QueenBee);
    }

    public function takeHit(): void
    {
        self::processDamage($this->hitDamage);
    }

    public function getHitDamage(): int
    {
        return $this->hitDamage;
    }

    public function getPlayerDamageAtStung(): int
    {
        return $this->stingDamage;
    }
}