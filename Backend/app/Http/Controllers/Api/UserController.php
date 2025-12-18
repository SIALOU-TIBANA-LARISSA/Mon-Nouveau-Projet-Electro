<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;

class UserController extends Controller
{
    /**
     * Liste de tous les utilisateurs (ADMIN)
     */
    public function index(Request $request)
    {
        if ($request->user()->role->name !== 'Admin') {
            return response()->json(['message' => "Accès refusé."], 403);
        }

        $users = User::with('role')->get();

        return response()->json($users);
    }

    /**
     * Créer un utilisateur (ADMIN)
     */
    public function store(Request $request)
    {
        if ($request->user()->role->name !== 'Admin') {
            return response()->json(['message' => "Accès refusé."], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id'
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'message' => "Utilisateur créé avec succès.",
            'user' => $user
        ], 201);
    }

    /**
     * Modifier un utilisateur
     */
    public function update(Request $request, $id)
    {
        if ($request->user()->role->name !== 'Admin') {
            return response()->json(['message' => "Accès refusé."], 403);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => "Utilisateur introuvable."], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:8',
            'role_id' => 'sometimes|exists:roles,id'
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => "Utilisateur mis à jour.",
            'user' => $user
        ]);
    }

    /**
     * Supprimer un utilisateur
     */
    public function destroy(Request $request, $id)
    {
        if ($request->user()->role->name !== 'Admin') {
            return response()->json(['message' => "Accès refusé."], 403);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => "Utilisateur introuvable."], 404);
        }

        // Empêcher la suppression si l’utilisateur a passé des commandes
        if ($user->orders()->exists()) {
            return response()->json([
                'message' => "Impossible de supprimer cet utilisateur car il possède des commandes."
            ], 400);
        }

        $user->delete();

        return response()->json(['message' => "Utilisateur supprimé avec succès."]);
    }
}

