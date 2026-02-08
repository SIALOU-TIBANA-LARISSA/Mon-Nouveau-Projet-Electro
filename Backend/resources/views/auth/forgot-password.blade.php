@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow">

    <h2 class="text-xl font-semibold mb-4 text-center">
        Mot de passe oublié
    </h2>

    <p class="text-sm text-gray-600 mb-4 text-center">
        Entrez votre adresse email et nous vous enverrons
        un lien pour réinitialiser votre mot de passe.
    </p>

    {{-- Message succès --}}
    @if (session('status'))
        <div class="mb-4 text-green-600 text-sm text-center">
            {{ session('status') }}
        </div>
    @endif

    {{-- Erreur --}}
    @if ($errors->any())
        <div class="mb-4 text-red-600 text-sm text-center">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm mb-1">Adresse email</label>
            <input type="email"
                   name="email"
                   required
                   class="w-full border rounded px-3 py-2">
        </div>

        <button type="submit"
                class="w-full bg-orange-500 text-white py-2 rounded hover:bg-orange-600">
            Envoyer le lien
        </button>
    </form>

    <div class="mt-4 text-center">
        <a href="/login"
           class="text-sm text-gray-500 hover:underline">
           Retour à la connexion
        </a>
    </div>

</div>
@endsection
