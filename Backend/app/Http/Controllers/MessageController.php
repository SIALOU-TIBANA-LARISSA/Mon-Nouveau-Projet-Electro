<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = auth()->user()
            ->messages()
            ->latest()
            ->get();

        return view('account.messages', compact('messages'));
    }
}