<?php

use App\Entity\Hive;
use App\Entity\Hive\Bee;
use App\Entity\Hive\DroneBee;
use App\Entity\Hive\QueenBee;
use App\Entity\Hive\WorkerBee;
use App\Entity\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testPlayerCreation()
    {
        $player = new Player();
        $this->assertInstanceOf(Player::class, $player);
    }

    public function testPlayerIsInitiallyAlive()
    {
        $player = new Player();
        $this->assertTrue($player->isAlive());
    }

    public function testPlayerHasInitialHp()
    {
        $player = new Player();
        $this->assertEquals(100, $player->getLife());
    }

    public function testPlayerTakesDamage()
    {
        $player = new Player();
        $player->processDamage(10);
        $this->assertEquals(90, $player->getLife());
    }

    public function testPlayerDiesWhenHpReachesZero()
    {
        $player = new Player();
        $player->processDamage(100);
        $this->assertFalse($player->isAlive());
    }

    public function testPlayerStungByQueen()
    {
        $beeTypesClasses = [QueenBee::class, WorkerBee::class, DroneBee::class];
        /** @var Bee $bee */
        $bee = new $beeTypesClasses[array_rand($beeTypesClasses)];
        $player = new Player();
        $player->processDamage($bee->getPlayerDamageAtStung());
        $this->assertEquals((100 - $bee->getPlayerDamageAtStung()), $player->getLife());
    }

    public function testPlayerHitTheQueen()
    {
        $queenBee = new QueenBee();
        $queenBee->takeHit();
        $this->assertEquals((100 - $queenBee->getHitDamage()), $queenBee->getLife());
    }

    /**
     * This is testing chances to miss the target
     * It might fail sometimes (I added 20% extra chances)
     * @return void
     */
    public function testPlayerChancesToMissAHit()
    {
        $chancesToMiss = 0.10; // 10% chances to miss
        $deltaPercentage = 1.2; // 20% extra chances
        $attemptsCount = 0;
        $failedAttemptsCount = 0;
        $attempts = 1000;

        ob_start();
        while($attemptsCount <= $attempts) {
            if (!(new Player())->attemptHit(new Hive())) {
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