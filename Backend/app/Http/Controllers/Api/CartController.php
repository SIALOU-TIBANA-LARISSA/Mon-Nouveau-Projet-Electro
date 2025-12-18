<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * GET /api/cart
     * Afficher le panier de l'utilisateur connecté.
     */
    public function show(Request $request)
    {
        $user = $request->user();

        // Récupérer ou créer un panier pour l'utilisateur
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['total_amount' => 0]
        );

        // Charger les items avec les produits associés
        $cart->load('items.product');

        return response()->json($cart);
    }

    /**
     * POST /api/cart/add
     * Ajouter un produit au panier.
     */
    public function add(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1'
        ]);

        // Récupérer ou créer le panier
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['total_amount' => 0]
        );

        // Charger le produit
        $product = Product::findOrFail($request->product_id);

        // Vérifier si le produit est déjà dans le panier
        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            // Si déjà présent → on augmente la quantité
            $item->quantity += $request->quantity ?? 1;
            $item->save();
        } else {
            // Sinon → ajouter l'item
            $item = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity ?? 1,
                'unit_price' => $product->price
            ]);
        }

        // Recalcul du total
        $this->updateTotal($cart);

        return response()->json([
            'message' => 'Produit ajouté au panier.',
            'cart' => $cart->load('items.product')
        ]);
    }

    /**
     * PUT /api/cart/update/{item_id}
     * Modifier la quantité d’un article.
     */
    public function update(Request $request, $item_id)
    {
        $user = $request->user();

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $item = CartItem::whereHas('cart', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->findOrFail($item_id);

        $item->quantity = $request->quantity;
        $item->save();

        // Recalcul du total
        $this->updateTotal($item->cart);

        return response()->json(['message' => 'Quantité mise à jour.']);
    }

    /**
     * DELETE /api/cart/remove/{item_id}
     * Supprimer un article du panier.
     */
    public function remove(Request $request, $item_id)
    {
        $user = $request->user();

        $item = CartItem::whereHas('cart', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->findOrFail($item_id);

        $cart = $item->cart;
        $item->delete();

        // Recalcul du total
        $this->updateTotal($cart);

        return response()->json(['message' => 'Article supprimé du panier.']);
    }

    /**
     * Fonction interne : recalculer le total du panier.
     */
    private function updateTotal(Cart $cart)
    {
        $total = $cart->items()->sum(\DB::raw('quantity * unit_price'));
        $cart->total_amount = $total;
        $cart->save();
    }
}

