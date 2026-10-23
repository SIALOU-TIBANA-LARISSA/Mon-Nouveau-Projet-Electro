# Backend — H-Crea & Design

## 1. Présentation

Le backend de **H-Crea & Design** est développé avec Laravel et PHP. Il gère les traitements côté serveur, les données de la plateforme e-commerce, les comptes utilisateurs et les opérations liées aux commandes.

## 2. Technologies utilisées

* **Langage :** PHP
* **Framework :** Laravel
* **Base de données :** MySQL
* **Authentification :** Laravel Sanctum
* **API :** API REST
* **Gestion des dépendances :** Composer

## 3. Fonctionnalités du backend

Le backend prend en charge :

* La gestion des comptes clients et des utilisateurs administrateurs.
* L'authentification et la gestion des accès selon les autorisations.
* La gestion des produits et des catégories.
* La gestion du panier.
* Le traitement et le suivi des commandes.
* La gestion des demandes d'annulation selon les permissions.
* La réception des données des formulaires.
* La gestion des fichiers transmis par les clients pour la personnalisation des créations.
* L'intégration d'une API SMS pour les fonctionnalités prévues dans le parcours utilisateur.

## 4. Organisation du projet

Les principaux dossiers Laravel sont :

* `app/` : contrôleurs, modèles et logique métier.
* `routes/` : définition des routes de l'application et des API.
* `database/` : migrations et autres éléments liés à la base de données.
* `config/` : fichiers de configuration.
* `resources/` : ressources de l'application.
* `bootstrap/` : initialisation de Laravel.
* `public/` : point d'entrée public de l'application.

## 5. Installation en local

### Prérequis

* PHP compatible avec la version de Laravel utilisée.
* Composer.
* MySQL.
* Node.js et npm si la compilation des ressources frontend est nécessaire.

### Étapes d'installation

1. Se placer dans le dossier `Backend`.

2. Installer les dépendances PHP :

   ```bash
   composer install
   ```

3. Copier `.env.example` vers `.env`.

4. Configurer les paramètres de connexion à MySQL dans `.env`.

5. Générer la clé de l'application :

   ```bash
   php artisan key:generate
   ```

6. Exécuter les migrations uniquement si la base de données est correctement configurée et que les migrations du projet sont prêtes :

   ```bash
   php artisan migrate
   ```

7. Démarrer le serveur de développement :

   ```bash
   php artisan serve
   ```

## 6. Sécurité

* Les informations sensibles doivent rester dans le fichier `.env`.
* Le fichier `.env` ne doit pas être publié sur GitHub.
* Les accès aux fonctionnalités doivent respecter les mécanismes d'authentification et d'autorisation de l'application.

## 7. Dépôt

Le README principal, situé à la racine du dépôt, présente l'ensemble du projet H-Crea & Design. Ce fichier décrit plus spécifiquement son backend.
