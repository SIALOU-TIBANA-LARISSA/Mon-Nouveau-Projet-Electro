<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;

class PayDunyaSoftpayController extends Controller
{
    public function pay(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'phone' => 'required|string',
        ]);

        $order = Order::findOrFail($request->order_id);

        $response = Http::withHeaders([
            'PAYDUNYA-MASTER-KEY' => config('services.paydunya.master_key'),
            'PAYDUNYA-PRIVATE-KEY' => config('services.paydunya.private_key'),
            'PAYDUNYA-TOKEN' => config('services.paydunya.token'),
            'Content-Type' => 'application/json',
        ])->post('https://app.paydunya.com/api/v1/softpay/pay', [
            'amount' => $order->total_amount,
            'phone_number' => $request->phone,
            'description' => 'Paiement commande #' . $order->id,
        ]);

        if ($response->failed()) {
            return response()->json([
                'message' => 'Paiement échoué',
                'error' => $response->json()
            ], 400);
        }

        return response()->json([
            'message' => 'Paiement SOFTPAY lancé',
            'data' => $response->json()
        ]);
    }
}
