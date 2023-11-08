<?php

namespace App\Interface;

use App\Entity\Player;

interface Team
{
    public function hitRandomMember(): void;
    public function isTeamAlive(): bool;
    public function getMembers(): array;
    public function attemptSting(Player $player): bool;
}