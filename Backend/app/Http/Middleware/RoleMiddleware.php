<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Import ajouté pour Auth::check()

class RoleMiddleware
{
    /**
     * Gère une requête entrante et vérifie si l'utilisateur possède l'un des rôles requis.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Liste des rôles autorisés (ex: 'Admin', 'Designer').
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response // ⬅️ CORRECTION ICI : utilisation de '...'
    {
        // 1. Vérifier si l'utilisateur est authentifié
        if (! Auth::check()) { // Utilisation de l'Auth Facade
            return response()->json([
                'message' => 'Non authentifié. Veuillez vous connecter.',
            ], 401); // Code 401: Unauthorized
        }

        $user = Auth::user();

        // 2. Vérification du rôle
        // Nous vérifions si le nom du rôle de l'utilisateur est présent dans le tableau $roles
        // $roles est maintenant un tableau grâce à '...'
        if (! in_array($user->role->name, $roles)) {
            // Afficher les rôles requis pour un meilleur débogage côté client
            $requiredRoles = implode(', ', $roles);
            
            return response()->json([
                'message' => 'Accès refusé. Rôles requis : ' . $requiredRoles,
            ], 403); // Code 403: Forbidden
        }

        // 3. Si tout est bon, continuer la requête
        return $next($request);
    }
}