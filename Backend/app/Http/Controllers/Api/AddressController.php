<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Pour l’instant, on retourne un tableau vide
        // (on ajoutera la vraie logique après)
        return response()->json([]);
    }
}
