<?php

namespace App\Components\SMS\Providers;

use App\Components\SMS\Contract\SMSInterface;
use App\Components\SMS\Providers\AbstractSMS;

class Kavenegar extends AbstractSMS implements SMSInterface
{
    public function __construct()
    {
        $this->key = env('KAVENEGAR_API_KEY');
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
