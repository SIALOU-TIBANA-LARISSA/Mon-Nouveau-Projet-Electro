<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();

        return view('admin.orders.index', compact('orders'));
    }
    
    public function show(Order $order)
    {
        $order->load('items.product', 'user');

        return view('admin.orders.show', compact('order'));
    }

public function updateStatus(Request $request, Order $order)
{
    $request->validate([
        'status' => 'required|string'
    ]);

    $order->update([
        'status' => $request->status
    ]);

    return redirect()
        ->route('admin.orders.show', $order->id)
        ->with('success', 'Statut de la commande mis à jour');
}

public function destroy(Order $order)
{
    $order->delete();

    return redirect()->route('admin.orders')
        ->with('success', 'Commande supprimée avec succès');
}



}



