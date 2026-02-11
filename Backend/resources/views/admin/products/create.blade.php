@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-bold mb-6">➕ Ajouter un produit</h1>

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf

    <input name="name"
           placeholder="Nom"
           class="border p-2 w-full mb-3"
           required>

    <input name="price"
           type="number"
           step="0.01"
           placeholder="Prix"
           class="border p-2 w-full mb-3"
           required>

    <textarea name="description"
              class="border p-2 w-full mb-3"
              placeholder="Description"
              required></textarea>

    <select name="category_id"
            class="border p-2 w-full mb-4"
            required>
        <option value="">-- Choisir une catégorie --</option>

        @foreach($categories as $category)
            <option value="{{ $category->id }}">
                {{ $category->name }}
            </option>
        @endforeach
    </select>
   
    <input type="file" name="image" class="border p-2 w-full mb-3">

    <button type="submit"
            class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
        Enregistrer
    </button>

</form>

@endsection
