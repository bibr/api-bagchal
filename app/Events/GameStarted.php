<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GameStarted extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $tiger;
    public $goat;
    public $gameStat;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($tiger, $goat, $gameStat)
    {
        $this->tiger = $tiger;
        $this->goat = $goat;
        $this->gameStat = $gameStat;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [$this->tiger.'-'.$this->goat];
    }
}
