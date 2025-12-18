<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class PayDunyaController extends Controller
{
    /**
     * URL API PayDunya (Sandbox par défaut)
     */
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('PAYDUNYA_API_URL', 'https://app.paydunya.com/api/v1');
    }

    /**
     * =================================================
     * 1) CRÉATION DE LA FACTURE PAYDUNYA (CHECKOUT)
     * =================================================
     */
    public function createInvoice(Request $request)
    {
        $user = $request->user();

        // Dernière commande en attente
        $order = Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$order) {
            return response()->json([
                'message' => 'Aucune commande en attente de paiement.'
            ], 404);
        }

        $transactionId = uniqid('TXN_');

        $payload = [
            "invoice" => [
                "total_amount" => (float) $order->total_amount,
                "description"  => "Paiement de la commande " . $order->reference_number,
                "items" => [
                    [
                        "name" => "Commande Electro V2",
                        "quantity" => 1,
                        "unit_price" => (float) $order->total_amount,
                        "total_price" => (float) $order->total_amount
                    ]
                ]
            ],
            "store" => [
                "name"  => "Electro V2",
                "phone" => "+22500000000"
            ],
            "actions" => [
                "cancel_url"   => url('/api/paydunya/fail'),
                "return_url"   => url('/api/paydunya/success'),
                "callback_url" => url('/api/paydunya/ipn')
            ],
            "custom_data" => [
                "order_id"       => $order->id,
                "transaction_id" => $transactionId
            ]
        ];

        Log::info('PayDunya | Création facture', $payload);

        $response = Http::withHeaders([
            'PAYDUNYA-MASTER-KEY'  => env('PAYDUNYA_MASTER_KEY'),
            'PAYDUNYA-PUBLIC-KEY'  => env('PAYDUNYA_PUBLIC_KEY'),
            'PAYDUNYA-PRIVATE-KEY' => env('PAYDUNYA_PRIVATE_KEY'),
            'PAYDUNYA-TOKEN'       => env('PAYDUNYA_TOKEN'),
            'Content-Type'         => 'application/json'
        ])->post($this->baseUrl . '/checkout-invoice/create', $payload);

        if ($response->failed()) {
            Log::error('PayDunya | Erreur API', ['body' => $response->body()]);

            return response()->json([
                'message' => 'Erreur lors de la création de la facture PayDunya'
            ], 500);
        }

        $data = $response->json();

        if (!isset($data['response_code']) || $data['response_code'] !== '00') {
            Log::error('PayDunya | Réponse invalide', $data);

            return response()->json([
                'message' => 'Erreur PayDunya',
                'error'   => $data
            ], 500);
        }

        return response()->json([
            'checkout_url'  => $data['response_text'],
            'invoice_token' => $data['invoice_token']
        ]);
    }

    /**
     * =========================================
     * 2) IPN — CONFIRMATION SERVEUR PAYDUNYA
     * =========================================
     */
    public function ipn(Request $request)
    {
        Log::info('PayDunya | IPN reçu', $request->all());

        $invoiceToken = $request->input('invoice_token');

        if (!$invoiceToken) {
            return response('invoice_token manquant', 400);
        }

        $verify = Http::withHeaders([
            'PAYDUNYA-MASTER-KEY'  => env('PAYDUNYA_MASTER_KEY'),
            'PAYDUNYA-PUBLIC-KEY'  => env('PAYDUNYA_PUBLIC_KEY'),
            'PAYDUNYA-PRIVATE-KEY' => env('PAYDUNYA_PRIVATE_KEY'),
            'PAYDUNYA-TOKEN'       => env('PAYDUNYA_TOKEN'),
        ])->get($this->baseUrl . '/checkout-invoice/confirm/' . $invoiceToken);

        $data = $verify->json();

        if (!isset($data['response_code'])) {
            Log::error('PayDunya | Réponse IPN invalide', $data);
            return response('Réponse invalide PayDunya', 400);
        }

        $orderId = $data['custom_data']['order_id'] ?? null;
        $transactionId = $data['custom_data']['transaction_id'] ?? null;

        if (!$orderId) {
            return response('order_id introuvable', 400);
        }

        $order = Order::find($orderId);

        if (!$order) {
            return response('Commande introuvable', 404);
        }

        // Protection double IPN
        if ($order->status === 'paid') {
            return response('Déjà traité', 200);
        }

        if ($data['response_code'] === '00') {

            $order->update([
                'status' => 'paid'
            ]);

            Payment::create([
                'order_id'       => $order->id,
                'transaction_id' => $transactionId,
                'amount'         => $order->total_amount,
                'currency'       => 'XOF',
                'payment_method' => $data['payment_method'] ?? 'paydunya',
                'status'         => 'succeeded',
                'meta'           => json_encode($data)
            ]);

            return response('SUCCESS', 200);
        }

        return response('FAILED', 400);
    }

    /**
     * ===========================
     * 3) RETOUR UTILISATEUR OK
     * ===========================
     */
    public function success()
    {
        return response()->json([
            'message' => 'Paiement PayDunya effectué avec succès 🎉'
        ]);
    }

    /**
     * ===========================
     * 4) RETOUR UTILISATEUR KO
     * ===========================
     */
    public function fail()
    {
        return response()->json([
            'message' => 'Paiement PayDunya annulé ❌'
        ]);
    }
}
