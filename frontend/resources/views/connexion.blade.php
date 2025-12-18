@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="max-w-md mx-auto mt-12">
    <h2 class="text-2xl font-bold mb-4">Connexion</h2>

    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 mb-4 rounded">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('login.action') }}">
        @csrf
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" required class="w-full border p-2 rounded" />
        </div>
        <div class="mb-3">
            <label>Mot de passe</label>
            <input type="password" name="password" required class="w-full border p-2 rounded" />
        </div>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded">Se connecter</button>
    </form>
</div>
@endsection
