@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">🧾 Liste des commandes</h1>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-3 text-left">ID</th>
            <th class="p-3 text-left">Total</th>
            <th class="p-3 text-left">Statut</th>
            <th class="p-3 text-left">Date</th>
            <th>Action</th>

        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <tr class="border-t">
                <td class="p-3">{{ $order->id }}</td>
                <td class="p-3">{{ $order->total_amount }} FCFA </td>
                <td class="p-3">
    @if($order->status === 'paid')
        <span class="px-3 py-1 text-sm font-semibold text-green-700 bg-green-100 rounded-full">
            Payée
        </span>
    @else
        <span class="px-3 py-1 text-sm font-semibold text-yellow-700 bg-yellow-100 rounded-full">
            En attente
        </span>
    @endif
</td>

                <td class="p-3 text-gray-500">
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
@endsection
