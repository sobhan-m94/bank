<?php

namespace App\Components\SMS\Providers;

namespace App\Components\SMS\Providers;

use App\Components\SMS\Contract\SMSInterface;
use App\Components\SMS\Providers\AbstractSMS;
use Illuminate\Support\Facades\Log;

class NullProvider extends AbstractSMS implements SMSInterface
{
    public function send($to, $message)
    {
        Log::error('خطا در ارسال پیامک', ['سرویس پیامک تنظیم نشده است.']);
        return false;
    }
}
