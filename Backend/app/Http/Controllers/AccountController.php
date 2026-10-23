<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        return view('account');
    }

    public function addresses()
{
    $user = auth()->user();

    return view('account.address', compact('user'));
}

public function updateAddress(Request $request)
{
    $request->validate([
        'address' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:150',
        'district' => 'nullable|string|max:150',
        'phone' => 'nullable|string|max:50',
    ]);

    auth()->user()->update($request->only([
        'address',
        'city',
        'district',
        'phone'
    ]));

    return redirect()->route('account')
        ->with('success', 'Adresse mise à jour avec succès');
}

    public function preferences()
    {
        return view('account.preferences');
    }

    public function updatePreferences(Request $request)
{
    $request->validate([
        'newsletter' => 'required|in:0,1',
    ]);

    auth()->user()->update([
        'newsletter' => $request->newsletter,
    ]);

    return redirect()->route('account.preferences')
        ->with('success', 'Préférences mises à jour avec succès');
}
}



