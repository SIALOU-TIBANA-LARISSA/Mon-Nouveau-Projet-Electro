<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

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
}
