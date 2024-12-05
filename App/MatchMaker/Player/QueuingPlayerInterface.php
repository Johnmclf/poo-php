<?php
namespace App\MatchMaker\Player;

interface QueuingPlayerInterface extends PlayerInterface
{
    public function getRange(): int;
    public function upgradeRange(): void;
}
