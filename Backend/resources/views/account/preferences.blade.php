@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">

    <h1 class="text-2xl font-bold mb-6">
        📧 Préférences de communication
    </h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('account.preferences.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label class="block mb-2 font-medium">
                Newsletter
            </label>

            <label class="block mb-2">
                <input type="radio" name="newsletter" value="1"
                    {{ auth()->user()->newsletter ? 'checked' : '' }}>
                Je souhaite recevoir les offres promotionnelles
            </label>

            <label class="block">
                <input type="radio" name="newsletter" value="0"
                    {{ !auth()->user()->newsletter ? 'checked' : '' }}>
                Je ne souhaite plus recevoir les emails promotionnels
            </label>
        </div>

        <button type="submit"
            class="bg-orange-500 text-white px-4 py-2 rounded">
            Enregistrer
        </button>
    </form>

    <div class="mt-4">
        <a href="{{ route('account') }}"
           class="text-orange-500 hover:underline">
            ← Retour à mon compte
        </a>
    </div>

</div>
@endsection