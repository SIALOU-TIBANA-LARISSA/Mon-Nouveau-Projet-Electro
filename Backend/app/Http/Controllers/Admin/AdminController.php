<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_orders'   => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'paid_orders'    => Order::where('status', 'paid')->count(),
            'products'       => Product::count(),
            'users'          => User::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
