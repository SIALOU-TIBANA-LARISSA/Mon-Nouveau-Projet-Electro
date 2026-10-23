<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
{
    $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email',
        'message' => 'required|string',
    ]);

    // 📩 Email vers l'entreprise
    Mail::raw(
        "Nom : {$request->name}\nEmail : {$request->email}\n\nMessage :\n{$request->message}",
        function ($mail) use ($request) {
            $mail->to('fabcrea@h-fablab.org')
                 ->subject('📩 Nouveau message – H-Créa & Design')
                 ->replyTo($request->email);
        }
    );

    // ✅ Email automatique vers le client
    Mail::raw(
        "Bonjour {$request->name},

Nous avons bien reçu votre message :

\"{$request->message}\"

Notre équipe vous répondra dans les plus brefs délais.

— H-Créa & Design
Impression & personnalisation
https://red-goshawk-398004.hostingersite.com",
        function ($mail) use ($request) {
            $mail->to($request->email)
                 ->subject('✅ Confirmation de réception – H-Créa & Design');
        }
    );

    return response()->json([
        'success' => true,
        'message' => 'Message envoyé avec succès'
    ]);
}
}
