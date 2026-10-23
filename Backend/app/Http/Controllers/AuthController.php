<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;    
use Illuminate\Support\Facades\Http;   
use Carbon\Carbon;
class AuthController extends Controller
{
    /**
     * Enregistre un nouvel utilisateur (avec le rôle par défaut 'Opérateur').
     */
    public function register(Request $request): JsonResponse
{
    try {
        // ✅ Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
        ]);

      $email = $validated['email'] ?? null;
$phone = $validated['phone'] ?? null;

if (!$email && !$phone) {
    return response()->json([
        'message' => 'Vous devez fournir un email ou un numéro de téléphone.'
    ], 422);
}


        // ✅ Création de l'utilisateur
        // ✅ Création de l'utilisateur AVEC rôle Client
$user = User::create([
    'name' => $validated['name'],
    'email' => $email,
    'phone' => $phone,
    'password' => Hash::make($validated['password']),
    'role_id' => 2,
    'phone_verified' => $phone ? 0 : 1,
]);

// 🔐 Génération OTP
if ($phone) {

    $otp = random_int(100000, 999999);

    DB::table('otp_codes')->insert([
        'phone' => $phone,
        'code' => $otp,
        'expires_at' => now()->addMinutes(5),
        'verified' => 0,
        'attempts' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    Http::withHeaders([
        'Authorization' => 'Bearer ' . env('HSMS_TOKEN'),
    ])->asForm()->post('https://www.hsms.ci/api/envoi-sms/', [
        'clientid' => env('HSMS_CLIENT_ID'),
        'clientsecret' => env('HSMS_CLIENT_SECRET'),
        'telephone' => $phone,
        'message' => "Votre code de verification est : $otp",
    ]);
}

        // ✅ (Optionnel mais PRO) Création du token
        return response()->json([
    'message' => 'Compte créé. Veuillez vérifier votre numéro.',
    'phone' => $phone
], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // ❌ Erreurs de validation claires
        return response()->json([
            'message' => 'Erreur de validation',
            'errors' => $e->errors(),
        ], 422);

    } catch (\Exception $e) {
        // ❌ Erreur serveur
        return response()->json([
            'message' => 'Erreur serveur',
            'error' => $e->getMessage(),
        ], 500);
    }
}

    /**
     * Connecte un utilisateur existant.
     */
     /**
 * Connecte un utilisateur existant.
 */
public function login(Request $request): JsonResponse
{
    $request->validate([
        'login' => 'required|string',
    'password' => 'required|string',
    ]);

   $user = User::where('email', $request->login)
            ->orWhere('phone', $request->login)
            ->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Identifiants invalides.',
        ], 401);
    }

    // 🔒 BLOQUER SI NON VERIFIÉ
if ($user->phone && $user->phone_verified == 0) {
    return response()->json([
        'message' => 'Veuillez vérifier votre numéro.'
    ], 403);
}


    $user->tokens()->delete();

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
    'message' => 'Connexion réussie.',
    'access_token' => $token,
    'token_type' => 'Bearer',
    'user' => [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'role_id' => $user->role_id
    ]
]);

}

    
public function loginWeb(Request $request)
{
    $request->validate([
        'login' => 'required|string',
        'password' => 'required|string',
    ]);

    $loginInput = $request->login;

    // Déterminer si c'est un email ou un numéro
    $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

    if (Auth::attempt([$field => $loginInput, 'password' => $request->password])) {

        $request->session()->regenerate();

        if (Auth::user()->role_id == 1) {
            return redirect()->route('admin.dashboard');
        }

        return redirect('/');
    }

    return back()->withErrors([
        'login' => 'Identifiants invalides',
    ]);
}
 
