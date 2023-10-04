<?php
namespace App\Components\SMS\Contract;

interface SMSInterface{
    public function send($to,$message);
}