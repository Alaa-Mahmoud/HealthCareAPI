<?php


namespace App\Sms;


use Illuminate\Support\Facades\Log;

class NexemoService implements SmsService
{

    public function send($user , $message)
    {
        Log::info($message);
    }
}
