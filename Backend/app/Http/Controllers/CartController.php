<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show()
{
    $userId = auth()->id();
    $sessionId = session()->getId();

    $cart = Cart::where(function ($query) use ($userId, $sessionId) {
        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }
    })->with('items.product')->first();

    if (!$cart) {
        return response()->json(['items' => []]);
    }

    return response()->json([
        'items' => $cart->items
    ]);
}
public function add(Request $request)
{
    $userId = auth()->id();
    $sessionId = session()->getId();

    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'integer|min:1'
    ]);

    $cart = Cart::where(function ($query) use ($userId, $sessionId) {
    if ($userId) {
        $query->where('user_id', $userId);
    } else {
        $query->where('session_id', $sessionId);
    }
})->first();

if (!$cart) {
    $cart = Cart::create([
        'user_id' => $userId,
        'session_id' => $userId ? null : $sessionId,
        'total_amount' => 0
    ]);
}

    $product = Product::findOrFail($request->product_id);

    $item = CartItem::where('cart_id', $cart->id)
        ->where('product_id', $product->id)
        ->first();

    if ($item) {
        $item->quantity += $request->quantity ?? 1;
        $item->save();
    } else {
        $price = ($product->promo_price && $product->promo_price < $product->price)
    ? $product->promo_price
    : $product->price;

CartItem::create([
    'cart_id' => $cart->id,
    'product_id' => $product->id,
    'quantity' => $request->quantity ?? 1,
    'unit_price' => $price
]);
    }

    return response()->json(['message' => 'OK']);
}
    
public function remove($item_id)
{
    $item = CartItem::findOrFail($item_id);
    $item->delete();

    return response()->json(['message' => 'deleted']);
}

public function clear()
{
    $userId = auth()->id();

    $cart = Cart::where('user_id', $userId)->first();

    if ($cart) {
        $cart->items()->delete(); // supprime tous les produits
        $cart->delete(); // supprime le panier lui-même (optionnel)
    }

    return response()->json(['message' => 'Panier vidé']);
}

}