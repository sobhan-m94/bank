<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DepositNotification extends Notification
{
    use Queueable;

    protected $transaction;

    /**
     * Create a new notification instance.
     */
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): string
    {
        return SMSChannel::class;
    }

    public function toSms(object $notifiable)
    {
        return view('transaction.deposit', ['transaction' => $this->transaction])->render();
    }
}
