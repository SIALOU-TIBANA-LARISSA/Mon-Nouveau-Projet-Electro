<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Afficher la liste des commandes de l'utilisateur connecté
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Afficher les détails d'une commande
     */
    public function show($id)
    {
        $order = Order::where('id', $id)
                      ->where('user_id', auth()->id())
                      ->with('items.product')
                      ->firstOrFail();

        return view('orders.show', compact('order'));
    }
}
