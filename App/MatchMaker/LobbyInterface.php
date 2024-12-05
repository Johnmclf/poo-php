<?php
namespace App\MatchMaker;

use App\MatchMaker\Player\Player;
use App\MatchMaker\Player\QueuingPlayer;

interface LobbyInterface
{
    public function findOponents(QueuingPlayer $player): array;
    public function addPlayer(Player $player): void;
    public function addPlayers(Player ...$players): void;
}
