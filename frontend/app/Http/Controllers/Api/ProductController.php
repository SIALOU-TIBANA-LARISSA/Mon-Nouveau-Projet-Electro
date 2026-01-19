<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

use App\Models\OrderItem;
use Illuminate\Support\Facades\Http;


class ProductController extends Controller
{
    /**
     * GET /api/products
     * Liste paginée de tous les produits publiés.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 12);

        $products = Product::where('is_published', true)
            ->select('id','name','slug','price','main_image_url','sku','stock_quantity')
            ->orderBy('name')
            ->paginate($perPage);

        return response()->json($products);
    }

    /**
     * GET /api/products/{id_or_slug}
     * Détails d’un produit (avec catégorie).
     */
    public function show($id_or_slug)
    {
        $response = Http::get("http://127.0.0.1:8001/api/products/{$id_or_slug}");

        if ($response->failed()) {
            abort(404);
        }

        $product = $response->json();

        return view('products.show', compact('product'));
    }


    /**
     * GET /api/products/search?q=mot
     * Recherche de produits (par nom et description).
     */
    public function search(Request $request)
    {
        $query = $request->query('q', '');

        if (empty($query)) {
            return response()->json(['message' => 'Veuillez fournir un mot-clé pour la recherche.'], 400);
        }

        $products = Product::where('is_published', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->select('id','name','slug','price','main_image_url','sku','stock_quantity')
            ->orderBy('name')
            ->paginate(12);

        return response()->json($products);
    }
    /**
 * Ajouter un nouveau produit (ADMIN)
 */
public function store(Request $request)
{
    // Vérifier que l'utilisateur est admin (protection si role null)
    $user = $request->user();
    if (!$user || !isset($user->role) || $user->role->name !== 'Admin') {
        return response()->json(['message' => "Accès refusé. Vous n'êtes pas administrateur."], 403);
    }

    // Validation
    $validator = \Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:products,slug',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'stock_quantity' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'main_image_url' => 'nullable|string',
        'sku' => 'required|string|unique:products,sku',
        'is_published' => 'sometimes|boolean',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Erreur de validation.',
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $data = $validator->validated();
        // Création
        $product = Product::create($data);

        return response()->json([
            'message' => "Produit créé avec succès.",
            'product' => $product
        ], 201);

    } catch (\Illuminate\Database\QueryException $ex) {
        // Retourne l'erreur SQL utile (mais pas la stack complète en prod)
        return response()->json([
            'message' => 'Erreur base de données lors de la création.',
            'error' => $ex->getMessage()
        ], 500);
    } catch (\Throwable $th) {
        return response()->json([
            'message' => 'Erreur inattendue.',
            'error' => $th->getMessage()
        ], 500);
    }
}


/**
 * Modifier un produit (ADMIN)
 */
public function update(Request $request, $id)
{
    if ($request->user()->role->name !== 'Admin') {
        return response()->json(['message' => "Accès refusé."], 403);
    }

    $product = Product::find($id);
    if (!$product) {
        return response()->json(['message' => "Produit non trouvé."], 404);
    }

    $request->validate([
        'name' => 'sometimes|string|max:255',
        'slug' => 'sometimes|string|max:255|unique:products,slug,' . $id,
        'description' => 'nullable|string',
        'price' => 'sometimes|numeric',
        'stock_quantity' => 'sometimes|integer|min:0',
        'category_id' => 'sometimes|exists:categories,id',
        'main_image_url' => 'nullable|string',
        'sku' => 'sometimes|string|unique:products,sku,' . $id,
    ]);

    $product->update($request->all());

    return response()->json([
        'message' => "Produit mis à jour.",
        'product' => $product
    ]);
}


/**
 * Supprimer un produit (ADMIN)
 */
public function destroy(Request $request, $id)
{
    if ($request->user()->role->name !== 'Admin') {
        return response()->json(['message' => "Accès refusé."], 403);
    }

    $product = Product::find($id);
    if (!$product) {
        return response()->json(['message' => "Produit non trouvé."], 404);
    }

    // Vérifie si le produit est utilisé dans des commandes
    if ($product->orderItems()->exists()) {
        return response()->json([
            'message' => "Impossible de supprimer ce produit car il est déjà utilisé dans une commande."
        ], 400);
    }

    $product->delete();

    return response()->json(['message' => "Produit supprimé avec succès."]);
}

}
