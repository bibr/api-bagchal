<?php
/**
 * Created by PhpStorm.
 * User: DrivenByLimo
 * Date: 22/09/2015
 * Time: 10:23 AM
 */

namespace App\Http\Classes;


use App\GamePlay;

class Game
{
    static $tigerId;
    static $goatId;
    static $channel;
    static $player;

    public function __construct()
    {

    }



    public static function generateGameChannel($playerId, $playerType, $opponentId)
    {
        switch ($playerType) {
            case 'Tiger':
                self::$tigerId = $playerId;
                self::$goatId = $opponentId;
                self::$channel = $playerId . '-' . $opponentId;
                break;
            case 'Goat':
                self::$tigerId = $opponentId;
                self::$goatId = $playerId;
                self::$channel = $opponentId . '-' . $playerId;
                break;
        }

        return json_encode(['Tiger' => self::$tigerId, 'Goat' => self::$goatId, 'Channel' => self::$channel]);
    }

    public static function movePlayer($tigerId, $goatId, $player, $move){
        $game = GamePlay::where('tiger_user_id', $tigerId)
            ->where('goat_user_id', $goatId)->first();

        $tigerPosition = json_decode($game['tiger_position'], true);
        $goatPosition = json_decode($game['game_position'], true);

        switch($player){
            case 'Goat':
                $goatPosition[] = $move->x.','.$move->y;
                $goat = false;
                $tiger = true;
                $nextMove = "tiger";
                break;
            case 'Tiger':
                $tigerPosition[] = $move->x.','.$move->y;
                $goat = true;
                $tiger = false;
                $nextMove = "goat";
                break;
        }


        $allActivePosition =
            (new Initiate ())
                ->insertAnimal($tigerPosition, new Tiger())
                ->insertAnimal($goatPosition, new Goat())
                ->setNextMove($tiger, $goat);

        $moves = (new Moves($allActivePosition))->generateAllowedMoves();

        $data = GamePlay::firstOrNew(
            ['tiger_user_id' => $tigerId,
                'goat_user_id' => $goatId]
        );

        $data->tiger_user_id = $tigerId;
        $data->goat_user_id = $goatId;
        $data->tiger_position = json_encode($tigerPosition);
        $data->goat_position = json_encode($goatPosition);
        $data->next_move = $nextMove;
        $data->save();

        return(array_merge($allActivePosition->getLayout(), $moves));

    }

    public static function getActivePosition($tigerId, $goatId){

        $game = GamePlay::where('tiger_user_id', $tigerId)
            ->where('goat_user_id', $goatId)->first();

        $tigerPosition = json_decode($game['tiger_position'], true);
        $goatPosition = json_decode($game['goat_position'], true);
        $nextMove = $game['next_move'];

        $goat = false;
        $tiger = false;
        $$nextMove = true;

        $allActivePosition =
            (new Initiate ())
                ->insertAnimal($tigerPosition, new Tiger())
                ->insertAnimal($goatPosition, new Goat())
                ->setNextMove($tiger, $goat);

        return $allActivePosition;

    }

    public static function getMoves($allActivePosition){
        $game = (new Moves($allActivePosition))->generateAllowedMoves();
        return $game;

    }

    public static function checkMove($tigerId, $goatId, $move, $player)
    {
        $return = false;
        $game = Game::getActivePosition($tigerId, $goatId);
        $moves = (new Moves($game))->generateAllowedMoves();

        $data = array_merge($game->getLayout(), $moves);
        if($data['nextMove'][$player]){
            switch ($player) {
                case 'Goat':
                    if($data['GoatData'] > 20){
                        foreach($data['PlaceGoat'] as $places){
                            if($places === ($move->x.','.$move->y)){
                                $return = true;
                                break;
                            }
                        }

                    }else{

                    }
                    break;
                case 'Tiger':

                    break;
            }
        }
        return $return;
    }

}