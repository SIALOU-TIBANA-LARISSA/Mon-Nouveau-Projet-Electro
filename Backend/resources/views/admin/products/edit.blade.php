@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">✏️ Modifier produit</h1>

{{-- 🔴 IMAGES EXEMPLES (EN DEHORS DU FORMULAIRE PRINCIPAL) --}}
@if($product->examples->count())

    <div class="grid grid-cols-3 gap-4 mb-6">

        @foreach($product->examples as $example)

            <div class="border p-2 rounded shadow">

                <img src="{{ asset($example->image_path) }}"
                     class="h-24 w-full object-cover mb-2 rounded">

                <form method="POST"
                      action="{{ route('admin.products.examples.delete', $example->id) }}">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="bg-red-500 text-white px-2 py-1 rounded text-sm">
                        Supprimer
                    </button>
                </form>

            </div>

        @endforeach

    </div>

@endif


{{-- 🟢 FORMULAIRE PRINCIPAL --}}
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

           <label class="block font-semibold mb-2">Prix promo</label>

<input type="number"
       name="promo_price"
       value="{{ $product->promo_price }}"
       step="0.01"
       placeholder="Ex: 7000"
       class="border p-2 w-full mb-3">

<label class="block font-semibold mb-2">SKU</label>
<input type="text"
       name="sku"
       value="{{ $product->sku }}"
       class="border p-2 w-full mb-3"
       required>

        <label class="block font-semibold mb-2">Quantité en stock</label>
<input type="number"
       name="stock_quantity"
       value="{{ $product->stock_quantity }}"
       class="border p-2 w-full mb-3"
       min="0"
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

    <label class="block font-semibold mb-2 mt-4">
        Image principale actuelle
    </label>

    @if($product->main_image_url)
        <img src="{{ asset($product->main_image_url) }}"
             class="h-32 mb-3 rounded shadow">
    @endif

    <input type="file"
           name="main_image"
           class="border p-2 w-full mb-4">

    <label class="block font-semibold mb-2 mt-4">
        Ajouter des images d'exemple
    </label>

    <input type="file"
           name="examples[]"
           multiple
           class="border p-2 w-full mb-4">


    {{-- 🔵 FICHIERS DE FABRICATION (DÉPLACÉS ICI CORRECTEMENT) --}}
    <hr class="my-6">

    <h2 class="text-lg font-bold mb-4">⚙️ Fichiers de fabrication</h2>

    <label class="block font-semibold mb-2">
        Fichier STL actuel
    </label>

    @if($product->stl_path)
        <p class="text-green-600 text-sm mb-2">
            {{ $product->stl_path }}
        </p>
    @endif

    <input type="file"
           name="stl_file"
           accept=".stl"
           class="border p-2 w-full mb-4">

    <label class="block font-semibold mb-2">
        Fichier SVG actuel
    </label>

    @if($product->svg_path)
        <p class="text-green-600 text-sm mb-2">
            {{ $product->svg_path }}
        </p>
    @endif

    <input type="file"
           name="svg_file"
           accept=".svg"
           class="border p-2 w-full mb-4">

           <label class="block font-semibold mb-2">
    Fichier DXF actuel
</label>

@if($product->dxf_path)
    <p class="text-green-600 text-sm mb-2">
        {{ $product->dxf_path }}
    </p>
@endif

<input type="file"
       name="dxf_file"
       accept=".dxf"
       class="border p-2 w-full mb-4">


    <button type="submit"
            class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
        Enregistrer les modifications
    </button>

</form>

@endsection