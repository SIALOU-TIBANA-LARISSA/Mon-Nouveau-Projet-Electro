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
            // Valider les données reçues
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed', // 'confirmed' vérifie password_confirmation
            ]);

            // Trouver l'ID du rôle 'Opérateur' (rôle par défaut pour les nouveaux utilisateurs)
            $operatorRole = \App\Models\Role::where('name', 'Opérateur')->first();

            if (!$operatorRole) {
                return response()->json([
                    'message' => 'Rôle "Opérateur" non trouvé. Veuillez vérifier les seeders.',
                ], 500);
            }

            // Créer l'utilisateur
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $operatorRole->id, // Assigner le rôle Opérateur
            ]);

            // Générer un token pour l'utilisateur
            // Le token est un identifiant unique qui sera utilisé pour les requêtes API (voir M2)
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Utilisateur créé avec succès.',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role->name, // Afficher le nom du rôle
                ],
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
             // En cas d'erreur inattendue (ex: problème de base de données)
            return response()->json([
                'message' => 'Erreur lors de l\'enregistrement.',
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