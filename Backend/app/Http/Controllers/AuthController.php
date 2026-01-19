<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // ✅ Création de l'utilisateur
        // ✅ Création de l'utilisateur AVEC rôle Client
$user = User::create([
    'name' => $validated['name'],
    'email' => $validated['email'],
    'password' => Hash::make($validated['password']),
    'role_id' => 2, // 👈 rôle Client
]);

        // ✅ (Optionnel mais PRO) Création du token
        $token = $user->createToken('auth_token')->plainTextToken;

        // ✅ Réponse JSON propre
        return response()->json([
            'message' => 'Compte créé avec succès',
            'user' => $user,
            'token' => $token,
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
    public function login(Request $request): JsonResponse
    {
        try {
            // Valider les données
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Tenter d'authentifier l'utilisateur
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Identifiants invalides.',
                ], 401);
            }
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
    'token' => $token,
    'user' => [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
    ]
    ]);

            // Supprimer tous les anciens tokens de l'utilisateur pour la sécurité
            $user->tokens()->delete();

            // Générer un nouveau token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Connexion réussie.',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role->name,
                ],
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la connexion.',
                'error' => $e->getMessage(),
            ], 500);
        }
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
}