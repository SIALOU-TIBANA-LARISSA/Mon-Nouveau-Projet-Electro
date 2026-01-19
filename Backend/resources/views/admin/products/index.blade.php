@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">📦 Produits</h1>

<a href="{{ route('admin.products.create') }}"
class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">
➕ Ajouter un produit
</a>

<table class="w-full bg-white shadow rounded">
<thead class="bg-gray-200">
<tr>
    <th class="p-3">Nom</th>
    <th class="p-3">Prix</th>
    <th class="p-3">Actions</th>
</tr>
</thead>

<tbody>
@foreach($products as $product)
<tr class="border-t">
    <td class="p-3">{{ $product->name }}</td>
    <td class="p-3">{{ $product->price }} FCFA</td>
    <td class="p-3 flex gap-2">

        <a href="{{ route('admin.products.edit', $product) }}"
        class="bg-blue-500 text-white px-3 py-1 rounded">
        ✏️ Modifier
        </a>

        <form method="POST"
              action="{{ route('admin.products.destroy', $product) }}">
            @csrf
            @method('DELETE')
            <button class="bg-red-500 text-white px-3 py-1 rounded">
                🗑 Supprimer
            </button>
        </form>

    </td>
</tr>
@endforeach
</tbody>
</table>
@endsection

