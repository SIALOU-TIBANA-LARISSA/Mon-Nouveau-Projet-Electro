@extends('layouts.admin')

@section('content')

<div class="max-w-5xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">
        Exemples de personnalisation
    </h1>

    <a href="{{ route('admin.examples.create') }}"
       class="bg-orange-500 text-white px-4 py-2 rounded">
        Ajouter un exemple
    </a>

    <div class="grid grid-cols-3 gap-6 mt-6">
        @foreach($examples as $example)
            <div class="bg-white p-4 shadow rounded">
                <img src="{{ asset($example->image) }}" class="w-full rounded mb-3">

                <form method="POST" action="{{ route('admin.examples.destroy', $example->id) }}">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-500 text-white px-3 py-1 rounded">
                        Supprimer
                    </button>
                </form>
            </div>
        @endforeach
    </div>

</div>

@endsection
