<?php
namespace App\MatchMaker\Player;

interface PlayerInterface
{
    public function getName(): string;
    public function getRatio(): float;
    public function updateRatioAgainst(AbstractPlayer $player, int $result): void;
}
