<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Créer une commande à partir du panier
     */
    public function placeOrder(Request $request)
    {
        $user = $request->user();

        // Récupérer le panier de l'utilisateur
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->items->count() === 0) {
            return response()->json([
                'message' => 'Votre panier est vide.'
            ], 400);
        }

        DB::beginTransaction();

        try {
            // Générer un numéro unique de commande
            $reference = 'CMD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));

            // Créer la commande
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $cart->total_amount,
                'status' => 'pending',
                'reference_number' => $reference
            ]);

            // Copier chaque item du panier vers OrderItem
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                ]);
            }

            // Vider le panier
            CartItem::where('cart_id', $cart->id)->delete();
            $cart->update(['total_amount' => 0]);

            DB::commit();

            return response()->json([
                'message' => 'Commande créée avec succès.',
                'order' => $order->load('items.product'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Erreur lors de la création de la commande.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lister les commandes de l'utilisateur
     */
    public function listOrders(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }

    /**
     * Afficher une commande spécifique
     */
    public function showOrder($id)
    {
        $order = Order::with('items.product')->find($id);

        if (!$order) {
            return response()->json([
                'message' => 'Commande introuvable.'
            ], 404);
        }

        return response()->json($order);
    }
public function adminListOrders(Request $request)
{
    if ($request->user()->role->name !== 'Admin') {
        return response()->json(['message' => "Accès refusé."], 403);
    }

    $orders = Order::with('items.product', 'user')
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json($orders);
}
public function adminShowOrder(Request $request, $id)
{
    if ($request->user()->role->name !== 'Admin') {
        return response()->json(['message' => "Accès refusé."], 403);
    }

    $order = Order::with('items.product', 'user')->find($id);

    if (!$order) {
        return response()->json(['message' => 'Commande introuvable.'], 404);
    }

    return response()->json($order);
}
public function updateStatus(Request $request, $id)
{
    if ($request->user()->role->name !== 'Admin') {
        return response()->json(['message' => "Accès refusé."], 403);
    }

    $request->validate([
        'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
    ]);

    $order = Order::find($id);

    if (!$order) {
        return response()->json(['message' => "Commande introuvable."], 404);
    }

    $order->update([
        'status' => $request->status
    ]);

    return response()->json([
        'message' => "Statut de la commande mis à jour.",
        'order' => $order
    ]);
}


}

