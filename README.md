# Leadline — Pipeline Prospect CRM

**Pipeline Prospect** est une application web développée dans le cadre du **BTS SIO – SLAM (Épreuve E5 – Client léger)**.
C’est un **CRM** conçu pour rendre la gestion des prospects, des clients et des activités **simple, collaborative et efficace**, avec une interface claire et rapide.

---

## Sommaire
- [Objectifs](#-objectifs)
- [Fonctionnalités](#-fonctionnalités)
- [Stack technique](#-stack-technique)
- [Pré-requis](#-pré-requis)
- [Installation](#-installation)
- [Rôles & permissions (RBAC)](#-rôles--permissions-rbac)
- [Structure du projet](#-structure-du-projet)
- [Licence](#-licence)

---

## Objectifs
- Centraliser la gestion des **prospects** et des **clients**.
- Organiser l’activité commerciale via des **espaces** et **listes thématiques**.
- Planifier des **activités** (rendez-vous, relances) et suivre l’historique.
- Encadrer les accès par **rôles** et **permissions**.
- Proposer une UX **sobre, efficace, responsive** (Tailwind CSS).

---

## Fonctionnalités
- Authentification (inscription, connexion, déconnexion).
- **Espaces** : créer, modifier, archiver, supprimer ; associer des collaborateurs.
- **Listes** : regrouper les prospects par thématique au sein d’un espace.
- **Prospects** : créer, modifier, supprimer, **convertir en client**.
- **Clients** : base consolidée des prospects transformés (consultation).
- **Activités** : planifier rendez-vous/relances (date, heure, description, participants).
- **Organisation** : inviter des utilisateurs, assigner des rôles (RBAC).
- Interface avec **modales** pour créer/éditer sans rechargement de page.

---

## Stack technique
- **Backend** : Laravel 10 (architecture MVC)
- **Frontend** : Blade, Tailwind CSS, JavaScript (vanilla)
- **Base de données** : MySQL
- **Environnement** : PHP 8+, Composer, Node.js/NPM
- **Outils** : VS Code, PHPMyAdmin, Plesk (hébergement + SSL), Trello/Notion

---

## Pré-requis
- **PHP** ≥ 8.1 (recommandé 8.2+)
- **Composer** ≥ 2.x
- **Node.js** ≥ 18 et **NPM**
- **MySQL** ≥ 8.x
- Git installé

---

## Installation

### 1) Cloner le dépôt
```bash
git clone https://github.com/yhn-dm/leadline-pipeline-prospect-project.git
cd leadline-pipeline-prospect-project
```

### 2) Dépendances PHP & Front
```bash
composer install
npm install
npm run dev   # ou npm run build pour la version de prod
```

### 3) Variables d’environnement
```bash
cp .env.example .env
php artisan key:generate
```
- Renseigner votre connexion **MySQL** dans `.env` (DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD).
- (Optionnel) Configurer **APP_NAME**, **APP_URL**, **MAIL_*** si nécessaire.

### 4) Migration & données de départ
```bash
php artisan migrate --seed
```
> `--seed` peut créer des données minimales selon vos seeders.

### 5) Lien de stockage (si uploads)
```bash
php artisan storage:link
```

### 6) Lancer le serveur local
```bash
php artisan serve
```
Application disponible sur : http://localhost:8000

---

## Rôles & permissions (RBAC)
- **Administrateur** : accès total à l’application, gestion des rôles.
- **Manager** : gère prospects/clients/activités **attribués** ; pas de gestion des rôles.
- **Collaborateur** : accès limité aux **espaces** et **listes assignés**.
- **En attente** : rôle par défaut à l’invitation, **aucun accès** tant qu’il n’est pas validé.

---

## Structure du projet
```
crm_prospect/
├─ app/                # Modèles, contrôleurs, logique métier
├─ resources/
│  ├─ views/           # Vues Blade
│  └─ css|js           # Assets front (compilés par Vite)
├─ routes/
│  └─ web.php          # Routes web
├─ database/
│  ├─ migrations/      # Migrations
│  └─ seeders/         # Seeders
├─ public/             # Fichiers publics (build, images)
└─ vendor/             # Dépendances Composer
```

---

## Licence
Projet académique – **BTS SIO SLAM 2025**  
Distribué sous **Licence MIT**.

---
**Repo** : `yhn-dm/leadline-pipeline-prospect-project`

