<?php
namespace App\Notifications;

use App\Facades\SMS;
use Illuminate\Notifications\Notification;
 
class SMSChannel
{
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        
        $message = $notification->toSms($notifiable);
        SMS::send($notifiable->mobile, $message);
    }
}