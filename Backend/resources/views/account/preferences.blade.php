@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">
        📧 Préférences de communication
    </h1>

    <p class="text-gray-600 mb-4">
        Gérez vos préférences de communication par e-mail.
    </p>

    <a href="{{ route('account') }}"
       class="text-orange-500 hover:underline">
        ← Retour à mon compte
    </a>
</div>
@endsection

