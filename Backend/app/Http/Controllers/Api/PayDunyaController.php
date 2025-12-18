<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Models\Payment;

class PayDunyaController extends Controller
{
    private $baseUrl;

    public function __construct()
    {
        // Sandbox
        $this->baseUrl = env('PAYDUNYA_API_URL', 'https://app.paydunya.com/api/v1');
    }

    /**
     * 1) CREER UNE FACTURE / CHECKOUT PAYDUNYA
     */
    public function createInvoice(Request $request)
    {
        \Log::info('MASTER KEY ENVOYÉE', [
    'master_key' => config('services.paydunya.master_key')
]);

        $user = $request->user();

        // Récupérer la dernière commande non payée
        $order = Order::where('user_id', $user->id)->where('status', 'pending')->latest()->first();

        if (!$order) {
            return response()->json(['message' => 'Aucune commande en attente de paiement.'], 404);
        }

        $transaction_id = uniqid('TXN_');

        // Données envoyées à PayDunya
        $payload = [
            "invoice" => [
                "total_amount" => (float) $order->total_amount,
                "description"  => "Paiement de la commande : " . $order->reference_number,
                "items" => []
            ],
            "store" => [
                "name" => "Electro V2",
                "phone" => "+22500000000"
            ],
            "actions" => [
                "cancel_url" => url('/paydunya/fail'),
                "return_url" => url('/paydunya/success'),
                "callback_url" => url('/paydunya/ipn')
            ],
            "custom_data" => [
                "order_id" => $order->id,
                "transaction_id" => $transaction_id
            ]
        ];

        // Appel API PayDunya
        $response = Http::withHeaders([
            'PAYDUNYA-MASTER-KEY' => env('PAYDUNYA_MASTER_KEY'),
            'PAYDUNYA-PRIVATE-KEY' => env('PAYDUNYA_PRIVATE_KEY'),
            'PAYDUNYA-TOKEN' => env('PAYDUNYA_TOKEN'),
            'Content-Type' => 'application/json'
        ])->post($this->baseUrl . "/checkout-invoice/create", $payload);

        if ($response->failed()) {
            return response()->json([
                "message" => "Erreur PayDunya",
                "error" => $response->body()
            ], 500);
        }

        $data = $response->json();

        if (!isset($data["response_code"]) || $data["response_code"] != "00") {
            return response()->json([
                "message" => "Erreur lors de la création de la facture.",
                "error" => $data
            ], 500);
        }

        // Retourner l'URL de paiement
        return response()->json([
            "checkout_url" => $data["response_text"],
            "invoice_token" => $data["invoice_token"],
            "transaction_id" => $transaction_id
        ]);
    }

    /**
     * 2) CALLBACK IPN — PayDunya appelle AUTOMATIQUEMENT ce endpoint
     */
    public function ipn(Request $request)
    {
        $invoice_token = $request->input("invoice_token");

        if (!$invoice_token) {
            return response("invoice_token manquant", 400);
        }

        // Vérification de la transaction
        $verify = Http::withHeaders([
            'PAYDUNYA-MASTER-KEY' => env('PAYDUNYA_MASTER_KEY'),
            'PAYDUNYA-PRIVATE-KEY' => env('PAYDUNYA_PRIVATE_KEY'),
            'PAYDUNYA-TOKEN' => env('PAYDUNYA_TOKEN'),
        ])->get($this->baseUrl . "/checkout-invoice/confirm/" . $invoice_token);

        $data = $verify->json();

        if (!isset($data["response_code"])) {
            return response("Réponse invalide PayDunya", 400);
        }

        // Récupérer l'order_id qu'on avait mis dans custom_data
        $order_id = $data["custom_data"]["order_id"] ?? null;

        if (!$order_id) {
            return response("order_id non trouvé", 400);
        }

        $order = Order::find($order_id);

        if (!$order) {
            return response("Commande introuvable", 404);
        }

        // Si response_code = 00 → succès du paiement
        if ($data["response_code"] == "00") {

            // Mettre à jour commande
            $order->update([
                "status" => "paid"
            ]);

            // Créer entrée dans la table payments
            Payment::create([
                "order_id" => $order->id,
                "transaction_id" => $data["transaction_id"],
                "amount" => $order->total_amount,
                "currency" => "XOF",
                "payment_method" => $data["payment_method"] ?? "mobile_money",
                "status" => "succeeded",
                "meta" => json_encode($data)
            ]);

            return response("SUCCESS", 200);
        }

        return response("FAILED", 400);
    }

    /**
     * 3) REDIRECTION SUCCESS (navigateur)
     */
    public function success()
    {
        return "Paiement PayDunya réussi 🎉";
    }

    /**
     * 4) REDIRECTION FAIL (navigateur)
     */
    public function fail()
    {
        return "Paiement PayDunya annulé ❌";
    }
}

