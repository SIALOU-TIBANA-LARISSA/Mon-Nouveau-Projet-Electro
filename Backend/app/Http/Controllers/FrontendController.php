<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class FrontendController extends Controller
{
    // Page catalogue
public function catalogue(Request $request)
{
    $query = $request->q;

    $response = Http::get('https://mon-nouveau-projet-electro.onrender.com/api/products', [
        'search' => $query
    ]);

    if ($response->failed()) {
        abort(500, 'Erreur lors du chargement des produits');
    }

    // ✅ ON PREND UNIQUEMENT "data"
    $products = collect($response->json('data'));

    return view('catalog', compact('products'));
}

    // Page détails produit
    public function productDetails($id)
    {
        $response = Http::get("http://localhost:8001/api/products/$id");
        $product = $response->json();

        return view('product-details', compact('product'));
    }

    // Page de connexion
    public function loginPage()
    {
        return view('connexion');
    }

    // Traite la connexion API
    public function login(Request $request)
    {
        $response = Http::post('http://localhost:8001/api/auth/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->failed()) {
            return back()->with('error', 'Adresse ou mot de passe incorrect');
        }

        $data = $response->json();
        session(['token' => $data['token']]);

        return redirect()->route('catalogue');
    }
}

