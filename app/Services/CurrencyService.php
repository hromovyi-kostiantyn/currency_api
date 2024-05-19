<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class CurrencyService
{
    public function getCurrentCurrency()
    {
        $response = Http::get('https://api.privatbank.ua/p24api/pubinfo')
        ->onError(function () {
            // log error
        });

        if ($response->failed()) {
            throw new \Exception('Failed to get the currency, probably the bank API is down.');
        }

        return $response->json();
    }

    public function generateOutput(array $data)
    {
        return [
            'dollar buy' => $data[1]['buy'],
            'dollar sell' => $data[1]['sale'],
            'actual date' => Carbon::now()->toDateTimeString(),
        ];
    }
}
