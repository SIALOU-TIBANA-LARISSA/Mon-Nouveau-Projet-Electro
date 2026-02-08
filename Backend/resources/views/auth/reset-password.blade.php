@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">

    <h2 class="text-xl font-semibold mb-4 text-center">
        Réinitialiser le mot de passe
    </h2>

    @if ($errors->any())
        <div class="mb-4 text-red-500 text-sm text-center">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-4">
            <label class="block text-sm mb-1">Adresse email</label>
            <input type="email"
                   name="email"
                   required
                   class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1">Nouveau mot de passe</label>
            <input type="password"
                   name="password"
                   required
                   class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1">Confirmer le mot de passe</label>
            <input type="password"
                   name="password_confirmation"
                   required
                   class="w-full border px-3 py-2 rounded">
        </div>

        <button type="submit"
                class="w-full bg-orange-500 text-white py-2 rounded">
            Réinitialiser
        </button>
    </form>

</div>
@endsection
