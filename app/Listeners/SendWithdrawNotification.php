<?php

namespace App\Listeners;

use App\Events\NewTransactionEvent;
use App\Notifications\WithdrawNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendWithdrawNotification implements ShouldQueue
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
        $event->transaction->sender->account->user->notify(new WithdrawNotification($event->transaction));
    }
}
