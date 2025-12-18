<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\PaymentIntent as StripePaymentIntent;

class StripeController extends Controller
{
    public function __construct()
    {
        // s'assure que la clé est chargée ; lève une exception si manquante pour debug rapide
        if (!env('STRIPE_SECRET')) {
            // Ne pas throw en prod, mais pour dev c'est utile
            // throw new \RuntimeException('STRIPE_SECRET not set in .env');
        }
    }

    /**
     * Crée une session de paiement Stripe
     */
    public function createCheckoutSession(Request $request)
    {
        $user = $request->user();

        $order = Order::where('user_id', $user->id)
                      ->where('status', 'pending')
                      ->latest()
                      ->first();

        if (!$order) {
            return response()->json(['message' => 'Aucune commande en attente de paiement.'], 404);
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'XOF',
                        'product_data' => [
                            'name' => 'Commande ' . $order->reference_number,
                        ],
                        'unit_amount' => (int) round($order->total_amount * 100),
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'metadata' => [
                    'order_reference' => $order->reference_number,
                ],
                'success_url' => 'http://127.0.0.1:8000/payment-success?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'  => 'http://127.0.0.1:8000/payment-cancel',
            ]);

            // Sauvegarde l'id de session Stripe pour traçabilité
            $order->update(['payment_session_id' => $session->id]);

            return response()->json([
                'checkout_url' => $session->url ?? $session->payment_intent ?? null,
                'session_id' => $session->id,
                'reference' => $order->reference_number,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création du paiement.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Stripe redirige ici après paiement réussi.
     * On récupère la session Stripe, on met à jour la commande et on enregistre le paiement.
     */
    public function paymentSuccess(Request $request)
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return response("Session ID manquant.", 400);
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Récupère la session côté Stripe
            $session = StripeSession::retrieve($sessionId);

            // Récupère la reference depuis metadata si présente
            $reference = $session->metadata->order_reference ?? null;

            if ($reference) {
                $order = Order::where('reference_number', $reference)->first();
            } else {
                $order = Order::where('payment_session_id', $sessionId)->first();
            }

            if (!$order) {
                return response("Commande introuvable.", 404);
            }

            // Récupérer l'ID du PaymentIntent (peut être dans session->payment_intent)
            $paymentIntentId = $session->payment_intent ?? null;

            // Si on a un payment_intent, on peut récupérer son état / id réel
            $transactionId = null;
            $amountReceived = null;
            $currency = 'XOF';

            if ($paymentIntentId) {
                // Récupérer le PaymentIntent (sécurisé)
                try {
                    $pi = StripePaymentIntent::retrieve($paymentIntentId);
                    $transactionId = $pi->id ?? $paymentIntentId;
                    // amount_received est en cents
                    $amountReceived = isset($pi->amount_received) ? ($pi->amount_received / 100) : $order->total_amount;
                    $currency = strtoupper($pi->currency ?? 'XOF');
                } catch (\Exception $e) {
                    // fallback si retrieve échoue : on utilise session et order
                    $transactionId = $paymentIntentId;
                    $amountReceived = $order->total_amount;
                }
            } else {
                // pas de payment_intent fourni (rare), on prend les données de la commande
                $transactionId = $session->id;
                $amountReceived = $order->total_amount;
            }

            // Mettre à jour le statut de la commande
            $order->update([
                'status' => 'paid',
                'payment_session_id' => $sessionId,
            ]);

            // Créer enregistrement de paiement si non présent
            Payment::firstOrCreate(
                [
                    'order_id' => $order->id,
                    'transaction_id' => $transactionId,
                ],
                [
                    'amount' => $amountReceived,
                    'currency' => strtoupper($currency),
                    'payment_method' => 'card',
                    'status' => 'succeeded',
                ]
            );

            return "Paiement validé ! Votre commande (" . $order->reference_number . ") est maintenant confirmée.";
        } catch (\Exception $e) {
            // Log l'erreur pour debugging (fichier storage/logs/laravel.log)
            \Log::error('Stripe paymentSuccess error: '.$e->getMessage());
            return response("Erreur lors de la vérification du paiement : " . $e->getMessage(), 500);
        }
    }
}
