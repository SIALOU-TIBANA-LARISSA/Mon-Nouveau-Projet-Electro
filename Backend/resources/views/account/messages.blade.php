@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">

    <h1 class="text-2xl font-bold mb-6">
        📬 Boîte de réception
    </h1>

    @forelse($messages as $message)
        <div class="bg-white shadow p-4 mb-4 rounded">

            <div class="flex justify-between items-center mb-2">
                <h3 class="font-semibold">
                    {{ $message->subject ?? 'Message' }}
                </h3>

                <span class="text-xs text-gray-500">
                    {{ $message->created_at->format('d/m/Y H:i') }}
                </span>
            </div>

            <p class="mb-2">
                {{ $message->content }}
            </p>

            @if($message->order)
                <p class="text-xs text-gray-400">
                    Commande : {{ $message->order->reference_number }}
                </p>
            @endif

            @if($message->is_from_admin)
                <span class="text-green-600 text-xs font-semibold">
                    Message de l'entreprise
                </span>
            @endif

        </div>
    @empty
        <div class="bg-gray-100 p-4 rounded">
            Aucun message pour le moment.
        </div>
    @endforelse

</div>
@endsection
