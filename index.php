<?php

/*
 * This file is part of the OpenClassRoom PHP Object Course.
 *
 * (c) Grégoire Hébert <contact@gheb.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

class Lobby
{
    /** @var array<QueuingPlayer> */
    public array $queuingPlayers = [];

    public function findOponents(QueuingPlayer $player): array
    {
        $minLevel = round($player->getRatio() / 100);
        $maxLevel = $minLevel + $player->getRange();

        return array_filter($this->queuingPlayers, static function (QueuingPlayer $potentialOponent) use ($minLevel, $maxLevel, $player) {
            $playerLevel = round($potentialOponent->getRatio() / 100);

            return $player !== $potentialOponent && ($minLevel <= $playerLevel) && ($playerLevel <= $maxLevel);
        });
    }

    private function addPlayer(QueuingPlayer $player): void
    {
        $this->queuingPlayers[] = $player;
    }

    public function addPlayers(QueuingPlayer ...$players): void
    {
        foreach ($players as $player) {
            $this->addPlayer($player);
        }
    }
}

abstract class Player
{
    public function __construct(protected string $name, protected float $ratio = 400.0)
    {
    }

    private function getName(): string
    {
        return $this->name;
    }

    private function probabilityAgainst(self $player): float
    {
        return 1 / (1 + (10 ** (($player->getRatio() - $this->getRatio()) / 400)));
    }

    private function updateRatioAgainst(self $player, int $result): void
    {
        $this->ratio += 32 * ($result - $this->probabilityAgainst($player));
    }

    public function getRatio(): float
    {
        return $this->ratio;
    }
}

final class QueuingPlayer extends Player
{
    public int $range;
    public function __construct(protected string $name, protected float $ratio = 400.0, int $range = 0)
    {
        parent::__construct($name, $ratio);
        $this->range=$range;
    }

    public function getRange(): int
    {
        return $this->range;
    }
}

$greg = new QueuingPlayer('greg', 400,20);
$jade = new QueuingPlayer('jade', 476,1);

$lobby = new Lobby();
$lobby->addPlayers($greg, $jade);

var_dump($lobby->findOponents($lobby->queuingPlayers[0]));

exit(0);
