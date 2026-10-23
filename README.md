# H-Crea & Design — Plateforme e-commerce

## Présentation du projet

H-Crea & Design est une plateforme e-commerce dédiée à la vente de produits personnalisés. Elle permet aux clients de découvrir les produits disponibles, de consulter les modèles réalisés, de personnaliser leurs propres créations, de gérer leur panier et de passer des commandes en ligne.

Ce projet a été réalisé dans le cadre d'une expérience professionnelle afin de mettre en pratique mes compétences en développement web, en gestion de bases de données et en intégration d'API.

## Fonctionnalités principales

### 1. Catalogue et consultation des produits

* Affichage du catalogue de produits.
* Organisation des produits par catégories.
* Consultation des fiches détaillées des produits.
* Recherche de produits.
* Consultation des descriptions et des informations relatives aux produits.

### 2. Visualisation des fichiers des produits déjà réalisés

La plateforme permet aux clients de visualiser les modèles numériques associés aux produits déjà réalisés.

* Prise en charge des fichiers aux formats STL, SVG et DXF selon le modèle.
* Visualisation des modèles disponibles sur la plateforme.
* Prévisualisation des créations pour mieux apprécier leur rendu avant de passer commande.

### 3. Personnalisation des créations

La plateforme propose un espace de personnalisation permettant aux clients d'importer leurs propres fichiers et de visualiser le rendu de leurs créations directement sur le site.

Les fonctionnalités comprennent :

* Importation de fichiers aux formats SVG et DXF.
* Choix du rendu parmi quatre options : Bois, Plexiglass, Noir et Rouge.
* Modification du rendu selon le matériau ou la couleur sélectionnée.
* Prévisualisation de la création après personnalisation.
* Visualisation du résultat avant de finaliser la commande.

### 4. Gestion des comptes clients

* Création de compte client.
* Connexion et déconnexion.
* Authentification des utilisateurs.
* Inscription par e-mail ou par SMS.
* Vérification du compte par code OTP lorsque cette méthode est utilisée.

### 5. Gestion du panier

* Ajout de produits au panier.
* Consultation du panier.
* Gestion des articles sélectionnés.
* Préparation de la commande à partir du panier.

### 6. Gestion des commandes

* Passage de commandes.
* Gestion des commandes depuis l'interface d'administration.
* Consultation et suivi des commandes selon les fonctionnalités disponibles.
* Annulation des commandes par les utilisateurs disposant des autorisations nécessaires.

### 7. Page de contact

La plateforme dispose d'une page « Contactez-nous » permettant aux visiteurs de contacter l'entreprise.

* Formulaire de contact.
* Saisie des informations nécessaires à la demande.
* Envoi des messages à l'entreprise.

### 8. Notifications par SMS

Intégration d'une API SMS permettant de prendre en charge les fonctionnalités suivantes :

* Inscription des clients par SMS.
* Envoi de notifications par SMS.

### 9. Interface d'administration

L'interface d'administration permet de gérer les activités de la boutique et les utilisateurs autorisés à intervenir sur la plateforme.

#### Gestion des clients

* Consultation des comptes clients.
* Gestion des informations des clients selon les fonctionnalités disponibles.

#### Gestion des utilisateurs et des autorisations

* Gestion des comptes des personnes autorisées à accéder à l'administration.
* Gestion des rôles et des permissions.
* Attribution des autorisations selon les responsabilités des utilisateurs.

#### Gestion des produits et des catégories

* Ajout de produits.
* Modification des produits.
* Suppression des produits.
* Gestion des catégories.

#### Gestion des commandes

* Consultation et gestion des commandes.
* Suivi des commandes.
* Annulation des commandes selon les autorisations accordées.

## Technologies utilisées

### Frontend

* HTML5
* CSS3
* JavaScript
* Tailwind CSS
* Laravel Blade
* Vite

### Backend

* PHP
* Laravel
* API REST
* Laravel Sanctum pour les fonctionnalités d'authentification concernées.

### Base de données

* **MySQL** : utilisé pour le développement local et le déploiement final sur Hostinger.
* **PostgreSQL** : utilisé lors des premiers tests de déploiement sur Render.

### Outils et services

* Git et GitHub
* Docker
* FileZilla
* Render pour les premiers tests de déploiement
* Hostinger pour l'hébergement final

## Intégration d'API

### API SMS

L'intégration d'une API SMS permet de prendre en charge l'inscription des clients par SMS et l'envoi de notifications.

## Déploiement

Le projet a d'abord été déployé sur Render afin de tester son fonctionnement en environnement distant.

Après cette phase de test, la version finale du site a été déployée sur **Hostinger avec une base de données MySQL**.

## Installation en local

### Prérequis

* PHP
* Composer
* Node.js et npm
* MySQL
* Un serveur web compatible avec Laravel

### Étapes d'installation

1. Cloner le dépôt GitHub.

2. Installer les dépendances PHP :

   ```bash
   composer install
   ```

3. Copier le fichier `.env.example` vers `.env`.

4. Configurer les paramètres de connexion à MySQL dans le fichier `.env`.

5. Générer la clé de l'application :

   ```bash
   php artisan key:generate
   ```

6. Exécuter les migrations :

   ```bash
   php artisan migrate
   ```

7. Installer les dépendances frontend :

   ```bash
   npm install
   ```

8. Compiler les ressources frontend :

   ```bash
   npm run build
   ```

9. Démarrer le serveur local :

   ```bash
   php artisan serve
   ```

## Sécurité

* Ne pas publier le fichier `.env`.
* Ne pas exposer les mots de passe, les clés d'API ou les identifiants de connexion.
* Conserver les informations sensibles dans les variables d'environnement.
* Vérifier les fichiers importés par les utilisateurs avant leur traitement.
* Contrôler les droits d'accès aux fonctionnalités d'administration.

## Statut du projet

Version finale déployée sur Hostinger avec MySQL. Le code source est disponible sur GitHub.

## Auteur

**SIALOU TIBANA LARISSA**

Développeuse d'applications et de sites web.
