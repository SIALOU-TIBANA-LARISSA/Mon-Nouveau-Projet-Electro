<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Favorite;
use App\Models\Review;

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
            'main_image' => 'nullable|image|mimes:jpg,jpeg,png,avif|max:8192',
            'sku' => 'required|string|unique:products,sku|max:50',
            'stl_file' => 'nullable|mimes:stl|max:10240',
            'svg_file' => 'nullable|mimes:svg|max:10240',
            'dxf_file' => 'nullable|mimes:dxf|max:10240',
        ]);

        // 2. Création du slug à partir du nom
        $slug = Str::slug($validatedData['name']);
        
        // Assurer l'unicité du slug
        $originalSlug = $slug;
        $count = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }



        $imagePath = null;

if ($request->hasFile('main_image')) {

    $image = $request->file('main_image');
    $imageName = time() . '.' . $image->getClientOriginalExtension();
    $image->move(public_path('images/products'), $imageName);

    $imagePath = 'images/products/' . $imageName;
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
            'main_image_url' => $imagePath,
            'sku' => $product->sku,
        ]);


        // 🔹 GESTION STL
if ($request->hasFile('stl_file')) {

    $stl = $request->file('stl_file');
    $stlName = time() . '_stl.' . $stl->getClientOriginalExtension();
    $stl->move(public_path('stl'), $stlName);

    $product->stl_path = 'stl/' . $stlName;
}

// 🔹 GESTION SVG
if ($request->hasFile('svg_file')) {

    $svg = $request->file('svg_file');
    $svgName = time() . '_svg.' . $svg->getClientOriginalExtension();
    $svg->move(public_path('svg'), $svgName);

    $product->svg_path = 'svg/' . $svgName;
}

// 🔹 GESTION DXF
if ($request->hasFile('dxf_file')) {

    $dxf = $request->file('dxf_file');
    $dxfName = time() . '_dxf.' . $dxf->getClientOriginalExtension();
    $dxf->move(public_path('dxf'), $dxfName);

    $product->dxf_path = 'dxf/' . $dxfName;
}

$product->save();

        // 4. Réponse
return response()->json([
    'message' => 'Produit mis à jour avec succès.',
    'product' => $product->load('category')
]);
        
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
    $product = Product::with(['category','examples'])->findOrFail($id);


    // ⭐ Enregistrer produit vu récemment
    $recent = session()->get('recent_products', []);

    if (!in_array($id, $recent)) {
        $recent[] = $id;
    }
session()->put('recent_products', array_slice($recent, -5));
    $reviews = \App\Models\Review::where('product_id', $id)
        ->latest()
        ->get();

        $similarProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->where('is_published', true)
        ->limit(4)
        ->get();

    return view('product-details', compact('product','reviews','similarProducts'));
}



public function showBySlug(string $slug)
{
    $product = Product::where('slug', $slug)
        ->where('is_published', true)
        ->with(['category','examples'])
        ->firstOrFail();

        // ⭐ enregistrer produit vu
    $recent = session()->get('recent_products', []);

    if (!in_array($product->id, $recent)) {
        $recent[] = $product->id;
    }

    session()->put('recent_products', array_slice($recent, -5));

    $reviews = \App\Models\Review::where('product_id',$product->id)
        ->latest()
        ->get();

$similarProducts = \App\Models\Product::where('category_id', $product->category_id)
    ->where('id', '!=', $product->id)
    ->where('is_published', true)
    ->limit(4)
    ->get();

    return view('product-details', compact('product','reviews','similarProducts'));
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
            'main_image' => 'nullable|image|mimes:jpg,jpeg,png,avif|max:8192',
            // Le SKU doit être unique, SAUF pour le produit actuel que nous modifions
            'sku' => ['required', 'string', 'max:50', Rule::unique('products', 'sku')->ignore($product->id)],
            'stl_file' => 'nullable|mimes:stl|max:10240',
            'svg_file' => 'nullable|mimes:svg|max:10240',
        ]);

        $product->save(); 
        
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


        // GESTION IMAGE PRINCIPALE
if ($request->hasFile('main_image')) {

    // Supprimer ancienne image si elle existe
    if ($product->main_image_url && file_exists(public_path($product->main_image_url))) {
        unlink(public_path($product->main_image_url));
    }

    $image = $request->file('main_image');
    $imageName = time() . '.' . $image->getClientOriginalExtension();
    $image->move(public_path('images/products'), $imageName);

    $product->main_image_url = 'images/products/' . $imageName;
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
            'main_image_url' => $product->main_image_url,
            'sku' => $validatedData['sku'],
        ]);

     // 🔹 GESTION STL UPDATE
if ($request->hasFile('stl_file')) {

    if ($product->stl_path && file_exists(public_path($product->stl_path))) {
        unlink(public_path($product->stl_path));
    }

    $stl = $request->file('stl_file');
    $stlName = time() . '_stl.' . $stl->getClientOriginalExtension();
    $stl->move(public_path('stl'), $stlName);

    $product->stl_path = 'stl/' . $stlName;
}

// 🔹 GESTION SVG UPDATE
if ($request->hasFile('svg_file')) {

    if ($product->svg_path && file_exists(public_path($product->svg_path))) {
        unlink(public_path($product->svg_path));
    }

    $svg = $request->file('svg_file');
    $svgName = time() . '_svg.' . $svg->getClientOriginalExtension();
    $svg->move(public_path('svg'), $svgName);

    $product->svg_path = 'svg/' . $svgName;
}


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
    public function deleteStl($slug)
{
    $product = Product::where('slug', $slug)->firstOrFail();

    if ($product->stl_path && file_exists(public_path($product->stl_path))) {
        unlink(public_path($product->stl_path));
    }

    $product->stl_path = null;
    $product->save();

    return back();
}

public function deleteSvg($slug)
{
    $product = Product::where('slug', $slug)->firstOrFail();

    if ($product->svg_path && file_exists(public_path($product->svg_path))) {
        unlink(public_path($product->svg_path));
    }

    $product->svg_path = null;
    $product->save();

    return back();
}

public function deleteExample($id)
{
    $example = \App\Models\ProductExample::findOrFail($id);

    if ($example->image_path && file_exists(public_path($example->image_path))) {
        unlink(public_path($example->image_path));
    }

    $example->delete();

    return back();
}


public function addFavorite($productId)
{
    Favorite::firstOrCreate([
        'user_id' => auth()->id(),
        'product_id' => $productId
    ]);

    return back()->with('success','Produit ajouté aux favoris');
}


public function storeReview(Request $request, $productId)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|max:1000'
    ]);

    Review::create([
        'user_id' => auth()->id(),
        'product_id' => $productId,
        'rating' => $request->rating,
        'comment' => $request->comment
    ]);

    return back()->with('success', 'Avis ajouté avec succès');
}


}
