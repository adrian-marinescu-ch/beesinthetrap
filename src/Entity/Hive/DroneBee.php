<?php

namespace App\Entity\Hive;

use App\Traits\HasLifespan;

class DroneBee extends Bee
{
    use HasLifespan;

    public function __construct()
    {
        parent::__construct(
            name: 'Drone Bee',
            life: 60,
            stingDamage: 1,
            hitDamage: 30
        );
    }
}