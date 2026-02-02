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
        return view('account.address');
    }

    public function preferences()
    {
        return view('account.preferences');
    }
}


