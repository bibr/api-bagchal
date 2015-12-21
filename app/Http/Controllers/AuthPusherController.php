<?php
/**
 * Created by PhpStorm.
 * User: DrivenByLimo
 * Date: 27/08/2015
 * Time: 3:05 PM
 */

namespace App\Http\Controllers;


use App\Events\GameStarted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Vinkla\Pusher\PusherManager;

class AuthPusherController extends Controller
{
    private $pusher;
    private $allowedPlayer = ['Tiger', 'Goat'];

    function __construct(PusherManager $pusher)
    {
        $this->pusher = $pusher;
    }

    public function index(Request $request)
    {
        if(!in_array($request->input('playAs'), $this->allowedPlayer))
            abort(403, 'Unauthorized action.');

        $channelName = $request->input('channel_name');
        $socketId = $request->input('socket_id');
        $presence_data = ['player' => $request->input('playAs'), 'user' => str_replace('.','-',$socketId)];

        $userId =  str_random(15);

        $auth = $this->pusher->presence_auth($channelName, $socketId, $userId, $presence_data);

        $callback = str_replace('\\', '', $request->input('callback'));

        header('Content-Type: application/javascript');
        return ($callback . '(' . $auth . ');');
    }

    public function startGame()
    {
        $id1 = 'qwQN4v2QibHy9v1';
        $id2 = 'HJ449lHYzyeUFfz';
        Event::fire(new GameStarted($id1, $id2));

    }

}