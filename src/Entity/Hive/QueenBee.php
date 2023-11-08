<?php

namespace App\Entity\Hive;

use App\Traits\HasLifespan;

class QueenBee extends Bee
{
    use HasLifespan;

    public function __construct()
    {
        parent::__construct(
            name: 'Queen Bee',
            life: 100,
            stingDamage: 10,
            hitDamage: 10
        );
    }
}