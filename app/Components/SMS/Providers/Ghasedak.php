<?php

namespace App\Components\SMS\Providers;

use App\Components\SMS\Contract\SMSInterface;

class Ghasedak extends AbstractSMS implements SMSInterface
{
    public function __construct()
    {
        $this->key = env('GHASEDAK_API_KEY');
    }
    public function send($to, $message)
    {
        $data = [
            'receptor' => $to,
            'message' => $message,
        ];
        return $this->request(
            'sms/send.json',
            $data
        );
    }
}
