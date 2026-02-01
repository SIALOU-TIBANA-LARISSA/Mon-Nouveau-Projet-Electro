@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">📦 Vos commandes</h1>

    @if($orders->isEmpty())
        <p class="text-gray-600">Aucune commande pour le moment.</p>
    @else
        @foreach($orders as $order)
            <div class="bg-white shadow rounded p-5 mb-4">
                <h2 class="font-bold text-lg">
                    Commande #{{ $order->id }}
                </h2>

                <p class="text-gray-500">
                    {{ $order->created_at->format('d/m/Y') }}
                </p>

                <p class="font-bold text-orange-500 mt-2">
                    {{ number_format($order->total_amount, 0, ',', ' ') }} FCFA
                </p>

                <span class="inline-block mt-2 px-3 py-1 text-sm rounded
                    {{ $order->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                    {{ strtoupper($order->status) }}
                </span>

                <div class="mt-4">
                    <a href="{{ url('/my-orders/'.$order->id) }}"
                       class="inline-block bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
                        Voir les détails
                    </a>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
