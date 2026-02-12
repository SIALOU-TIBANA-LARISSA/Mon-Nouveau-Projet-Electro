<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
       
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,avif|max:2048',
        ]);

    $imagePath = '/images/products/default.avif';

    if ($request->hasFile('image')) {

    $file = $request->file('image');

    $fileName = time() . '_' . $file->getClientOriginalName();

    $file->move(public_path('images/products'), $fileName);

    $imagePath = '/images/products/' . $fileName;
   }


        Product::create([
    'name' => $request->name,
    'slug' => Str::slug($request->name),
    'sku' => strtoupper(Str::random(8)), // ✅ génération automatique
    'price' => $request->price,
    'description' => $request->description,
    'category_id' => $request->category_id,
    'is_published' => true,
    'stock_quantity' => 10,
    'main_image_url' => $imagePath,


     ]);



        return redirect()->route('admin.products')
            ->with('success', 'Produit ajouté avec succès');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sku' => $product->sku ?? strtoupper(Str::random(8)),
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.products')
            ->with('success', 'Produit modifié avec succès');
    }

    public function destroy(Product $product)
    {
    if ($product->orderItems()->count() > 0) {
        return redirect()->route('admin.products')
            ->with('error', 'Impossible de supprimer ce produit car il est utilisé dans une commande.');
    }

    $product->delete();

    return redirect()->route('admin.products')
        ->with('success', 'Produit supprimé avec succès');
}


}
