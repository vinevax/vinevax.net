<?php

namespace App\DataTransferObjects;

use VineVax\SteamPHPApi\Models\AppDetails;
use VineVax\SteamPHPApi\Models\Game;

readonly class SteamGame
{
    public function __construct(
        public Game $game,
        public AppDetails $appDetails,
    ) {}
}
