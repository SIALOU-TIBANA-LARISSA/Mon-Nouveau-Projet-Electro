@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">🧾 Liste des commandes</h1>

<div class="overflow-x-auto overflow-y-auto max-h-[500px]">
<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-3 text-left">ID</th>
            <th class="p-3 text-left">Client</th>
            <th class="p-3 text-left">Téléphone</th>
            <th class="p-3 text-left">Email</th>
            <th class="p-3 text-left">Total</th>
            <th class="p-3 text-left">Statut</th>
            <th class="p-3 text-left">Date</th>
            <th class="p-3 text-left">Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($orders as $order)
        <tr class="border-t">
            <td class="p-3">{{ $order->id }}</td>

            <!-- CLIENT -->
            <td class="p-3">
                {{ $order->user->name ?? '-' }}
            </td>

            <!-- TELEPHONE -->
    <td class="p-3">
@if($order->user && $order->user->phone)

    @php
        $cleanPhone = preg_replace('/\D/', '', $order->user->phone);
    @endphp

    <a href="https://wa.me/{{ $cleanPhone }}"
       target="_blank"
       class="text-green-600 font-semibold hover:underline">
        {{ $order->user->phone }}
    </a>

@else
    -
@endif
</td>

            <td class="p-3">
@if($order->user && $order->user->email)
    <a href="mailto:{{ $order->user->email }}"
       class="text-blue-600 hover:underline">
        {{ $order->user->email }}
    </a>
@else
    -
@endif
</td>

            <td class="p-3 whitespace-nowrap">
                {{ number_format($order->total_amount, 0, ',', ' ') }} FCFA
            </td>

<td class="p-3 whitespace-nowrap">

    @if($order->status === 'paid')
        <span class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold text-green-700 bg-green-100 rounded-full">
            ✔ Payée
        </span>

    @elseif($order->status === 'pending')
        <span class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold text-orange-700 bg-orange-100 rounded-full">
            ⏳ En attente
        </span>

    @elseif($order->status === 'delivered')
        <span class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold text-blue-700 bg-blue-100 rounded-full">
            🚚 Livrée
        </span>

    @elseif($order->status === 'cancelled')
        <span class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold text-red-700 bg-red-100 rounded-full">
            ❌ Annulée
        </span>

    @else
        <span class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold text-gray-700 bg-gray-100 rounded-full">
            {{ ucfirst($order->status) }}
        </span>
    @endif

</td>
            
            <td class="p-3 whitespace-nowrap text-gray-500">
                {{ $order->created_at->format('d/m/Y H:i') }}
            </td>

            <td class="p-3">
                <div class="flex gap-2">
                    <a href="{{ route('admin.orders.show', $order->id) }}"
                       class="px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600">
                        Voir
                    </a>

                    <form method="POST" action="{{ route('admin.orders.destroy', $order->id) }}">
                        @csrf
                        @method('DELETE')
                        <button
                            class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600"
                            onclick="return confirm('Supprimer cette commande ?')">
                            Supprimer
                        </button>
                    </form>
                </div>
            </td>

        </tr>
        @endforeach
    </tbody>
    </table>
    </div>

@endsection