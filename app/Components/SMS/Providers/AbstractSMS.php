<?php

namespace App\Components\SMS\Providers;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class AbstractSMS
{
    protected $key;
    protected function request($url, $data)
    {
        try {
            $request = Http::baseUrl("https://api.kavenegar.com/v1/{$this->key}")->asForm()->post($url, $data);
            $body = json_decode($request->body(), true);
            if ($body['return']['status'] != 200) {
                throw new Exception($body['return']['message'] ?? 'unknown');
            }
            return true;
        } catch (\Exception $e) {
            Log::error('خطا در ارسال پیامک', [$e->getMessage(), $url, $data]);
            return false;
        }
    }
}
