<?php

namespace App\Services;

use App\Repositories\GameRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Models\Game;

class AdministrationService
{
    public function __construct(GameRepository $gameRepository)
        {
            $this->gameRepository = $gameRepository;
        }
    
    public function getGameById($id){
        $game = $this->gameRepository->getGameById($id);

        //Average Game Rating
        $gameRatings = [];
        foreach($game->gameUser as $ur)
        {
            $rating = $ur->pivot->game_rating;

            if ($rating !== null) {
                array_push($gameRatings, $ur->pivot->game_rating);
            }
        };
        if (array_sum($gameRatings)== 0) {
            $game->average_rating = "No reviews";
        }
        else {
            $game->average_rating = self::getFormattedRating($gameRatings);
        }

        return($game);
    }

    public function getGames($orderby = null, $direction = null, $limit= null)
    {   
        return ($this->gameRepository->getGames());
    }

    public function activateDeactivateGame ($id)
    {    
        $this->gameRepository->activateDeactivateGame($id);
    }

}
