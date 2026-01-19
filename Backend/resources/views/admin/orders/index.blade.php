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
                <td class="p-3">{{ $order->status }}</td>
                <td class="p-3">{{ $order->created_at }}</td>
                
                <td><a href="{{ route('admin.orders.show', $order->id) }}"
       class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
        Voir
    </a>
</td>

            </tr>
        @endforeach
    </tbody>
</table>
@endsection
