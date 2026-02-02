@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">

    <h1 class="text-2xl font-bold mb-6">📦 Détails de la commande</h1>

    {{-- Infos commande --}}
    <div class="bg-white border rounded-lg p-6 mb-6">
        <p><strong>Commande :</strong> #{{ $order->id }}</p>
        <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y') }}</p>
        <p>
            <strong>Total :</strong>
            <span class="text-orange-500 font-bold">
                {{ number_format($order->total_amount, 0, ',', ' ') }} FCFA
            </span>
        </p>
        <p><strong>Statut :</strong> {{ ucfirst($order->status) }}</p>
    </div>

    {{-- Produits --}}
    <h2 class="text-xl font-semibold mb-4">🛍 Produits commandés</h2>

    @forelse ($order->items as $item)
        <div class="flex gap-4 items-center bg-gray-50 p-4 rounded mb-3">
            <img src="{{ asset(ltrim($item->product->main_image_url, '/')) }}"
                 class="w-20 h-20 object-cover rounded">

            <div>
                <p class="font-semibold">{{ $item->product->name }}</p>
                <p>Quantité : {{ $item->quantity }}</p>
                <p>Prix : {{ number_format($item->price, 0, ',', ' ') }} FCFA</p>
            </div>
        </div>
    @empty
        <p class="text-gray-500">Aucun produit trouvé pour cette commande.</p>
    @endforelse

    <a href="/my-orders" class="inline-block mt-6 text-orange-500 hover:underline">
        ← Retour à mes commandes
    </a>

</div>
@endsection
