@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Connexion</h1>

    <form method="POST" action="{{ route('login.web') }}">
        @csrf

        <input
            type="text"
            name="login"
            placeholder="Email ou numéro"
            class="w-full border p-2 mb-3 rounded"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Mot de passe"
            class="w-full border p-2 mb-3 rounded"
            required
        >

        <button
            type="submit"
            class="w-full bg-orange-500 text-white py-2 rounded">
            Se connecter
        </button>

        @if ($errors->any())
            <p class="text-red-500 mt-3">
                {{ $errors->first() }}
            </p>
        @endif

        <a href="/forgot-choice"
           class="text-sm text-orange-500 hover:underline block mt-3">
           Mot de passe oublié ?
        </a>

    </form>
</div>
@endsection