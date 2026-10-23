@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Créer un compte</h1>

    <form id="registerForm" novalidate>

        <input id="nom" type="text" placeholder="Nom"
               class="w-full border p-2 mb-3 rounded" required>

        <input id="prenom" type="text" placeholder="Prénom"
               class="w-full border p-2 mb-3 rounded" required>

        <div class="mb-3">
    <label class="block mb-2 font-semibold">Méthode d'inscription</label>

    <div class="flex gap-4">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="radio" name="method" value="email" checked onclick="toggleMethod()">
            📧 Email
        </label>

        <label class="flex items-center gap-2 cursor-pointer">
            <input type="radio" name="method" value="phone" onclick="toggleMethod()">
            📱 Téléphone
        </label>
    </div>
</div>

<!-- EMAIL -->
<div id="emailField" class="mb-3">
    <input id="email" type="email"
           placeholder="Email"
           class="w-full border p-2 rounded">
</div>

<!-- PHONE -->
<div id="phoneField" class="mb-3 hidden">
    <input id="phone" type="text"
           placeholder="Numéro (ex: 2250700000000)"
           class="w-full border p-2 rounded">
</div>

<div class="relative mb-3">
        <input id="password" type="password"
               placeholder="Mot de passe (min 8 caractères)"
               minlength="8"
               class="w-full border p-2 rounded pr-10" required>
               <span onclick="togglePassword('password')"
          class="absolute right-3 top-2.5 cursor-pointer text-gray-500">
        👁
    </span>
</div>

<div class="relative mb-3">
        <input id="password_confirmation" type="password"
               placeholder="Confirmer le mot de passe"
               minlength="8"
               class="w-full border p-2 rounded pr-10" required>
               <span onclick="togglePassword('password_confirmation')"
          class="absolute right-3 top-2.5 cursor-pointer text-gray-500">
        👁
    </span>
</div>
   <p id="passwordMatch" class="text-sm mt-2"></p>

        <button type="submit"
                class="w-full bg-orange-500 text-white py-2 rounded">
            Créer un compte
        </button>

        <p id="registerError" class="text-red-500 text-sm mt-2"></p>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById('registerForm');
    if (!form) return;

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const nom = document.getElementById('nom').value.trim();
        const prenom = document.getElementById('prenom').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const password = document.getElementById('password').value.trim();
        const passwordConfirmation = document.getElementById('password_confirmation').value.trim();

        const errorBox = document.getElementById('registerError');
        errorBox.innerHTML = '';

        const method = document.querySelector('input[name="method"]:checked').value;

        let payload = {
            name: nom + ' ' + prenom,
            password: password,
            password_confirmation: passwordConfirmation
        };

        if (method === "email") {
            payload.email = email;
        } else {
            payload.phone = phone;
        }

        try {
            const response = await fetch(
                '/api/auth/register',
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                }
            );

            const data = await response.json();

            if (!response.ok) {
                if (data.errors) {
                    errorBox.innerHTML = Object.values(data.errors).flat().join('<br>');
                } else {
                    errorBox.textContent = data.message || 'Erreur lors de la création du compte';
                }
                return;
            }

            alert('Compte créé avec succès ✅');

if (data.phone) {
    window.location.href = '/verify-otp';
} else {
    window.location.href = '/login';
}

        } catch (err) {
            errorBox.textContent = 'Erreur réseau. Vérifiez la connexion.';
            console.error(err);
        }
    });

});
document.addEventListener('DOMContentLoaded', function () {

    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const matchMessage = document.getElementById('passwordMatch');

    function checkPasswordMatch() {

        if (!passwordInput.value || !confirmInput.value) {
            matchMessage.innerText = "";
            return;
        }

        if (passwordInput.value === confirmInput.value) {
            matchMessage.innerText = "✔ Les mots de passe correspondent";
            matchMessage.classList.remove('text-red-500');
            matchMessage.classList.add('text-green-500');
        } else {
            matchMessage.innerText = "✖ Les mots de passe ne correspondent pas";
            matchMessage.classList.remove('text-green-500');
            matchMessage.classList.add('text-red-500');
        }
    }

    passwordInput.addEventListener('input', checkPasswordMatch);
    confirmInput.addEventListener('input', checkPasswordMatch);

});

function togglePassword(id) {
    const input = document.getElementById(id);

    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}

function toggleMethod() {
    const method = document.querySelector('input[name="method"]:checked').value;

    const emailField = document.getElementById('emailField');
    const phoneField = document.getElementById('phoneField');

    if (method === "email") {
        emailField.classList.remove("hidden");
        phoneField.classList.add("hidden");
    } else {
        phoneField.classList.remove("hidden");
        emailField.classList.add("hidden");
    }
}
</script>

@endsection
