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
        ]);

        Product::create([
    'name' => $request->name,
    'slug' => Str::slug($request->name),
    'price' => $request->price,
    'description' => $request->description,
    'category_id' => $request->category_id,
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
