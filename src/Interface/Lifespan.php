<?php

namespace App\Interface;

interface Lifespan
{
    public function getLife(): int;
    public function processDamage(int $damage): void;
    public function isAlive(): bool;
}