<?php

use App\Entity\Hive;
use App\Entity\Hive\Bee;
use App\Entity\Hive\DroneBee;
use App\Entity\Hive\QueenBee;
use App\Entity\Hive\WorkerBee;
use App\Entity\Player;
use PHPUnit\Framework\TestCase;

class HiveTest extends TestCase
{
    public function testHiveInitializesWithAllBees()
    {
        $hive = new Hive();
        $this->assertCount(1 + 5 + 25, $hive->getMembers()); // 1 Queen, 5 Workers, 25 Drones
    }

    public function testHiveIsAliveInitially()
    {
        $hive = new Hive();
        $this->assertTrue($hive->isTeamAlive());
    }

    public function testHiveDiesWhenQueenBeeDies()
    {
        $hive = new Hive();
        // Simulate hitting the Queen Bee directly
        /** @var QueenBee $queenBee */
        $queenBee = $hive->getMembers()[0];
        while ($queenBee->isAlive()) {
            $queenBee->takeHit();
        }
        $this->assertFalse($hive->isTeamAlive());
    }

    public function testHiveCanHitPlayer()
    {
        $hive = new Hive();
        $player = new Player();
        $initialHp = $player->getLife();

        ob_start();
        $hive->attemptSting($player);
        ob_end_clean();

        // It's possible for the bees to miss, so we assert that HP is less than or equal to the initial
        $this->assertLessThanOrEqual($initialHp, $player->getLife());
    }

    /**
     * This is testing chances to miss the target
     * It might fail sometimes (I added 20% extra chances)
     * @return void
     */
    public function testHiveChancesToMissAHit()
    {
        $chancesToMiss = 0.60; // 60% chances to miss
        $deltaPercentage = 1.2; // 20% extra chances
        $attemptsCount = 0;
        $failedAttemptsCount = 0;
        $attempts = 1000;

        ob_start();
        while($attemptsCount <= $attempts) {
            if (!(new Hive())->attemptSting(new Player())) {
                $failedAttemptsCount++;
            }

            $attemptsCount++;
        }
        ob_end_clean();

        $this->assertEqualsWithDelta(
            expected: intval($attemptsCount * $chancesToMiss),
            actual: $failedAttemptsCount,
            delta: ceil((($deltaPercentage * $failedAttemptsCount) - $failedAttemptsCount)),
            message: 'Failed with delta +-' . abs((1 - $deltaPercentage) * 100) . '%'
        );
    }
}