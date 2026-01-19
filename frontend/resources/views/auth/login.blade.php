@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Connexion</h1>

    <form id="loginForm">
    @csrf

    <input
        type="email"
        name="email"
        placeholder="Email"
        class="w-full border p-2 mb-3 rounded"
        required
    >

    <input
        type="password"
        name="password"
        placeholder="Mot de passe"
        class="w-full border p-2 mb-3 rounded"
        required
    >

    <button
        type="submit"
        class="w-full bg-orange-500 text-white py-2 rounded">
        Se connecter
    </button>

    <p id="loginError" class="text-red-500 mt-3 hidden"></p>
</form>

</div>

<script>
document.getElementById('loginForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const email = this.email.value;
    const password = this.password.value;
    const errorBox = document.getElementById('loginError');

    errorBox.classList.add('hidden');

    try {
        const response = await fetch('/api/auth/login', {

            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Erreur de connexion');
        }

        // Sauvegarde du token
        localStorage.setItem('auth_token', data.token);
        localStorage.setItem('user', JSON.stringify(data.user));

        // Redirection
        window.location.href = '/';

    } catch (err) {
        errorBox.textContent = err.message;
        errorBox.classList.remove('hidden');
    }
});
</script>

@endsection
