<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class VpsService
{
    public function generateName()
    {
        return Str::random(8);
    }

    public function getVps()
    {
       // TODO: Закончить получение списка серверов

        $client = new Client();

        $response = $client->request('GET', 'https://example.com/api/posts', [
            'headers' => [
                'Authorization' => 'Bearer your_token_here',
                'Accept' => 'application/json',
            ]
        ]);

        $data = json_decode($response->getBody(), true);
    }
}
