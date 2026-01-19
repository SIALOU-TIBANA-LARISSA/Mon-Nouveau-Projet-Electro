@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">✏️ Modifier produit</h1>

<form method="POST"
action="{{ route('admin.products.update', $product) }}">
@csrf
@method('PUT')

<input name="name" value="{{ $product->name }}"
class="border p-2 w-full mb-3">

<input name="price" value="{{ $product->price }}"
class="border p-2 w-full mb-3">

<textarea name="description"
class="border p-2 w-full mb-3">{{ $product->description }}</textarea>

<button class="bg-blue-500 text-white px-4 py-2 rounded">
Modifier
</button>
</form>
@endsection
