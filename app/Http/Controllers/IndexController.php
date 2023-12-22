<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\SteamGame;
use Illuminate\Support\Facades\Http;
use VineVax\SteamPHPApi\Models\Game;
use VineVax\SteamPHPApi\Responses\RecentlyPlayedGamesResponse;
use VineVax\SteamPHPApi\SteamClient;

class IndexController
{
    public function __construct(
        private SteamClient $steamClient
    ){}

    public function __invoke()
    {
        $data = cache()->remember('data', 60 * 60 * 8, function () {

            $recentlyPlayed = $this->recentlyPlayed();

            return [
                'recentlyPlayed' => $recentlyPlayed,
            ];
        });

        return view('index', $data);
    }

    private function recentlyPlayed()
    {
        $games = $this->steamClient->getRecentlyPlayedGames(
            config('steam.steam_id'),
        )->games;

        return array_map(function (Game $game) {
            $appDetails = $this->steamClient->getAppDetails($game->appId)->appDetails;

            return new SteamGame(
                game: $game,
                appDetails: $appDetails,
            );
        }, $games);
    }
}
