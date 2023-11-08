<?php

namespace App\Traits;

trait HasLifespan
{
    protected int $life;

    public function getLife(): int
    {
        return $this->life;
    }

    public function isAlive(): bool
    {
        return $this->life > 0;
    }

    public function processDamage(int $damage): void
    {
        $this->life = max($this->life - $damage, 0);
    }
}