<?php

namespace App\Http\Controllers;

use App\Events\GameStarted;
use App\Events\PlayerChallenged;
use App\Events\PlayerMoved;
use App\Http\Classes\Game;
use Event;
use App\Events\PlayerJoinGame;
use App\GamePlay;
use App\Http\Classes\Initiate;
use App\Http\Classes\Moves;
use App\Http\Classes\Tiger;
use App\Http\Classes\Goat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;


class GameController extends Controller
{
    public function index()
    {

      //  Event::fire(new PlayerJoinGame());
      //  echo 'list the currently connected users here';
    }

    public function start(Request $request)
    {
        $tigerUserId = $request->input('tiger');
        $goatUserId = $request->input('goat');

        $initialTigerPosition = ['0,4', '0,0', '4,0', '4,4'];
        $initialGoatPosition = [];

        $allActivePosition =
            (new Initiate())
                ->insertAnimal($initialTigerPosition, new Tiger())
                ->insertAnimal($initialGoatPosition, new Goat())
                ->setNextMove(false, true);

        $moves = (new Moves($allActivePosition))->generateAllowedMoves();

        $data = GamePlay::firstOrNew(
            ['tiger_user_id' => $tigerUserId,
                'goat_user_id' => $goatUserId]
        );

        $data->tiger_user_id = $tigerUserId;
        $data->goat_user_id = $goatUserId;
        $data->tiger_position = json_encode($initialTigerPosition);
        $data->goat_position = json_encode($initialGoatPosition);
        $data->next_move = 'goat';
        $data->save();


        Event::fire(new GameStarted($tigerUserId, $goatUserId, array_merge($allActivePosition->getLayout(), $moves)));


//        return Response::json(array_merge($allActivePosition->getLayout(), $moves));
    }

    public function checkGame(Request $request)
    {
        $tigerId = $request->input('tiger');
        $goatId = $request->input('goat');

        $allActivePosition = Game::getActivePosition($tigerId, $goatId);

        $moves = Game::getMoves($allActivePosition);

        return Response::json(array_merge($allActivePosition->getLayout(), $moves));
    }

    public function challenge(Request $request)
    {
        $playerId = $request->input('playerId');
        $accepted = $request->input('accepted');
        $challengerId = $request->input('challengerId');
        $challengerType = $request->input('challengerType');
        $gameChannel = json_decode(Game::generateGameChannel($playerId, $challengerType,$challengerId));
       Event::fire(new PlayerChallenged($gameChannel->Tiger, $gameChannel->Goat,$gameChannel->Channel, $accepted, $playerId));
    }

    public function move(Request $request)
    {
        $tigerId = $request->input('tiger');
        $goatId = $request->input('goat');
        $player = $request->input('player');
        $move = json_decode($request->input('move'));

         if(Game::checkMove($tigerId, $goatId, $move, $player)){
             $move = (Game::movePlayer($tigerId, $goatId, $player, $move));
         }

        Event::fire(new PlayerMoved($tigerId, $goatId, $move, true));
    }
}
