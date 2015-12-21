<?php

namespace App\Listeners;

use App\Events\GameStarted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateChannelWhenGameStated
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
     * @param  GameStarted  $event
     * @return void
     */
    public function handle(GameStarted $event)
    {
        return '';
    }
}
