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

        // Email vers TOI (test)
        Mail::raw(
            "Nom : {$request->name}\nEmail : {$request->email}\n\nMessage :\n{$request->message}",
            function ($mail) use ($request) {
                $mail->to('sialoutibanalarissa@gmail.com')
                     ->subject('📩 Nouveau message – Contact H-ELECTRO')
                     ->replyTo($request->email);
            }
        );

        // Copie vers le client
        Mail::raw(
            "Bonjour {$request->name},\n\nNous avons bien reçu votre message :\n\n{$request->message}\n\n— H-ELECTRO",
            function ($mail) use ($request) {
                $mail->to($request->email)
                     ->subject('✅ Message reçu – H-ELECTRO');
            }
        );

        return response()->json([
            'success' => true,
            'message' => 'Message envoyé avec succès'
        ]);
    }
}
