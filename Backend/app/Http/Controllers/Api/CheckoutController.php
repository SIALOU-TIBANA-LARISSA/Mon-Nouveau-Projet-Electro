<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {

        \Log::info('CHECKOUT DATA', $request->all());


        // 1. Validation des données envoyées par le frontend
        $data = $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'cart' => 'required|array',
        ]);

        // 2. Vérifier si l'utilisateur existe déjà
        $user = User::where('email', $data['email'])->first();
        $isNewUser = false;

        if (!$user) {
            // 3. Création automatique du compte
            $password = Str::random(8);

            $user = User::create([
    'name' => $data['firstname'] . ' ' . $data['lastname'],
    'email' => $data['email'],
    'password' => Hash::make($password),
    'role_id' => 2, // client
]);


            $isNewUser = true;

            // 4. Envoyer les identifiants par mail
            Mail::raw("
Bonjour {$data['firstname']},

Votre compte a été créé automatiquement sur ElectroV2.

Voici vos identifiants :

Email : {$data['email']}
Mot de passe : $password

Conservez ces informations pour suivre vos commandes.

Merci pour votre achat !
            ", function ($message) use ($data) {
                $message->to($data['email'])
                        ->subject("Votre compte ElectroV2 est créé");
            });
        }

        // 5. Calcul du total du panier
        $total = collect($data['cart'])->sum(function ($item) {
            return $item['unit_price'] * $item['quantity'];
        });

        // 6. Création de la commande
        $order = Order::create([
    'user_id' => $user->id,
    'reference_number' => 'CMD-' . strtoupper(uniqid()),
    'total_amount' => $total,
    'status' => 'pending',
]);


        // 7. Enregistrement de chaque item
        foreach ($data['cart'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);
        }

        // 8. Retourner l’URL de paiement (exemple générique)
        return response()->json([
            'message' => 'Commande créée avec succès',
            'order_id' => $order->id
        ]);
    }
}



