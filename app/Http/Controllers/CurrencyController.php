<?php

namespace App\Http\Controllers;


use App\Http\Requests\SubscribeRequest;
use App\Models\Subscriber;
use App\Services\CurrencyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CurrencyController extends Controller
{
    public function __construct(
        protected CurrencyService $currencyService
    )
    {}

    public function subscribe(SubscribeRequest $request): JsonResponse
    {
        $data = $request->validated();

        Subscriber::create($data);

        return response()->json([
            'message' => 'Successfully subscribed to the newsletter!',
        ]);
    }

    public function getCurrentCurrency(): JsonResponse
    {
        try {
            $data = $this->currencyService->getCurrentCurrency();
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }

        $output = $this->currencyService->generateOutput($data);

        return response()->json($output);
    }
}
