# Documentation du Projet : Plateforme E-Learning

## 1. Introduction

Ce document détaille l'architecture, la configuration et la logique du projet de plateforme e-learning. L'objectif est de fournir une compréhension claire de chaque composant, du général au spécifique.

**Technologies principales :**
*   **Framework Backend :** Laravel (PHP)
*   **Base de données :** PostgreSQL
*   **Frontend :** HTML, CSS, JavaScript (statiques pour l'instant)

## 2. Structure d'un Projet Laravel

Laravel organise le code dans des dossiers avec des responsabilités bien définies. Voici les plus importants pour ce projet :

- **`app/`** : C'est le cœur de votre application.
    - **`Http/Controllers`** : Contiennent la logique pour répondre aux requêtes des utilisateurs (ex: afficher une page, traiter un formulaire).
    - **`Http/Middleware`** : Permettent de filtrer les requêtes. Nous en avons créé un pour la redirection après connexion.
    - **`Models`** : Représentent les données de votre base de données (ex: le modèle `User` est lié à la table `users`).
- **`config/`** : Contient les fichiers de configuration de l'application (base de données, mail, services, etc.).
- **`database/`** : Tout ce qui concerne la base de données.
    - **`migrations`** : Des "contrôles de version" pour votre base de données. Chaque fichier décrit une modification de la structure (créer une table, ajouter une colonne...).
    - **`seeders`** : Permettent de remplir la base de données avec des données initiales ou de test.
- **`public/`** : Le seul dossier accessible directement depuis un navigateur. Il contient le point d'entrée de l'application (`index.php`) et vos ressources compilées (CSS, JS, images). Les fichiers de design (`desgin/`) s'y trouvent.
- **`resources/`** : Contient les "vues" (`views`), c'est-à-dire les fichiers HTML (avec du PHP, format `.blade.php`) qui sont envoyés au navigateur.
- **`routes/`** : Définit toutes les URLs (routes) de votre application.
    - **`web.php`** : Pour les routes accessibles via un navigateur.
- **`.env`** : Fichier de configuration de l'environnement. Il contient les informations sensibles comme les mots de passe de la base de données. **Ce fichier ne doit jamais être partagé ou versionné (il est dans `.gitignore`).**

---

## 3. Configuration de l'Environnement (`.env`)

C'est la première étape que nous avons réalisée. Le fichier `.env` permet de configurer l'application sans modifier le code.

**Actions réalisées :**
1.  Nous avons copié `.env.example` pour créer votre fichier `.env`.
2.  Nous avons modifié les variables de base de données pour utiliser PostgreSQL :
    ```ini
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=educa_laravel
    DB_USERNAME=postgres
    DB_PASSWORD=firas
    ```
3.  Nous avons généré une clé de sécurité unique pour l'application avec la commande `php artisan key:generate`.

---

## 4. Base de Données : Migrations et Seeders

### a. Migrations (`database/migrations`)

Pour que notre système de rôles fonctionne, nous devions savoir si un utilisateur est un "admin" ou un "student".

**Action réalisée :**
- Nous avons modifié la migration `0001_01_01_000000_create_users_table.php` pour ajouter une colonne `role` à la table `users`.
    ```php
    // dans la méthode up() de la migration
    $table->string('role')->default('student'); // Par défaut, tout nouvel utilisateur est un étudiant.
    ```

### b. Seeders (`database/seeders`)

Pour tester notre logique sans avoir à créer manuellement des utilisateurs à chaque fois, nous avons utilisé un "seeder".

**Action réalisée :**
- Nous avons modifié le fichier `DatabaseSeeder.php` pour créer automatiquement deux utilisateurs lorsque nous rafraîchissons la base de données :
    1.  Un **administrateur** avec le rôle `admin`.
    2.  Un **utilisateur standard** avec le rôle `student`.

    ```php
    // dans DatabaseSeeder.php
    User::query()->create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);

    User::query()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
        'role' => 'student',
    ]);
    ```
- Nous avons ensuite exécuté `php artisan migrate:fresh --seed` pour supprimer toutes les anciennes tables, les recréer avec la nouvelle structure et les remplir avec ces deux utilisateurs.

---

## 5. Logique de l'Application

### a. Le Modèle `User.php` (`app/Models/User.php`)

Ce fichier est la représentation d'un utilisateur en PHP.

**Actions réalisées :**
1.  Nous avons ajouté la colonne `role` à la liste des attributs "remplissables" (`$fillable`) pour autoriser sa modification via le code.
2.  Nous avons ajouté une fonction très pratique `isAdmin()` pour vérifier facilement le rôle d'un utilisateur.

    ```php
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    ```

### b. Le Middleware `RedirectIfAuthenticated.php` (`app/Http/Middleware/RedirectIfAuthenticated.php`)

Un middleware est un filtre. Celui-ci s'exécute quand un utilisateur **déjà connecté** essaie d'accéder à une page comme le formulaire de connexion. Au lieu de lui remontrer le formulaire, on le redirige.

**Action réalisée :**
- Nous avons modifié la méthode `handle` de ce middleware pour implémenter notre logique de redirection basée sur les rôles :
    1.  On vérifie si l'utilisateur est connecté.
    2.  Si oui, on récupère l'utilisateur (`Auth::user()`).
    3.  On utilise notre fonction `isAdmin()` :
        - Si c'est un admin, on le redirige vers `/admin`.
        - Sinon (c'est un étudiant), on le redirige vers la page d'accueil (`/`).

    ```php
    // Logique principale dans RedirectIfAuthenticated.php
    if (Auth::guard($guard)->check()) {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect('/admin');
        }
        return redirect(RouteServiceProvider::HOME); // HOME est '/'
    }
    ```

---

## 6. Le Problème du "Login"

Comme nous l'avons découvert, le projet ne possédait pas de routes ni de contrôleur pour gérer la connexion. La logique de redirection que nous avons mise en place ne peut donc pas encore être déclenchée.

**Prochaines étapes nécessaires :**
1.  **Créer les routes** pour afficher le formulaire de connexion (requête GET) et pour traiter les données du formulaire (requête POST).
2.  **Créer un `LoginController`** avec des méthodes pour :
    - `create()`: Afficher la vue du formulaire de connexion.
    - `store()`: Valider les identifiants et connecter l'utilisateur.
3.  **Créer une vue** (`login.blade.php`) dans `resources/views/auth/` avec un formulaire HTML.

Une fois ces éléments en place, le flux complet fonctionnera : l'utilisateur se connectera, et le middleware le redirigera au bon endroit.
