@extends('layouts.app')

@section('title', 'Contact')

@section('content')

<section class="max-w-7xl mx-auto px-4 py-12">

    <h1 class="text-3xl font-bold text-center mb-4">
        Contactez-nous
    </h1>

    <p class="text-center text-gray-600 mb-10">
        Une question, un projet ou un besoin de modélisation et d’impression ?
        Notre équipe est à votre écoute.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <!-- ================= INFOS ENTREPRISE ================= -->
        <div class="bg-white shadow rounded-lg p-6 space-y-6">

            <h2 class="text-xl font-bold mb-4">
                Nos coordonnées
            </h2>

            <!-- Téléphone / WhatsApp -->
            <div class="space-y-4">

                <div class="flex items-start gap-4">
                    <span class="text-2xl">📞</span>
                    <div>
                        <p class="font-semibold">
                            <a href="tel:+2250586414545" class="hover:text-orange-500">
                                +225 05 86 41 45 45
                            </a>
                        </p>
                        <a href="https://wa.me/2250586414545"
                           target="_blank"
                           class="text-green-600 text-sm hover:underline">
                            Contacter sur WhatsApp
                        </a>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <span class="text-2xl">📞</span>
                    <div>
                        <p class="font-semibold">
                            <a href="tel:+2250584208080" class="hover:text-orange-500">
                                +225 05 84 20 80 80
                            </a>
                        </p>
                        <a href="https://wa.me/2250584208080"
                           target="_blank"
                           class="text-green-600 text-sm hover:underline">
                            Contacter sur WhatsApp
                        </a>
                    </div>
                </div>

            </div>

            <!-- Adresse -->
            <div class="pt-4">
                <h3 class="font-semibold mb-1">📍 Adresse</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Bingerville Akouai Santai,<br>
                    derrière le Jardin Botanique,<br>
                    non loin de la cité La Celle.
                </p>
            </div>

            <!-- Moyens de paiement -->
            <div class="pt-4">
                <h3 class="font-semibold mb-2">💳 Moyens de paiement</h3>
                <p class="text-gray-600 text-sm">
                    Orange Money, MTN Mobile Money, Moov Money, Flooz,<br>
                    Visa et Mastercard.
                </p>
            </div>

            <!-- Réseaux sociaux -->
            <div class="pt-4">
                <h3 class="font-semibold mb-2">🌐 Réseaux sociaux</h3>
                <div class="flex items-center gap-4">
                    <a href="https://wa.me/2250586414545" target="_blank"
                       class="text-green-600 font-semibold hover:underline">
                        WhatsApp
                    </a>
                    <a href="#" class="text-blue-600 font-semibold hover:underline">
                        Facebook
                    </a>
                </div>
            </div>

        </div>

        <!-- ================= FORMULAIRE (EMAIL PLUS TARD) ================= -->
        <div class="bg-white shadow rounded-lg p-6">

            <h2 class="text-xl font-bold mb-4">
                Envoyez-nous un message
            </h2>

            <form class="space-y-4">

                <div>
                    <label class="block text-sm font-semibold mb-1">
                        Nom
                    </label>
                    <input type="text"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-orange-200"
                           placeholder="Votre nom">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">
                        Email
                    </label>
                    <input type="email"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-orange-200"
                           placeholder="Votre email">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">
                        Message
                    </label>
                    <textarea rows="4"
                              class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-orange-200"
                              placeholder="Votre message"></textarea>
                </div>

                <button type="submit"
                        class="bg-orange-500 text-white px-6 py-2 rounded-full hover:bg-orange-600 transition">
                    Envoyer
                </button>

            </form>

            <p class="text-xs text-gray-400 mt-4">
                * L’envoi par email sera activé prochainement.
            </p>

        </div>

    </div>

</section>

@endsection
