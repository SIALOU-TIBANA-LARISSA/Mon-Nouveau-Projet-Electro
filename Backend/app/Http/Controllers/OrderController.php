<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // On affiche juste la page
        return view('orders.index');
    }

    public function show($id)
    {
        return view('orders.show');
    }
}

