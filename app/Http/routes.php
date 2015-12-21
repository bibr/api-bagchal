<?php
use Illuminate\Http\Request;
use Vinkla\Pusher\PusherManager;

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('game/start', ['middleware' => 'allowOrigin','as' => 'home', 'uses' => 'GameController@start']);

//Route::get('game/start', ['as' => 'home', 'uses' => 'AuthPusherController@startGame']);

Route::get('game/connect', ['uses' => 'GameController@index']);



Route::get('game/check', [ 'middleware' => 'allowOrigin',
    'middleware' => 'allowOrigin',
    'uses' => 'GameController@checkGame'
]);


Route::get('pusher/auth',  [
    'as' => 'pusher', 'uses' => 'AuthPusherController@index'
]);

Route::get('game/challenged', [ 'middleware' => 'allowOrigin',
    'as' => 'challenge', 'uses' => 'GameController@challenge'
]);

Route::get('game/move', [ 'middleware' => 'allowOrigin',
    'as' => 'move', 'uses' => 'GameController@move'
]);

