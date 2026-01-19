@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">
    🧾 Commande #{{ $order->id }}
</h1>

<div class="bg-white shadow rounded p-6 mb-6">
    <p><strong>Client :</strong> {{ $order->user->name ?? 'Invité' }}</p>
    <p><strong>Email :</strong> {{ $order->user->email ?? '-' }}</p>
    <p><strong>Total :</strong> {{ $order->total_amount }} FCFA</p>
    <p><strong>Statut :</strong> {{ $order->status }}</p>
    <p><strong>Date :</strong> {{ $order->created_at }}</p>
</div>

<h2 class="text-xl font-bold mb-4">📦 Produits commandés</h2>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-3 text-left">Produit</th>
            <th class="p-3 text-left">Prix</th>
            <th class="p-3 text-left">Quantité</th>
            <th class="p-3 text-left">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $item)
            <tr class="border-t">
                <td class="p-3">
                    {{ $item->product->name ?? 'Produit supprimé' }}
                </td>
                <td class="p-3">{{ $item->unit_price }} FCFA</td>
                <td class="p-3">{{ $item->quantity }}</td>
                <td class="p-3">
                    {{ $item->unit_price * $item->quantity }} FCFA
                </td>
            </tr>
        @endforeach
    </tbody>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<form method="POST"
      action="{{ route('admin.orders.updateStatus', $order->id) }}"
      class="bg-white shadow rounded p-4 mb-6">

    @csrf
    @method('PUT')

    <label class="block mb-2 font-semibold">Changer le statut</label>

    <select name="status" class="border p-2 rounded w-64">
        <option value="pending"   @selected($order->status === 'pending')>
            En attente
        </option>
        <option value="paid" @selected($order->status === 'paid')>
            Payée
        </option>
        <option value="delivered" @selected($order->status === 'delivered')>
            Livrée
        </option>
        <option value="cancelled" @selected($order->status === 'cancelled')>
            Annulée
        </option>
    </select>

    <button type="submit"
        class="ml-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Mettre à jour
    </button>
</form>



</table>

<a href="{{ route('admin.orders') }}"
   class="inline-block mt-6 bg-gray-500 text-white px-4 py-2 rounded">
   ← Retour à la liste
</a>

@endsection
