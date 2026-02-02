@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">📧 Préférences de communication</h1>

    <div class="bg-white border rounded-lg p-6">
        <p class="text-gray-700 mb-4">
            Gérez vos préférences de communication par e-mail.
        </p>

        <div class="space-y-4">
            <label class="flex items-center gap-3">
                <input type="checkbox" checked disabled>
                <span>Recevoir les notifications de commande</span>
            </label>

            <label class="flex items-center gap-3">
                <input type="checkbox" disabled>
                <span>Recevoir les offres promotionnelles</span>
            </label>

            <label class="flex items-center gap-3">
                <input type="checkbox" disabled>
                <span>Recevoir les nouveautés produits</span>
            </label>
        </div>

        <p class="text-sm text-gray-500 mt-6">
            (La modification réelle sera ajoutée plus tard.)
        </p>
    </div>
</div>
@endsection

