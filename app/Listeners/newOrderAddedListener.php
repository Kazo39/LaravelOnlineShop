<?php

namespace App\Listeners;

use App\Events\newOrderAddedEvent;
use App\Notifications\OrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class newOrderAddedListener
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
     * @param  \App\Events\newOrderAddedEvent  $event
     * @return void
     */
    public function handle(newOrderAddedEvent $event)
    {
        $event->user->notify(new OrderNotification($event->user, $event->order, $event->total_price));
    }
}
