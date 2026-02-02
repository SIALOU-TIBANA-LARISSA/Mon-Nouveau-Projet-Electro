@extends('layouts.app')

@section('content')
@if (!isset($order))
    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
        <p class="text-red-500 font-semibold">
            Impossible d’afficher cette commande.
        </p>
        <a href="/my-orders" class="text-orange-500 hover:underline">
            ← Retour à mes commandes
        </a>
    </div>
    @php return; @endphp
@endif

<div class="max-w-5xl mx-auto px-4 py-8">

    <a href="/my-orders" class="text-orange-500 hover:underline mb-4 inline-block">
        ← Retour à vos commandes
    </a>

    <div class="bg-white border rounded-lg p-6 mb-6">
        <h1 class="text-2xl font-bold mb-2">
            Commande #{{ $order->id }}
        </h1>

        <p class="text-gray-600">
            Date : {{ $order->created_at->format('d/m/Y') }}
        </p>

        <p class="mt-2">
            Statut :
            <span class="font-semibold text-orange-600">
                {{ $order->status }}
            </span>
        </p>
    </div>

    <div class="bg-white border rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Produits commandés</h2>

        <div class="space-y-4">
            @foreach($order->items as $item)
                <div class="flex justify-between border-b pb-3">
                    <div>
                        <p class="font-semibold">
                            {{ $item->product->name }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Quantité : {{ $item->quantity }}
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="font-semibold">
                            {{ number_format($item->price * $item->quantity, 0, ',', ' ') }} FCFA
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 text-right text-xl font-bold">
            Total :
            {{ number_format($order->total_amount, 0, ',', ' ') }} FCFA
        </div>
    </div>

</div>
@endsection


