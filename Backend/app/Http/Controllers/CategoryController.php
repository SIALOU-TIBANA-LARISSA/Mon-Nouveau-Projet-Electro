<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str; // Importation pour générer le slug

class CategoryController extends Controller
{
    /**
     * Affiche une liste de toutes les catégories. (Accessible à tous les utilisateurs connectés)
     */
    public function index(): JsonResponse
    {
        // Récupère toutes les catégories, triées par nom
        $categories = Category::orderBy('name')->get();
        return response()->json($categories);
    }

    /**
     * Stocke une nouvelle catégorie. (Admin uniquement)
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Valider les données
            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name',
                'description' => 'nullable|string',
            ]);

            // Créer le slug automatiquement
            $slug = Str::slug($request->name);

            $category = Category::create([
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
            ]);

            return response()->json([
                'message' => 'Catégorie créée avec succès.',
                'category' => $category,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation lors de la création de la catégorie.',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Affiche une catégorie spécifique. (Accessible à tous les utilisateurs connectés)
     */
    public function show(string $slug): JsonResponse
    {
        // Recherche par slug ou lance une exception 404
        $category = Category::where('slug', $slug)->firstOrFail();
        return response()->json($category);
    }

    /**
     * Met à jour la catégorie spécifiée. (Admin uniquement)
     */
    public function update(Request $request, string $slug): JsonResponse
    {
        try {
            $category = Category::where('slug', $slug)->firstOrFail();

            // Valider les données (le nom doit être unique sauf pour l'ID actuel)
            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
                'description' => 'nullable|string',
            ]);

            // Recalculer le slug si le nom a changé
            $newSlug = Str::slug($request->name);

            $category->update([
                'name' => $request->name,
                'slug' => $newSlug,
                'description' => $request->description,
            ]);

            return response()->json([
                'message' => 'Catégorie mise à jour avec succès.',
                'category' => $category,
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation lors de la mise à jour de la catégorie.',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Supprime la catégorie spécifiée. (Admin uniquement)
     */
    public function destroy(string $slug): JsonResponse
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        // NOTE: Une bonne pratique serait de vérifier si des produits sont liés
        // avant de supprimer, ou d'utiliser une suppression en cascade douce (soft deletes).

        $category->delete();

        return response()->json([
            'message' => 'Catégorie supprimée avec succès.',
        ]);
    }
}