<?php

use App\Command\Game;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class PlayGameCommandTest extends TestCase
{
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        $application = new Application();
        $application->add(new Game());

        $command = $application->find('game:play');
        $this->commandTester = new CommandTester($command);
    }

    public function testExecuteWithHitAndAutoCommand()
    {
        ob_start();
        $this->commandTester->setInputs(['hit', 'auto']);
        $this->commandTester->execute([]);
        ob_end_clean();

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Type "hit" to attack the hive or "auto" to run to the end:', $output);
        // Assert victory or game over message
        $this->assertMatchesRegularExpression('/(Victory!|Game Over!)/', $output);
    }

    public function testExecuteWithAutoCommand()
    {
        ob_start();
        $this->commandTester->setInputs(['auto']);
        $this->commandTester->execute([]);
        ob_end_clean();

        $output = $this->commandTester->getDisplay();
        // Assert victory or game over message
        $this->assertMatchesRegularExpression('/(Victory!|Game Over!)/', $output);
    }
}