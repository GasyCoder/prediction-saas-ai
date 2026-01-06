# Predictly AI

**Predictly AI** est une plateforme SaaS de prédiction avancée qui utilise l'intelligence artificielle pour analyser les données collectées via des questionnaires dynamiques.

---

## 🚀 Fonctionnalités principales

- **Questionnaires Dynamiques** : Création et gestion de questionnaires structurés par catégories.
- **Analyse IA** : Traitement des réponses par des modèles d'IA pour générer des prédictions précises.
- **Gestion des Catégories** : Organisation des prédictions par domaines (Santé, Business, Finance, etc.).
- **Historique et Résultats** : Suivi complet des requêtes de prédiction et de leurs résultats.
- **Système de Paiement** : Intégration pour la monétisation des services de prédiction.

## 🛠️ Pile Technologique

- **Framework** : [Laravel 11](https://laravel.com)
- **Langage** : PHP 8.2+
- **Base de données** : MySQL / PostgreSQL
- **Outils** : Composer, Artisan, Vite

## 📂 Structure Core (Modèles)

Le projet est articulé autour des modèles suivants :
- `Questionnaire` & `Question` : Système de collecte de données.
- `PredictionCategory` : Classification des types de prédictions.
- `PredictionRequest` : Demandes d'analyses soumises par les utilisateurs.
- `Payment` : Suivi des transactions pour l'accès aux prédictions.

## ⚙️ Installation

1. **Cloner le dépôt**
   ```bash
   git clone git@github.com:GasyCoder/prediction-saas-ai.git
   cd prediction-saas-ai
   ```

2. **Installer les dépendances**
   ```bash
   composer install
   npm install
   ```

3. **Configuration de l'environnement**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrations & Base de données**
   ```bash
   # Configurez votre DB dans le fichier .env d'abord
   php artisan migrate
   ```

5. **Lancer le serveur**
   ```bash
   php artisan serve
   ```

---

## 📝 Licence

Ce projet est sous licence MIT.
