@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">

    <h1 class="text-2xl font-bold mb-6">
        📦 Détails de la commande #{{ $order->id }}
    </h1>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between">
            <div>
                <p><strong>Référence :</strong> {{ $order->reference_number }}</p>
                <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y') }}</p>
            </div>

            <div class="text-right">
                <p class="text-lg font-bold text-orange-500">
                    {{ number_format($order->total_amount, 0, ',', ' ') }} FCFA
                </p>
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-sm
                    {{ $order->status === 'pending'
                        ? 'bg-yellow-100 text-yellow-700'
                        : 'bg-green-100 text-green-700' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
    </div>

    <h2 class="text-lg font-semibold mb-3">Produits commandés</h2>

    <div class="bg-white rounded-lg shadow divide-y">
        @foreach($order->items as $item)
            <div class="py-4 flex justify-between items-center px-4">
                <div>
                    <p class="font-medium">{{ $item->product->name }}</p>
                    <p class="text-sm text-gray-500">
                        Quantité : {{ $item->quantity }}
                    </p>
                </div>

                <div class="font-semibold">
                    {{ number_format($item->unit_price, 0, ',', ' ') }} FCFA
                </div>
            </div>
        @endforeach
    </div>

    <a href="{{ route('orders.index') }}">
     class="inline-block mt-6 text-orange-600 hover:underline">
        ← Retour à mes commandes
    </a>
</div>
@endsection

