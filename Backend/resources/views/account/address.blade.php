@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">

    <h2 class="text-2xl font-bold mb-6">📍 Mes adresses</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('account.address.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium">Adresse</label>
            <input type="text" name="address"
                   value="{{ old('address', $user->address ?? '') }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Ville</label>
            <input type="text" name="city"
                   value="{{ old('city', $user->city ?? '') }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Quartier</label>
            <input type="text" name="district"
                   value="{{ old('district', $user->district ?? '') }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Téléphone</label>
            <input type="text" name="phone"
                   value="{{ old('phone', $user->phone ?? '') }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        <button type="submit"
                class="bg-orange-500 text-white px-4 py-2 rounded">
            Enregistrer
        </button>
    </form>

    <div class="mt-4">
        <a href="{{ route('account') }}" class="text-orange-500 hover:underline">
            ← Retour à mon compte
        </a>
    </div>

</div>
@endsection