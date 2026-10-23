@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-bold mb-6">➕ Ajouter un produit</h1>

@if ($errors->any())
    <div class="bg-red-200 text-red-800 p-4 mb-4 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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

           <label class="block font-semibold mb-2">Prix promo (optionnel)</label>

<input type="number"
       name="promo_price"
       step="0.01"
       placeholder="Ex: 7000"
       class="border p-2 w-full mb-3">

           <label class="block font-semibold mb-2">Quantité en stock</label>

<input type="number"
       name="stock_quantity"
       value="10"
       class="border p-2 w-full mb-3"
       min="0"
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

   <label class="block font-semibold mb-2">Images d'exemple</label>

   <input type="file"
       name="examples[]"
       multiple
       class="border p-2 w-full mb-4">
  

       <hr class="my-6">

<h2 class="text-lg font-bold mb-4">⚙️ Fichiers de fabrication</h2>

<label class="block font-semibold mb-2">
    Fichier STL (Impression 3D)
</label>

<input type="file"
       name="stl_file"
       accept=".stl"
       class="border p-2 w-full mb-4">

<label class="block font-semibold mb-2">
    Fichier SVG (Découpe Laser)
</label>

<input type="file"
       name="svg_file"
       accept=".svg"
       class="border p-2 w-full mb-4">

       <label class="block font-semibold mb-2">
    Fichier DXF (Découpe technique)
</label>

<input type="file"
       name="dxf_file"
       accept=".dxf"
       class="border p-2 w-full mb-4">

    <button type="submit"
            class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
        Enregistrer
    </button>

</form>

@endsection
