<?php

namespace App\Listeners;

use App\Events\NewTransactionEvent;
use App\Notifications\DepositNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendDespositNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewTransactionEvent $event): void
    {
        $event->transaction->receiver->account->user->notify(new DepositNotification($event->transaction));
    }
}
