import axios from 'axios';

// Création d'une instance Axios pré-configurée
const api = axios.create({
    // L'API Laravel est servie par Nginx sur le port 80 de Docker (accessible via localhost)
    baseURL: 'http://localhost',

    // Ceci est obligatoire pour Laravel Sanctum (envoie les cookies de session)
    withCredentials: true,

    // Ajoute l'en-tête de l'application Front-end (pour la sécurité Sanctum)
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
    },
});

export default api;