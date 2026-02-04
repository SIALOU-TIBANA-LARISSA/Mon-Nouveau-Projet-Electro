<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

    /**
     * Display a listing of the resource.
     * Accessible par tous les utilisateurs (publique).
     */
    

class ProductController extends Controller
{


public function catalogue(Request $request)
{
    $query = Product::where('is_published', true);

    // 🔹 Filtrage par catégorie (via slug)
    if ($request->filled('category')) {
        $category = Category::where('slug', $request->category)->first();

        if ($category) {
            $query->where('category_id', $category->id);
        }
    }

    $products = $query->paginate(12);

    return view('catalog', [
        'products' => $products,
        'pagination' => [
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
        ]
    ]);
}


    /**
     * Store a newly created resource in storage.
     * Protégé par le middleware Role:Admin
     */
    public function store(Request $request)
    {
        // 1. Validation des données
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Assure que la catégorie existe
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0.01',
            'stock_quantity' => 'required|integer|min:0',
            'is_published' => 'boolean',
            'main_image_url' => 'nullable|url',
            'sku' => 'required|string|unique:products,sku|max:50',
        ]);

        // 2. Création du slug à partir du nom
        $slug = Str::slug($validatedData['name']);
        
        // Assurer l'unicité du slug
        $originalSlug = $slug;
        $count = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        // 3. Création du produit
        $product = Product::create([
            'name' => $validatedData['name'],
            'slug' => $slug,
            'category_id' => $validatedData['category_id'],
            'description' => $validatedData['description'] ?? null,
            'price' => $validatedData['price'],
            'stock_quantity' => $validatedData['stock_quantity'],
            'is_published' => $validatedData['is_published'] ?? false,
            'main_image_url' => $validatedData['main_image_url'] ?? null,
            'sku' => $validatedData['sku'],
        ]);

        // 4. Réponse
        return response()->json([
            'message' => 'Produit créé avec succès.',
            'product' => $product->load('category')
        ], 201);
    }

    /**
     * Display the specified resource.
     * Accessible par tous (publique).
     */
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->with('category')->first();

        if (!$product) {
            return response()->json(['message' => 'Produit non trouvé.'], 404);
        }

        return response()->json($product);
    }


    public function showPage(int $id)
{
    $product = Product::with('category')->findOrFail($id);

    return view('product-details', compact('product'));
}

    /**
     * Update the specified resource in storage.
     * Protégé par le middleware Role:Admin
     */
    public function update(Request $request, string $slug)
    {
        $product = Product::where('slug', $slug)->first();

        if (!$product) {
            return response()->json(['message' => 'Produit non trouvé.'], 404);
        }

        // 1. Validation des données
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0.01',
            'stock_quantity' => 'required|integer|min:0',
            'is_published' => 'boolean',
            'main_image_url' => 'nullable|url',
            // Le SKU doit être unique, SAUF pour le produit actuel que nous modifions
            'sku' => ['required', 'string', 'max:50', Rule::unique('products', 'sku')->ignore($product->id)],
        ]);

        // 2. Mise à jour du slug si le nom a changé
        $newSlug = Str::slug($validatedData['name']);
        
        // Si le nouveau slug est différent de l'ancien, on s'assure qu'il est unique
        if ($newSlug !== $product->slug) {
            $originalSlug = $newSlug;
            $count = 1;
            while (Product::where('slug', $newSlug)->where('id', '!=', $product->id)->exists()) {
                $newSlug = $originalSlug . '-' . $count++;
            }
        }
        
        // 3. Mise à jour du produit
        $product->update([
            'name' => $validatedData['name'],
            'slug' => $newSlug,
            'category_id' => $validatedData['category_id'],
            'description' => $validatedData['description'] ?? $product->description,
            'price' => $validatedData['price'],
            'stock_quantity' => $validatedData['stock_quantity'],
            'is_published' => $validatedData['is_published'] ?? $product->is_published,
            'main_image_url' => $validatedData['main_image_url'] ?? $product->main_image_url,
            'sku' => $validatedData['sku'],
        ]);

        // 4. Réponse
        return response()->json([
            'message' => 'Produit mis à jour avec succès.',
            'product' => $product->load('category')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * Protégé par le middleware Role:Admin
     */
    public function destroy(string $slug)
    {
        $product = Product::where('slug', $slug)->first();

        if (!$product) {
            return response()->json(['message' => 'Produit non trouvé.'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Produit supprimé avec succès.']);
    }
}
