<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class SMS extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'sms';
    }
}
