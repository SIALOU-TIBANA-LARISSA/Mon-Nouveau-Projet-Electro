@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">➕ Ajouter un produit</h1>

<form method="POST" action="{{ route('admin.products.store') }}">
@csrf

<input name="name" placeholder="Nom"
class="border p-2 w-full mb-3">

<input name="price" placeholder="Prix"
class="border p-2 w-full mb-3">

<textarea name="description"
class="border p-2 w-full mb-3"
placeholder="Description"></textarea>

<button class="bg-green-500 text-white px-4 py-2 rounded">
Enregistrer
</button>
</form>
@endsection
