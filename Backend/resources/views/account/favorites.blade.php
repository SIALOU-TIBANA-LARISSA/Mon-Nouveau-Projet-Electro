@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8">

<h1 class="text-2xl font-bold mb-6">❤️ Mes favoris</h1>

@if($favorites->count() == 0)

<p class="text-gray-600">
Vous n’avez ajouté aucun produit aux favoris.
</p>

@else

<div class="grid grid-cols-2 md:grid-cols-4 gap-6">

@foreach($favorites as $favorite)

<div class="bg-white shadow rounded p-4">

<img src="{{ asset($favorite->product->main_image_url) }}"
class="w-full h-40 object-contain mb-3">

<h3 class="font-semibold mb-2">
{{ $favorite->product->name }}
</h3>

<p class="text-orange-600 font-bold mb-2">
{{ number_format($favorite->product->price,0,',',' ') }} FCFA
</p>

<a href="{{ route('produit.slug', $favorite->product->slug) }}"
class="text-blue-500 underline">
Voir produit
</a>

</div>

@endforeach

</div>

@endif

</div>

@endsection
