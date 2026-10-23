
@extends('layouts.app')

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow mt-10">
    <h2 class="text-xl font-bold mb-4 text-center">Vérification du numéro</h2>

    <form id="otpForm">
        <input type="text" id="phone"
            placeholder="Votre numéro (22507xxxxxxx)"
            class="w-full border p-2 mb-3 rounded"
            required>

        <input type="text" id="code"
            placeholder="Code reçu par SMS"
            class="w-full border p-2 mb-3 rounded"
            required>

        <button type="submit"
            class="w-full bg-green-500 text-white py-2 rounded">
            Vérifier
        </button>

        <p id="otpError" class="text-red-500 text-sm mt-2"></p>
    </form>
</div>

<script>
document.getElementById('otpForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const phone = document.getElementById('phone').value.trim();
    const code = document.getElementById('code').value.trim();
    const errorBox = document.getElementById('otpError');
    errorBox.innerHTML = '';

    try {
        const response = await fetch('/verify-otp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ phone, code })
        });

        const data = await response.json();

        if (!response.ok) {
            errorBox.textContent = data.message;
            return;
        }

        // Stocker le token
        localStorage.setItem('auth_token', data.access_token);
        localStorage.setItem('user', JSON.stringify(data.user));

        alert('Numéro vérifié avec succès ✅');

        window.location.href = '/';

    } catch (err) {
        errorBox.textContent = "Erreur réseau.";
    }
});
</script>
@endsection