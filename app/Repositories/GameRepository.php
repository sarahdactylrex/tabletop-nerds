<?php

namespace App\Repositories;

use App\Models\Game;
use App\Models\User;
use App\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class GameRepository
{
    // in reality this class will utilize Eloquent models to query the DB

    public function getGames(): Collection
    {
        return Game::orderBy('title')->get();
    }

    public function searchGamesByTitle(Request $request)
    {
        $key = trim($request->get('search'));
        $findgames = DB::table('games')->where('title', 'like', "%{$key}%")->get();
        return view('search-results', ['key' => $key, 'games' => $findgames]);
    }

    public function getGameById($id)
    {
        return Game::find($id);
    }

    public function activateDeactivateGame($id){
        $game = Game::find($id);
        if($game->is_deleted == 0){
            DB::table('games')->where('id',$id)->update(['is_deleted'=>1]);
        }
        else{
            DB::table('games')->where('id',$id)->update(['is_deleted'=>0]);
        }
    }
}
