@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8">

<h1 class="text-2xl font-bold mb-6">👀 Produits vus récemment</h1>

@php
$recent = session('recent_products', []);

$products = collect();

if(count($recent) > 0){
    $products = \App\Models\Product::whereIn('id',$recent)->get()
        ->sortByDesc(function($product) use ($recent){
            return array_search($product->id, $recent);
        });
}
@endphp

@if($products->count() == 0)

<p class="text-gray-600">
Vous n'avez consulté aucun produit récemment.
</p>

@else

<div class="grid grid-cols-2 md:grid-cols-4 gap-6">

@foreach($products as $product)

<div class="bg-white shadow rounded p-4">

<img src="{{ asset($product->main_image_url) }}"
class="w-full h-40 object-contain mb-3">

<h3 class="font-semibold mb-2">
{{ $product->name }}
</h3>

<p class="text-orange-600 font-bold mb-2">
{{ number_format($product->price,0,',',' ') }} FCFA
</p>

<a href="{{ route('product.details', $product->id) }}"
class="text-blue-500 underline">
Voir produit
</a>

</div>

@endforeach

</div>

@endif

</div>

@endsection