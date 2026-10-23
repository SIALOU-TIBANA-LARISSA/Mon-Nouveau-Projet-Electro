@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow mt-10">

    <h1 class="text-xl font-bold mb-4">Réinitialiser mot de passe (SMS)</h1>

    <div id="step1">
        <input id="phone" type="text"
               placeholder="Numéro (22507XXXXXXXX)"
               class="w-full border p-2 mb-3 rounded">

        <button onclick="sendCode()"
                class="w-full bg-blue-500 text-white py-2 rounded">
            Envoyer le code
        </button>
    </div>

    <form id="step2" class="hidden mt-4" onsubmit="resetPassword(event)">
        <input id="code" type="text"
               placeholder="Code reçu"
               class="w-full border p-2 mb-3 rounded">

               
        <div class="relative mb-3">
    <input id="password" type="password"
       placeholder="Nouveau mot de passe"
       class="w-full border p-2 rounded pr-10"
       required>

    <span onclick="togglePassword('password')"
          class="absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer text-gray-500">
        👁
    </span>
</div>

<div class="relative mb-3">
    <input id="password_confirmation" type="password"
       placeholder="Confirmer mot de passe"
       class="w-full border p-2 rounded pr-10"
       required>

    <span onclick="togglePassword('password_confirmation')"
          class="absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer text-gray-500">
        👁
    </span>
</div>
        <button type="submit"
        class="w-full bg-green-500 text-white py-2 rounded">
    Réinitialiser
</button>

    <p id="message" class="mt-3 text-sm"></p>

</form>

<script>

function sendCode() {
    fetch('/api/auth/forgot-password', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            phone: document.getElementById('phone').value
        })
    })
    .then(res => res.json())
    .then(data => {
        const msg = document.getElementById('message');
        msg.innerText = data.message;

        if (data.message.includes("Code")) {

    // ❌ Cacher la première partie
    document.getElementById('step1').classList.add('hidden');

    // ✅ Afficher la deuxième partie
    document.getElementById('step2').classList.remove('hidden');
}
    });
}

function resetPassword(event) {
    event.preventDefault();
    fetch('/api/auth/reset-password', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            phone: document.getElementById('phone').value,
            code: document.getElementById('code').value,
            password: document.getElementById('password').value,
            password_confirmation: document.getElementById('password_confirmation').value
        })
    })
    .then(res => res.json())
    .then(data => {
        const msg = document.getElementById('message');
        msg.innerText = data.message;

        if (data.message.includes("succès")) {

    // 🔥 Nettoyer les champs
    document.getElementById('phone').value = "";
    document.getElementById('code').value = "";
    document.getElementById('password').value = "";
    document.getElementById('password_confirmation').value = "";

    setTimeout(() => {
        window.location.href = "/login";
    }, 1500);
}
    });
}

function togglePassword(id) {
    const input = document.getElementById(id);
    input.type = input.type === "password" ? "text" : "password";
}

</script>
@endsection