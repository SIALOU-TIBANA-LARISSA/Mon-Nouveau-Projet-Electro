@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8">

<h1 class="text-2xl font-bold mb-6">Mes avis</h1>

@if($reviews->count() == 0)

<p class="text-gray-600">
Vous n’avez écrit aucun avis.
</p>

@else

@foreach($reviews as $review)

<div class="border-b py-4">

<h3 class="font-semibold">
{{ $review->product->name }}
</h3>

<div class="text-yellow-500">

@for($i=1;$i<=5;$i++)

@if($i <= $review->rating)
⭐
@else
☆
@endif

@endfor

</div>

<p class="text-gray-700">
{{ $review->comment }}
</p>

</div>

@endforeach

@endif

</div>

@endsection
