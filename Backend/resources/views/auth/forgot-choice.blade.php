@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow mt-10 text-center">

    <h1 class="text-xl font-bold mb-6">Récupération du mot de passe</h1>

    <a href="/forgot-password"
       class="block bg-blue-500 text-white py-2 rounded mb-3">
        🔐 Réinitialiser par Email
    </a>

    <a href="/reset-sms"
       class="block bg-green-500 text-white py-2 rounded">
        📱 Réinitialiser par SMS
    </a>

</div>
@endsection