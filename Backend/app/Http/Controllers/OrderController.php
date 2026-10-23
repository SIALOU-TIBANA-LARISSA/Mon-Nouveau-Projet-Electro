<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

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

public function store(Request $request)
{
    $order = Order::create([
        'user_id' => auth()->id(),
        'status' => 'pending',
        'total' => 0, // on ajustera plus tard
    ]);

    // Email au client
    Mail::raw(
        "Bonjour " . auth()->user()->name . ",\n\nVotre commande #{$order->id} a été enregistrée avec succès.",
        function ($message) use ($order) {
            $message->to(auth()->user()->email)
                    ->subject("Confirmation de votre commande #{$order->id}");
        }
    );

    return redirect()->route('merci');
}
}

