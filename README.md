# ✨ Camille et la Quête du Lâcher-Prise – Application Laravel + Vue ✨

## 🎓 WebMobUi – Media Engineering – HEIG-VD 🎓

Cette application est une fiction interactive développée dans le cadre du cours WebMobUI.  
Elle repose sur une architecture fullstack **Laravel (Backend)** et **Vue.js (Frontend)**.

---

## 🧠 De quoi s'agit-il ?

Camille est une jeune étudiante passionnée par le design d’interface et le développement web.  
Elle se met constamment une pression immense pour créer des projets parfaits... jusqu’au jour où elle découvre la poterie, et avec elle, le **lâcher-prise créatif**.

Ce projet vous propose une **narration interactive**, où les choix du joueur influencent le déroulement de l'histoire.

Chaque histoire, chapitre et choix est géré dynamiquement via une API REST, et stocké en base de données.

---

## ⚙️ Étapes d'installation ⚙️

Voici les étapes pour faire fonctionner le projet localement :

### 1. Créer un dossier de projet 📁

```bash
mkdir CamilleNarration
cd CamilleNarration
```

### 2. Cloner le dépôt et ajouter votre propre dépôt Git 🔄

```bash
# Cloner
git clone https://github.com/AgatheMakumbi/projet-Laravel-vue.git

# Défini ton dépôt comme origine
git remote set-url origin https://github.com/YourGitHubUsername/YourAppName.git
```
### 3. Installer les dépendances 📦

```bash
# Frontend
npm install
npm run build

# Backend
composer install
```
### 4. Configurer l’environnement 📝

```bash
cp .env.example .env
```
>Ouvre le fichier .env et configure ta base de données (SQLite recommandé pour ce projet).
Assure-toi que l’URL de base de l’API est définie et que les tokens CSRF sont bien chargés.

### 5. Générer la clé de l’application et exécuter les migrations 🔑

```bash 
php artisan key:generate
php artisan migrate
php artisan db:seed
```

### 6. Lancer le serveur de développement ▶️

```bash
php artisan serve
```

>Par défaut, l’API est disponible à : http://127.0.0.1:8000/api/v1

Et côté frontend :

```bash
npm run dev
```

>L’interface Vue.js est accessible à : http://localhost:5173

Ou pour lancer les deux commandes en une fois

```bash
composer run dev 
```