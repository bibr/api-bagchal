<?php

namespace App\Listeners;

use App\Events\PlayerChallenged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecordPlayerResponse
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PlayerChallenged  $event
     * @return void
     */
    public function handle(PlayerChallenged $event)
    {
        //
    }
}
