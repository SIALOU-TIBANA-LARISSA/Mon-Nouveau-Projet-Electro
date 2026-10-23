@extends('layouts.admin')

@section('content')

<div class="max-w-3xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">
        Ajouter un exemple
    </h1>

    <form method="POST"
          action="{{ route('admin.examples.store') }}"
          enctype="multipart/form-data">

        @csrf

        <!-- Sélection produit -->
        <div class="mb-4">
            <label class="block mb-2 font-semibold">
                Produit concerné
            </label>

            <select name="product_id"
                    class="w-full border p-2 rounded"
                    required>
                <option value="">Choisir un produit</option>

                @foreach($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Image -->
        <div class="mb-4">
            <label class="block mb-2 font-semibold">
                Image exemple
            </label>

            <input type="file"
                   name="image"
                   class="w-full border p-2 rounded"
                   required>
        </div>

        <button class="bg-orange-500 text-white px-6 py-2 rounded">
            Enregistrer
        </button>

    </form>

</div>

@endsection
