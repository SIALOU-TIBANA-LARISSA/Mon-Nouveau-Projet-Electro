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
use App\Models\Message;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {   try {
       

        \Log::info('CHECKOUT DATA', $request->all());


        // 1. Validation des données envoyées par le frontend
$data = $request->validate([
    'firstname' => 'required|string',
    'lastname' => 'required|string',
    'email' => 'required|email',
    'phone' => 'required|string',
    'address' => 'required|string',
    'country' => 'required|string',
    'city' => 'required|string',
    'shipping_method' => 'required|string',
    'delivery_type' => 'required|string',
    'cart' => 'required|array',
]);

        // 2. Vérifier si l'utilisateur existe déjà
        $user = auth()->user();

if (!$user) {
    return response()->json([
        'message' => 'Vous devez être connecté pour commander.'
    ], 401);
}
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

    $price = $item['unit_price'] ?? 0;
    $qty = $item['quantity'] ?? 1;

    return $price * $qty;
});
 

        // 6. Création de la commande
        $order = Order::create([
    'user_id' => $user->id,
    'reference_number' => 'CMD-' . strtoupper(uniqid()),
    'total_amount' => $total,
    'status' => 'pending',

    'shipping_address' => $data['address'],
    'shipping_city' => $data['city'],
    'shipping_country' => $data['country'],
    'shipping_method' => $data['shipping_method'],
    'delivery_type' => $data['delivery_type'],
]);

Message::create([
    'user_id' => $user->id,
    'order_id' => $order->id,
    'subject' => 'Commande reçue',
    'content' => 'Votre commande a bien été reçue et est en cours de traitement.',
    'is_from_admin' => true,
]);
        // 7. Enregistrement de chaque item
        foreach ($data['cart'] as $item) {

    if (!isset($item['product_id'])) continue;

    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $item['product_id'],
        'quantity' => $item['quantity'] ?? 1,
        'unit_price' => $item['unit_price'] ?? 0,
    ]);
}

        // 9. Email de confirmation au client
Mail::raw("
Bonjour {$user->name},

Merci pour votre commande !

Référence : {$order->reference_number}
Montant total : {$order->total_amount} FCFA
Statut : {$order->status}

Nous vous contacterons très bientôt.

Cordialement,
H-Créa & Design
", function ($message) use ($user, $order) {
    $message->to($user->email)
            ->subject("Confirmation de votre commande {$order->reference_number}");
});

// 10. Email à l'entreprise
Mail::raw("
Nouvelle commande reçue !

Client : {$user->name}
Email : {$user->email}
Téléphone : {$request->phone}
Adresse : {$request->address}

Référence : {$order->reference_number}
Total : {$order->total_amount} FCFA
", function ($message) {
    $message->to('fabcrea@h-fablab.org')
            ->subject("Nouvelle commande reçue");
});

        // 8. Retourner l’URL de paiement (exemple générique)
        return response()->json([
    'message' => 'Commande créée avec succès',
    'order_id' => $order->id
]);

    } catch (\Throwable $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'line' => $e->getLine()
        ]);
    }
}
}



