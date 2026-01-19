<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    /**
     * PAGE CATALOGUE (publique)
     */
    public function index(Request $request)
    {
        $response = Http::get(
            'http://127.0.0.1:8001/api/products',
            [
                'page' => $request->get('page', 1),
                'per_page' => 12
            ]
        );

        if ($response->failed()) {
            abort(500);
        }

        $data = $response->json();

        return view('catalog', [
            'products' => $data['data'],
            'pagination' => $data
        ]);
    }

    /**
     * PAGE DÉTAIL PRODUIT (publique)
     */
    public function show(string $id)
    {
        $response = Http::get("http://127.0.0.1:8001/api/products/{$id}");

        if ($response->failed()) {
            abort(404);
        }

        return view('products.show', [
            'product' => $response->json()
        ]);
    }
}
