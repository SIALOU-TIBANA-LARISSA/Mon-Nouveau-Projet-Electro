<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * GET /api/categories
     * Retourne la liste des catégories (avec pagination).
     */
    public function index(Request $request)
    {
        // pagination param (optional)
        $perPage = (int) $request->query('per_page', 12);

        $categories = Category::select('id', 'name', 'slug', 'description')
            ->orderBy('name')
            ->paginate($perPage);

        return response()->json($categories);
    }

    /**
     * GET /api/categories/{id_or_slug}
     * Retourne le détail d'une catégorie (recherche par id ou slug).
     */
    public function show($id_or_slug)
    {
        $category = Category::where('id', $id_or_slug)
            ->orWhere('slug', $id_or_slug)
            ->withCount('products')
            ->first();

        if (!$category) {
            return response()->json(['message' => 'Catégorie introuvable.'], 404);
        }

        return response()->json($category);
    }

    /**
     * GET /api/categories/{id_or_slug}/products
     * Retourne les produits d'une catégorie (avec pagination).
     */
    public function products(Request $request, $id_or_slug)
    {
        $perPage = (int) $request->query('per_page', 12);

        $category = Category::where('id', $id_or_slug)
            ->orWhere('slug', $id_or_slug)
            ->first();

        if (!$category) {
            return response()->json(['message' => 'Catégorie introuvable.'], 404);
        }

        $products = $category->products()
            ->where('is_published', true)
            ->select('id','name','slug','price','main_image_url','sku','stock_quantity')
            ->orderBy('name')
            ->paginate($perPage);

        return response()->json($products);
    }
    public function store(Request $request)
{
    $user = $request->user();

    if (!$user || !isset($user->role) || $user->role->name !== 'Admin') {
        return response()->json(['message' => "Accès refusé."], 403);
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:categories,name',
        'slug' => 'required|string|max:255|unique:categories,slug',
        'description' => 'nullable|string',
        'parent_id' => 'nullable|exists:categories,id'
    ]);

    $category = Category::create($validated);

    return response()->json([
        'message' => "Catégorie créée avec succès.",
        'category' => $category
    ], 201);
}

public function update(Request $request, $id)
{
    $user = $request->user();

    if (!$user || !isset($user->role) || $user->role->name !== 'Admin') {
        return response()->json(['message' => "Accès refusé."], 403);
    }

    $category = Category::find($id);

    if (!$category) {
        return response()->json(['message' => "Catégorie introuvable."], 404);
    }

    $validated = $request->validate([
        'name' => 'sometimes|string|max:255|unique:categories,name,' . $id,
        'slug' => 'sometimes|string|max:255|unique:categories,slug,' . $id,
        'description' => 'nullable|string',
        'parent_id' => 'nullable|exists:categories,id'
    ]);

    $category->update($validated);

    return response()->json([
        'message' => "Catégorie mise à jour.",
        'category' => $category
    ]);
}

public function destroy(Request $request, $id)
{
    $user = $request->user();

    if (!$user || !isset($user->role) || $user->role->name !== 'Admin') {
        return response()->json(['message' => "Accès refusé."], 403);
    }

    $category = Category::find($id);

    if (!$category) {
        return response()->json(['message' => "Catégorie introuvable."], 404);
    }

    // Refuser la suppression si des produits existent dans cette catégorie
    if ($category->products()->exists()) {
        return response()->json([
            'message' => "Impossible de supprimer : cette catégorie contient des produits."
        ], 400);
    }

    $category->delete();

    return response()->json(['message' => "Catégorie supprimée avec succès."]);
}

}
