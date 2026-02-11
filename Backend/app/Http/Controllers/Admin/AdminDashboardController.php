<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class AdminDashboardController extends Controller
{
    public function index()
    {
    $stats = [
        'total_orders'   => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'paid_orders'    => Order::where('status', 'paid')->count(),
            'products'       => Product::count(),
            'users'          => User::count(),
            
    ];


    $users = User::latest()->take(5)->get();
    return view('admin.dashboard', compact('stats', 'users'));
}


public function destroy(Order $order)
{
    $order->delete();
    return redirect()->route('admin.orders')
        ->with('success', 'Commande supprimée avec succès');
}

public function create()
{
    $categories = Category::all();
    return view('admin.products.create', compact('categories'));
}

public function store(Request $request)
{
    Product::create([
        'name' => $request->name,
        'price' => $request->price,
        'description' => $request->description,
        'category_id' => $request->category_id,
    ]);

    return redirect()->route('admin.products')
        ->with('success', 'Produit ajouté avec succès');
}


}