public function registerWeb(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'nullable|string|email|max:255|unique:users,email',
        'phone' => 'nullable|string|max:20|unique:users,phone',
        'password' => 'required|string|min:8|confirmed',
    ]);

    if (empty($validated['email']) && empty($validated['phone'])) {
        return back()->withErrors([
            'contact' => 'Vous devez fournir un email ou un numéro de téléphone.'
        ])->withInput();
    }

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'] ?? null,
        'phone' => $validated['phone'] ?? null,
        'password' => Hash::make($validated['password']),
        'role_id' => 2,
        'phone_verified' => empty($validated['phone']) ? 1 : 0,
    ]);

    return redirect()->route('login')
        ->with('success', 'Compte créé. Veuillez vérifier votre numéro.');
}


    /**
     * Déconnecte l'utilisateur actuel (révoque le token).
     */
    public function logout(Request $request): JsonResponse
    {
        // Supprime le token actuel utilisé pour la requête
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie. Token révoqué.',
        ]);
    }

    /**
     * Retourne les informations de l'utilisateur authentifié.
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        // Assurez-vous que la relation de rôle est chargée pour éviter les N+1
        $user->load('role');

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role->name, // Le nom du rôle
                'role_id' => $user->role_id, // L'ID du rôle
            ],
            'message' => 'Informations utilisateur récupérées.',
        ]);
    }

    public function verifyOtp(Request $request): JsonResponse
{
    
    $request->validate([
        'phone' => 'required|string',
        'code' => 'required|string',
    ]);

    $otp = DB::table('otp_codes')
        ->where('phone', $request->phone)
        ->where('code', $request->code)
        ->where('verified', 0)
        ->first();
if (!$otp) {

    // Récupérer dernier OTP non vérifié
    $wrongOtp = DB::table('otp_codes')
        ->where('phone', $request->phone)
        ->where('verified', 0)
        ->orderByDesc('id')
        ->first();

    if ($wrongOtp) {

        DB::table('otp_codes')
            ->where('id', $wrongOtp->id)
            ->increment('attempts');

        if ($wrongOtp->attempts >= 2) {
            return response()->json([
                'message' => 'Trop de tentatives. Demandez un nouveau code.'
            ], 403);
        }
    }

    return response()->json([
        'message' => 'Code invalide.'
    ], 400);
}
    

    // 🔒 Vérification expiration (AJOUTE ÇA)
if (Carbon::parse($otp->expires_at)->isPast()) {
    return response()->json([
        'message' => 'Code expiré.'
    ], 400);
}

    // Marquer OTP comme vérifié
    DB::table('otp_codes')
        ->where('id', $otp->id)
        ->update(['verified' => 1]);

    // Activer le compte
    $user = User::where('phone', 'LIKE', '%' . $request->phone)->first();
    $user->update(['phone_verified' => 1]);
    Auth::login($user);
$request->session()->regenerate();
    
    
    // Créer token maintenant
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Numéro vérifié avec succès.',
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => $user
    ]);
}

public function resendOtp(Request $request): JsonResponse
{
    $request->validate([
        'phone' => 'required|string|exists:users,phone'
    ]);

    $user = User::where('phone', $request->phone)->first();

    if ($user->phone_verified == 1) {
        return response()->json([
            'message' => 'Ce numéro est déjà vérifié.'
        ], 400);
    }

    $otp = random_int(100000, 999999);

    DB::table('otp_codes')->insert([
        'phone' => $request->phone,
        'code' => $otp,
        'expires_at' => now()->addMinutes(5),
        'verified' => 0,
        'attempts' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $phoneForSms = $request->phone;

if (substr($phoneForSms, 0, 1) === '0') {
    $phoneForSms = '225' . substr($phoneForSms, 1);
}

    Http::withHeaders([
        'Authorization' => 'Bearer ' . env('HSMS_TOKEN'),
    ])->asForm()->post('https://www.hsms.ci/api/envoi-sms/', [
        'clientid' => env('HSMS_CLIENT_ID'),
        'clientsecret' => env('HSMS_CLIENT_SECRET'),
        'telephone' => $phoneForSms,
        'message' => "Votre nouveau code est : $otp",
    ]);

    return response()->json([
        'message' => 'Nouveau code envoyé.'
    ]);
}

public function forgotPassword(Request $request): JsonResponse
{
    $request->validate([
        'phone' => 'required|string|exists:users,phone'
    ]);

    $otp = random_int(100000, 999999);

    DB::table('otp_codes')->insert([
        'phone' => $request->phone,
        'code' => $otp,
        'expires_at' => now()->addMinutes(5),
        'verified' => 0,
        'attempts' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
 
  $phoneForSms = $request->phone;

if (substr($phoneForSms, 0, 1) === '0') {
    $phoneForSms = '225' . substr($phoneForSms, 1);
}

    Http::withHeaders([
        'Authorization' => 'Bearer ' . env('HSMS_TOKEN'),
    ])->asForm()->post('https://www.hsms.ci/api/envoi-sms/', [
        'clientid' => env('HSMS_CLIENT_ID'),
        'clientsecret' => env('HSMS_CLIENT_SECRET'),
        'telephone' => $phoneForSms,
        'message' => "Code de réinitialisation : $otp",
    ]);

    return response()->json([
        'message' => 'Code envoyé pour réinitialisation.'
    ]);
}

public function resetPassword(Request $request): JsonResponse
{
    $request->validate([
        'phone' => 'required|string',
        'code' => 'required|string',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $otp = DB::table('otp_codes')
        ->where('phone', $request->phone)
        ->where('code', $request->code)
        ->where('verified', 0)
        ->first();

    if (!$otp) {
        return response()->json([
            'message' => 'Code invalide.'
        ], 400);
    }

    if (Carbon::parse($otp->expires_at)->isPast()) {
        return response()->json([
            'message' => 'Code expiré.'
        ], 400);
    }

    $user = User::where('phone', $request->phone)->first();

if (!$user) {
    return response()->json([
        'message' => 'Utilisateur introuvable.'
    ], 404);
}

$user->update([
    'password' => Hash::make($request->password)
]);

    DB::table('otp_codes')
        ->where('id', $otp->id)
        ->update(['verified' => 1]);

    return response()->json([
        'message' => 'Mot de passe réinitialisé avec succès.'
    ]);
}
}