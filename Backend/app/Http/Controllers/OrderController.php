<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
    $orders = Order::where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();

    return view('orders.index', compact('orders'));
    }
    public function show($id)
    {
        $order = Order::with('items.product')
        ->where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    return view('orders.show', compact('order'));
    }
}

