<?php

namespace App\Entity\Hive;

use App\Traits\HasLifespan;

class WorkerBee extends Bee
{
    use HasLifespan;

    public function __construct()
    {
        parent::__construct(
            name: 'Worker Bee',
            life: 75,
            stingDamage: 5,
            hitDamage: 25
        );
    }
}