@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Créer un compte</h1>

    <form id="registerForm">

        <input id="nom" type="text" placeholder="Nom"
               class="w-full border p-2 mb-3 rounded" required>

        <input id="prenom" type="text" placeholder="Prénom"
               class="w-full border p-2 mb-3 rounded" required>

        <input id="email" type="email" placeholder="Email"
               class="w-full border p-2 mb-3 rounded" required>

        <input id="password" type="password"
               placeholder="Mot de passe (min 8 caractères)"
               minlength="8"
               class="w-full border p-2 mb-3 rounded" required>

        <input id="password_confirmation" type="password"
               placeholder="Confirmer le mot de passe"
               minlength="8"
               class="w-full border p-2 mb-3 rounded" required>

        <button type="submit"
                class="w-full bg-orange-500 text-white py-2 rounded">
            Créer un compte
        </button>

        <p id="registerError" class="text-red-500 text-sm mt-2"></p>
    </form>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const nom = document.getElementById('nom').value.trim();
    const prenom = document.getElementById('prenom').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const passwordConfirmation =
        document.getElementById('password_confirmation').value.trim();

    const errorBox = document.getElementById('registerError');
    errorBox.innerHTML = '';

    try {
        const response = await fetch(
            'https://mon-nouveau-projet-electro.onrender.com/api/auth/register', {
                
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    name: nom + ' ' + prenom,
                    email: email,
                    password: password,
                    password_confirmation: passwordConfirmation
                })
            }
        );

        const data = await response.json();

        if (!response.ok) {
            if (data.errors) {
                errorBox.innerHTML = Object.values(data.errors)
                    .flat()
                    .join('<br>');
            } else {
                errorBox.textContent = data.message || 'Erreur lors de la création du compte';
            }
            return;
        }

        alert('Compte créé avec succès ✅');
        window.location.href = '/login';

    } catch (err) {
        errorBox.textContent = 'Erreur réseau. Vérifiez la connexion.';
    }
});
</script>
@endsection
