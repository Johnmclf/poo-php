<?php

declare(strict_types=1);

spl_autoload_register(static function ($fqcn): void {
    $path = sprintf('%s.php', str_replace(['App', '\\'], ['App', '/'], $fqcn));
    require_once $path;
});

use App\MatchMaker\Lobby;
use App\MatchMaker\Player\BlitzPlayer;

$greg = new BlitzPlayer('greg');
$jade = new BlitzPlayer('jade');

$lobby = new Lobby();
$lobby->addPlayers($greg, $jade);

var_dump($lobby->findOponents($lobby->queuingPlayers[0]));

exit(0);
