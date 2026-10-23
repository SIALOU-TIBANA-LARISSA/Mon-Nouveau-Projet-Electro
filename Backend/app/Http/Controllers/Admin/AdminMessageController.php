<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminMessageController extends Controller
{
    public function send(Request $request, Order $order)
    {
        $request->validate([
            'subject' => 'nullable|string',
            'content' => 'required|string',
        ]);

        // 1️⃣ Enregistrement en base (messagerie interne)
        Message::create([
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'subject' => $request->subject,
            'content' => $request->content,
            'is_from_admin' => true,
        ]);

        // 2️⃣ Envoi email réel
        Mail::raw($request->content, function ($message) use ($order, $request) {
            $message->to($order->user->email)
                    ->subject($request->subject ?? 'Nouveau message concernant votre commande');
        });

        return back()->with('success', 'Message envoyé au client');
    }
}