# Corrigé du Workshop : Composer / MVC / PHP

Ce document sert de support et de corrigé pour les étudiants travaillant sur le projet **My Todoo**. Il répond aux questions pédagogiques posées dans l'énoncé et explique les choix d'implémentation.

---

## 1. Le Gestionnaire de Dépendances Composer

### ❓ À quoi sert le fichier `composer.json` ?
Le fichier `composer.json` est le fichier de configuration de Composer pour le projet. Il définit les métadonnées du projet (nom, auteurs) mais surtout la liste des dépendances (bibliothèques tierces) dont le projet a besoin pour fonctionner. C'est ici que l'on déclare les packages et leurs versions.

### ❓ Avec quelle commande a-t-il été créé ?
Il peut être créé manuellement ou via la commande `composer init`, qui lance un assistant interactif pour configurer les bases du projet.

### ❓ Comment peut-on installer des dépendances renseignées dans le fichier `composer.json` ?
On utilise la commande `composer install`. Cette commande lit le fichier `composer.json` (ou `composer.lock` s'il existe) et télécharge les dépendances dans un répertoire nommé `vendor`.

### ❓ Quelles informations contient-il ?
Il contient :
- Le nom et la description du projet.
- Les dépendances requises (`require`).
- Les dépendances de développement (`require-dev`).
- Les configurations d'autochargement (`autoload`).
- Les métadonnées sur les auteurs.

### ❓ Quelle est la différence entre les dépendances `require` et `require-dev` ?
- **`require`** : Contient les packages indispensables au fonctionnement de l'application en production (ex: Twig).
- **`require-dev`** : Contient les packages nécessaires uniquement durant la phase de développement ou de test (ex: PHPUnit pour les tests unitaires). Ils ne sont pas installés lors d'un déploiement en production (avec `--no-dev`).

### ❓ Qu’est-ce qu’un autoloader ? Que signifie la directive suivante ?
Un **autoloader** permet de charger automatiquement les fichiers PHP contenant les classes au moment où elles sont utilisées dans le code, sans avoir à faire de multiples `require` ou `include` manuels.

La directive :
```json
"autoload": {
    "psr-4": {
        "App\\": "src/"
    }
}
```
signifie que nous utilisons la norme **PSR-4**. Elle indique à Composer que toutes les classes commençant par le namespace `App` se trouvent dans le répertoire `src/`. Par exemple, la classe `App\Models\TaskModel` sera cherchée dans le fichier `src/Models/TaskModel.php`.

### ❓ Expliquez la relation entre les namespaces et l’arborescence du répertoire `src`.
Avec PSR-4, la structure des namespaces doit refléter exactement la structure des dossiers. Chaque niveau de namespace correspond à un sous-dossier dans `src/`. Cela permet une organisation rigoureuse et une recherche de fichiers efficace par l'autoloader.

---

## 2. L’Architecture MVC

### ❓ Quel est le rôle du contrôleur ? À quoi correspondent les attributs `$model` et `$templateEngine` ?
Le **Contrôleur** est le chef d'orchestre. Il reçoit la requête de l'utilisateur (via le routeur), interroge le Modèle pour récupérer ou modifier des données, puis choisit la Vue à afficher.
- `$model` : Instance de la classe Modèle permettant l'accès aux données.
- `$templateEngine` : Instance du moteur de template (Twig) utilisée pour générer le rendu HTML.

### ❓ Quel est le rôle du modèle ? À quoi correspond l’attribut `$connection` ?
Le **Modèle** gère la logique métier et les données. C'est lui qui sait "comment" sont stockées les données et comment les manipuler.
- `$connection` : Représente la connexion à la source de données (ici, une base de données de fichiers CSV).

### ❓ Quel est le rôle de la classe `FileDataBase` ?
Elle simule une base de données en utilisant des fichiers CSV. Elle fournit des méthodes génériques pour lire (`getAllRecords`, `getRecord`), insérer (`insertRecord`) et mettre à jour (`updateRecord`) des données sur le disque.

### ❓ Quel est le rôle du fichier `index.php` ?
C'est le **point d'entrée unique** de l'application (Front Controller). Son rôle est d'initialiser l'environnement (autoloader, Twig) et de router la requête vers la bonne méthode du contrôleur en fonction du paramètre `uri`.

### ❓ Schéma de l'architecture MVC
1. **Utilisateur** envoie une requête (ex: clique sur "Add").
2. **Index.php (Routeur)** reçoit la requête et appelle le **Contrôleur**.
3. **Contrôleur** demande au **Modèle** d'ajouter la tâche.
4. **Modèle** met à jour la **Source de données** (CSV) et confirme au Contrôleur.
5. **Contrôleur** demande à la **Vue (Twig)** de générer la page.
6. **Vue** renvoie le HTML au **Contrôleur**.
7. **Contrôleur** renvoie la réponse finale au **Navigateur**.

---

## 3. Implémentations Techniques

### 3.1 Le Modèle (`TaskModel`)
Le modèle a été complété pour filtrer les tâches par statut (`todo` ou `done`) en utilisant la classe `FileDatabase`.

### 3.2 La Vue (Twig)
L'utilisation de Twig permet de séparer le HTML du PHP. Nous avons mis en place :
- Un template de base (`layout.twig.html`) contenant la structure commune.
- Des templates spécifiques qui "étendent" ce layout (`todo.twig.html`, `history.twig.html`).
- L'utilisation de boucles `{% for task in tasks %}` pour afficher dynamiquement les listes.

### 3.3 Le Contrôleur (`TaskController`)
Les méthodes gèrent les redirections après action. Par exemple, après `addTask`, l'utilisateur est redirigé vers la page d'accueil (`header('Location: ' . BASE_URL)`) pour voir sa nouvelle tâche.

### 3.4 Le Routeur (`index.php`)
Le `switch` dans `index.php` permet de diriger chaque action vers la bonne méthode :
- `/` -> `welcomePage()`
- `add_task` -> `addTask()`
- `check_task` -> `checkTask()`
- `history` -> `historyPage()`
- `uncheck_task` -> `uncheckTask()`
- `about` -> `aboutPage()`

---

## 4. Configuration et Centralisation

Pour éviter de répéter l'URL de base du projet (ex: `http://localhost/mytodo_etu/`) dans tout le code, nous avons mis en place une constante globale :
- **`BASE_URL`** est définie dans `index.php`.
- Elle est utilisée dans le **Contrôleur** pour les redirections PHP : `header('Location: ' . BASE_URL);`.
- Elle est transmise à **Twig** comme variable globale (`base_url`), ce qui permet de l'utiliser dans les templates : `{{ base_url }}?uri=history`.
Cela facilite grandement le déploiement sur un autre serveur ou dossier : il suffit de modifier une seule ligne dans `index.php`.


## 6. Design et Interface Utilisateur (UI/UX)

Pour cette version, l'interface a été entièrement refondue avec une approche **Mobile-First** :
- **Centralisation du style** : Suppression de tout le CSS inline au profit d'un fichier `static/css/main.css`.
- **Responsive Design** : Utilisation de Flexbox et des Media Queries pour garantir un affichage optimal sur smartphone, tablette et ordinateur.
- **Expérience Utilisateur** : Utilisation de variables CSS pour une gestion cohérente des couleurs, espacements et arrondis (border-radius).
- **Contenu Enrichi** : La page "À propos" sert désormais de guide pédagogique expliquant l'architecture du projet.
- **Séparation des préoccupations** : Le code HTML reste pur, tandis que le style est déporté dans des fichiers dédiés, facilitant la maintenance et la collaboration.
