<?php

namespace App\Http\Controllers;
use Response;
use Illuminate\Http\Request;
use App\Game;
use App\Score;

class GameTestController extends Controller
{
    public function index() {
        $games_list = Game::with('scores:game_id,player,value')->select('id','title','startAt')->get()->toArray();
        return Response::json($games_list,200);
    }

    public function store(Request $request) {
        $new_game_id = Game::create($request->all())->id;
        $game = Game::with('scores:game_id,player,value')->select('id','title','startAt')->find($new_game_id);
        return Response::json($game,201);
    }

    public function update(Request $request, $id) {
        $data = $request->all();
        foreach($data as &$d) {
            $d['game_id'] = $id;
        }
        unset($d);
        Score::insert($data);
        $game = Game::with('scores:game_id,player,value')->select('id','title','startAt')->findOrFail($id);
        return Response::json($game,200);
    }
}
