<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PlayerMoved extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $valid;
    public $tiger;
    public $goat;
    public $gameStat;

    public function __construct($tiger, $goat, $gameStat, $valid)
    {
        $this->valid = $valid;
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
