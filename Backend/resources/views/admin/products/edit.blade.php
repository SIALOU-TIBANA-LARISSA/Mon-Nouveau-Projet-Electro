@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">✏️ Modifier produit</h1>

<form method="POST"
      action="{{ route('admin.products.update', $product) }}"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <input name="name"
           value="{{ $product->name }}"
           class="border p-2 w-full mb-3"
           required>

    <input name="price"
           type="number"
           step="0.01"
           value="{{ $product->price }}"
           class="border p-2 w-full mb-3"
           required>

    <textarea name="description"
              class="border p-2 w-full mb-3"
              required>{{ $product->description }}</textarea>

    <select name="category_id"
            class="border p-2 w-full mb-4"
            required>

        @foreach($categories as $category)
            <option value="{{ $category->id }}"
                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach

    </select>

    <button type="submit"
            class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
        Enregistrer les modifications
    </button>

</form>
@endsection

