<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PlayerChallenged extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $accepted;
    public $gameChannel;
    private $player;
    public $tiger;
    public $goat;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($tiger, $goat, $gameChannel, $accepted, $player)
    {
        $this->accepted = $accepted;
        $this->gameChannel = $gameChannel;
        $this->player = $player;
        $this->tiger = $tiger;
        $this->goat = $goat;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['presence-mychannel-'.$this->player];
    }
}
