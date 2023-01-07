<?php

namespace App\Client;

use Illuminate\Support\Facades\Http;

class NotificationClient
{
    public function notify()
    {
        $response = Http::get('http://o4d9z.mocklab.io/notify');
        return $response->json('message');
    }
}
