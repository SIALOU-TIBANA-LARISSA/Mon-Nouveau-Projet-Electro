<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Models\Payment;

class PayDunyaController extends Controller
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('PAYDUNYA_API_URL', 'https://app.paydunya.com/sandbox-api/v1');
    }

    /**
     * ==============================
     * PAYDUNYA PAR (BROWSER PAYMENT)
     * ==============================
     * Cette méthode OUVRE PayDunya
     * dans le navigateur
     */
    public function createParPayment()
    {
        // 🔎 Récupérer la dernière commande en attente
        $order = Order::where('status', 'pending')->latest()->first();

        if (!$order) {
            return response()->json([
                'message' => 'Aucune commande en attente'
            ], 404);
        }

        // 🧾 Payload PayDunya PAR
        $payload = [
            "invoice" => [
                "total_amount" => (float) $order->total_amount,
                "description" => "Paiement commande #" . $order->id,
            ],
            "store" => [
                "name" => "Electro V2",
                "phone" => "+22500000000"
            ],
            "actions" => [
                "return_url" => url('/api/paydunya/success'),
                "cancel_url" => url('/api/paydunya/fail'),
                "callback_url" => url('/api/paydunya/ipn'),
            ],
            "custom_data" => [
                "order_id" => $order->id
            ]
        ];

        // 📡 Appel API PayDunya
        $response = Http::withHeaders([
            'PAYDUNYA-MASTER-KEY' => config('services.paydunya.master_key'),
            'PAYDUNYA-PRIVATE-KEY' => config('services.paydunya.private_key'),
            'PAYDUNYA-TOKEN' => config('services.paydunya.token'),
            'Content-Type' => 'application/json',
        ])->post(
                $this->baseUrl . '/checkout-invoice/create',
                $payload
            );

        $data = $response->json();

        // ❌ Erreur PayDunya
        if (!isset($data['response_code']) || $data['response_code'] !== '00') {
            return response()->json([
                'message' => 'Erreur PayDunya PAR',
                'error' => $data
            ], 500);
        }

        // ✅ REDIRECTION NAVIGATEUR PAYDUNYA
        return redirect()->away($data['response_text']);
    }

    /**
     * ==============================
     * IPN PAYDUNYA (CALLBACK SERVEUR)
     * ==============================
     */
    public function ipn(Request $request)
    {
        $invoice_token = $request->input('invoice_token');

        if (!$invoice_token) {
            return response('invoice_token manquant', 400);
        }

        $verify = Http::withHeaders([
            'PAYDUNYA-MASTER-KEY' => config('services.paydunya.master_key'),
            'PAYDUNYA-PRIVATE-KEY' => config('services.paydunya.private_key'),
            'PAYDUNYA-TOKEN' => config('services.paydunya.token'),
        ])->get($this->baseUrl . '/checkout-invoice/confirm/' . $invoice_token);

        $data = $verify->json();

        if (!isset($data['response_code'])) {
            return response('Réponse invalide PayDunya', 400);
        }

        $order_id = $data['custom_data']['order_id'] ?? null;

        if (!$order_id) {
            return response('order_id manquant', 400);
        }

        $order = Order::find($order_id);

        if (!$order) {
            return response('Commande introuvable', 404);
        }

        if ($data['response_code'] === '00') {

            $order->update(['status' => 'paid']);

            Payment::create([
                'order_id' => $order->id,
                'transaction_id' => $data['transaction_id'] ?? null,
                'amount' => $order->total_amount,
                'currency' => 'XOF',
                'payment_method' => $data['payment_method'] ?? 'mobile_money',
                'status' => 'succeeded',
                'meta' => json_encode($data),
            ]);

            return response('SUCCESS', 200);
        }

        return response('FAILED', 400);
    }

    /**
     * ==============================
     * REDIRECTIONS NAVIGATEUR
     * ==============================
     */
    public function success()
    {
        return 'Paiement PayDunya réussi 🎉';
    }

    public function fail()
    {
        return 'Paiement PayDunya annulé ❌';
    }
}

