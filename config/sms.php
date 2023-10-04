<?php
 
use App\Components\SMS\Providers\Kavenegar;
use App\Components\SMS\Providers\Ghasedak;

return [
    'providers' => [
        'kavenegar' => Kavenegar::class,
        'ghasedak' => Ghasedak::class,
    ]
];
