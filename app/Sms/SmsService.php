<?php


namespace App\Sms;


interface SmsService
{
    public function send($user , $message);
}
