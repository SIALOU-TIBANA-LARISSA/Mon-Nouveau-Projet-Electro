<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        Product::create($request->only('name', 'price', 'description'));

        return redirect()->route('admin.products')
            ->with('success', 'Produit ajouté');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->only('name', 'price', 'description'));

        return redirect()->route('admin.products')
            ->with('success', 'Produit modifié');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products')
            ->with('success', 'Produit supprimé');
    }
}

