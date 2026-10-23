<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HsmsService
{
    public function send($phone, $message)
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer '.env('HSMS_TOKEN'),
        ])->asForm()->post('https://www.hsms.ci/api/envoi-sms/', [
            'clientid' => env('HSMS_CLIENT_ID'),
            'clientsecret' => env('HSMS_CLIENT_SECRET'),
            'telephone' => $phone,
            'message' => $message,
        ]);
    }
}