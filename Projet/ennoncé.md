# Projet Web – Plateforme de gestion des stages

---

## 1. Présentation du projet

Les étudiants effectuent leurs recherches de stage en entreprise en activant leurs réseaux personnels et professionnels (LinkedIn, anciennes promotions, etc.) et en postulant à des offres.

Afin de rendre cette dernière étape de recherche de stage plus facile et pratique, il serait nécessaire de disposer d'un site web qui regroupe différentes offres de stage, et qui permettra de stocker les données des entreprises ayant déjà pris un stagiaire, ou qui en recherchent un.

---

## 1.1 Déroulement

Le projet se déroule pratiquement tout le long du bloc. Des temps projets sont prévus régulièrement, ce qui vous permettra d’avancer progressivement votre projet à l’aide de vos nouvelles connaissances acquises à l’issue de chaque prosit. Les livrables des prosits seront directement des fonctionnalités du projet.

Ce projet est découpé en 6 temps :

Les phases décrites ci-dessous constituent le déroulement opérationnel du projet tout au long du bloc et correspondent aux différents temps du projet.

### Découpage du projet

Le projet est structuré en **6 phases** :

### Phase 1 – Lancement du projet

* Constitution des groupes
* Prise de connaissance du cahier des charges
* Gestion de projet :

  * application de la méthode **Scrum**,
  * répartition des rôles,
  * constitution du backlog,
  * planification des sprints et des daily meetings.

### Phase 2 – Maquettage et Frontend (HTML / CSS)

* Réalisation des **maquettes (wireframes)** des pages principales :

  * structure générale (zones de contenu, menus, en-tête, pied de page),
  * boutons et éléments d’interaction,
  * liens entre les pages.
* Définition du **parcours utilisateur** (navigation et accès aux fonctionnalités clés).
* Approche **Mobile First** et responsive design.

  * Il n’est pas nécessaire de décliner toutes les pages dans tous les formats si certaines partagent la même structure.
* Démarrage du développement **frontend**.

### Phase 3 – Développement Backend (initial)

* Démarrage du développement du backend.
* Les accès à la base de données peuvent être simulés ou mis de côté temporairement.

### Phase 4 – Modélisation et Base de données

* Conception du **MCD (Modèle Conceptuel de Données)**.
* Mise en place de la base de données.

### Phase 5 – Développement Backend (suite)

* Implémentation de :

  * l’authentification,
  * les restrictions d’accès selon les rôles.
* Connexion à la base de données.
* Écriture de **tests unitaires**.

### Phase 6 – Finalisation

* Intégration des fonctionnalités développées en **JavaScript**.

> Le projet est dimensionné pour des **groupes de 4 étudiants**.

---

## 1.2 Livrable et soutenance

Le projet se termine par une **soutenance**.

Lors de celle-ci, vous vous positionnerez comme le prestataire **Web4All**, venant présenter au client **CESI** (le jury) le résultat de sa commande.

La soutenance comprendra :

* une **présentation synthétique** (≈ 5 minutes),
* une **démonstration technique** approfondie.

Le jury pourra orienter la démonstration par des questions ciblées afin de vérifier certaines fonctionnalités ou choix techniques.

La soutenance se conclura par une phase de **questions / réponses individuelles**, permettant d’évaluer votre implication personnelle dans le projet.

---

## 2. Cahier des charges du projet

L’application web vise à **informatiser l’aide à la recherche de stages** en regroupant l’ensemble des offres disponibles et les informations liées aux entreprises.

Elle permettra notamment :

* de faciliter l’orientation des nouveaux étudiants,
* de proposer des offres classées par **compétences**,
* d’adapter l’interface selon le **profil utilisateur**.

### Profils utilisateurs

* Administrateur
* Pilote de promotion
* Étudiant

Chaque profil dispose de droits spécifiques. Les **administrateurs** ont accès à l’ensemble (ou presque) des fonctionnalités.

Le cahier des charges laisse volontairement une **marge d’interprétation** :

* zones d’ombre,
* choix fonctionnels,
* options techniques.

Il vous appartient de les analyser et de proposer la solution la plus pertinente à votre client.

Le site devra également :

* être **responsive**,
* respecter les **bonnes pratiques de développement** (frontend et backend),
* intégrer les bases de l’optimisation **SEO**,
* être **conforme légalement** (mentions légales obligatoires).

> L’utilisation d’un **serveur de base de données commun au groupe** est fortement recommandée.

---

## 2.1 Spécifications fonctionnelles

Vous trouverez dans cette section les spécifications fonctionnelles du projet. Une matrice de gestion des rôles est disponible en annexe. Le critère « data » représente les données à fournir ou que l'on peut fournir en entrée de procédure.

---

### Gestion des accès

Dans cette catégorie la fonctionnalité attendue est :

**SFx 1 – Authentification et gestion des accès**

**Description :** Cette fonctionnalité doit permettre à l'utilisateur de s'authentifier via un formulaire de connexion. On devra aussi pouvoir se déconnecter. Certaines parties du site sont publiques (accès anonymes) mais d'autres nécessitent certaines permissions (voir les différents rôles dans la matrice des permissions ci-dessous).

**Data :** [email – mot de passe – rôle et permissions (voir matrice des permissions)]

---

### Gestion des entreprises

Dans cette catégorie les fonctionnalités attendues sont :

**SFx 2 – Rechercher et afficher une entreprise**

**Description :** Cette fonctionnalité doit permettre à l'utilisateur de rechercher la fiche d'une entreprise sur la base de plusieurs critères. Il sera possible de consulter les offres liées à l'entreprise et de visualiser les différentes appréciations (entreprises / stages).

**Data :** [nom – description – email et téléphone de contact – nombre de stagiaires ayant postulé à une offre de cette entreprise – moyenne des évaluations]

**SFx 3 – Créer une entreprise**

**Description :** Cette fonctionnalité doit permettre à l'utilisateur de créer la fiche d'une entreprise.

**Data :** [nom – description – email et téléphone de contact]

**SFx 4 – Modifier une entreprise**

**Description :** Cette fonctionnalité doit permettre à l'utilisateur de modifier la fiche d'une entreprise.

**Data :** [nom – description – email et téléphone de contact]

**SFx 5 – Évaluer une entreprise**

**Description :** Cette fonctionnalité doit permettre à l'utilisateur (voir matrice) d'évaluer une entreprise qui propose des stages.

**Data :** [évaluation]

**SFx 6 – Supprimer une entreprise**

**Description :** Cette fonctionnalité doit permettre à l'utilisateur de sortir une entreprise du système afin qu'elle ne soit plus proposée aux étudiants.

---

### Gestion des offres de stage

Attention, vous devez réfléchir à la meilleure manière de gérer les compétences, il n'est pas nécessaire de pouvoir modifier la liste des compétences. Dans cette catégorie les fonctionnalités attendues sont :

**SFx 7 – Rechercher et afficher une offre**

**Description :** Cette fonctionnalité doit permettre à l'utilisateur de rechercher une offre sur la base de plusieurs critères, et affiche une offre en particulier.

**Data :** [entreprise – titre – description – compétences – base de rémunération – date de l'offre – nombre d'étudiants ayant déjà postulé à cette offre]

**SFx 8 – Créer une offre**

**Description :** Cette fonctionnalité doit permettre à l'utilisateur de créer une offre et de la paramétrer.

**Data :** [compétences – titre – description – entreprise – base de rémunération – date de l'offre]

**SFx 9 – Modifier une offre**

**Description :** Cette fonctionnalité doit permettre à l'utilisateur de modifier une offre ainsi que ses paramètres.

**Data :** [compétences – titre – description – entreprise – base de rémunération – date de l'offre]

**SFx 10 – Supprimer une offre**

**Description :** Cette fonctionnalité doit permettre à l'utilisateur de retirer du système une offre.

**SFx 11 – Consulter les statistiques des offres**

**Description :** Cette fonctionnalité doit proposer un carrousel d’informations statistiques. L’utilisateur pourra faire défiler différentes cartes présentant les indicateurs clés.

**Data :** [répartition des offres par durée de stage – top des offres les plus ajoutées en wish-list – nombre total d’offres disponibles en base – nombre moyen de candidatures par offre]

---

### Gestion des pilotes de promotions

Dans cette catégorie les fonctionnalités attendues sont :

**SFx 12 – Rechercher et afficher un compte Pilote**

**Description :** Cette fonctionnalité doit permettre à l'utilisateur de rechercher un compte Pilote.

**Data :** [nom – prénom]

**SFx 13 – Créer un compte Pilote**

**Description :** Cette fonctionnalité doit permettre à l'utilisateur de créer un compte Pilote.

**Data :** [nom – prénom]

**SFx 14 – Modifier un compte Pilote**

**Description :** Cette fonctionnalité doit permettre à l'utilisateur de modifier un compte Pilote.

**Data :** [nom – prénom]

**SFx 15 – Supprimer un compte Pilote**

**Description :** Cette fonctionnalité doit permettre à l'utilisateur de supprimer un compte Pilote.

---

### Gestion des étudiants

Dans cette catégorie les fonctionnalités attendues sont :

**SFx 16 – Rechercher et afficher un compte Étudiant**

**Description :** Cette fonctionnalité doit permettre à l'utilisateur de rechercher un compte Étudiant à partir de plusieurs critères et d'afficher ses informations, ainsi que l'état de la recherche de stage.

**Data :** [nom – prénom – email]

**SFx 17 – Créer un compte Étudiant**

**Description :** Cette fonctionnalité doit permettre à l'utilisateur de créer un compte Étudiant.

**Data :** [nom – prénom – email]

**SFx 18 – Modifier un compte Étudiant**

**Description :** Cette fonctionnalité doit permettre à l'utilisateur de modifier un compte Étudiant.

**Data :** [nom – prénom – email]

**SFx 19 – Supprimer un compte Étudiant**

**Description :** Cette fonctionnalité doit permettre à l'utilisateur de supprimer un compte Étudiant.

---

### Gestion des candidatures

Dans cette catégorie les fonctionnalités attendues sont :

**SFx 20 – Postuler à une offre**

**Description :** L'étudiant doit pouvoir postuler à une offre, accompagné d'un texte (lettre de motivation) et d'un CV.

**Data :** [offre – CV – LM]

**SFx 21 – Afficher la liste des offres pour lesquelles l'étudiant a postulé**

**Description :** L'étudiant doit pouvoir retrouver les offres auxquelles il a postulé et consulter LM et CV envoyés.

**Data :** [offre – CV – LM]

**SFx 22 – Afficher la liste des offres auxquelles les élèves du pilote ont postulé**

**Description :** Le pilote doit pouvoir consulter les offres auxquelles ses élèves ont postulés ainsi que les LM et CV envoyés.

**Data :** [offre – CV – LM]

---

### Gestion des wish-lists

Dans cette catégorie les fonctionnalités attendues sont :

**SFx 23 – Afficher les offres ajoutées à la wish-list**

**Description :** Cette fonctionnalité doit permettre à l'étudiant de voir les offres de sa wish-list.

**SFx 24 – Ajouter une offre à la wish-list**

**Description :** Cette fonctionnalité doit permettre à l'étudiant d'ajouter l'offre à sa wish-list.

**SFx 25 – Retirer une offre de la wish-list**

**Description :** Cette fonctionnalité doit permettre à l'utilisateur de retirer une offre présente dans sa liste d'intérêts.

---

### Fonctionnalités transversales

Dans cette catégorie les fonctionnalités attendues sont :

**SFx 27 – Pagination**

Chaque affichage de données pouvant recevoir de nombreux résultats (liste d'utilisateurs, d'entreprises, d'offres...) doit contenir une pagination.

**SFx 28 – Mentions légales**

Respecter la réglementation en vigueur.

**Bonus – Accès mobile du site web**

Une fois que l'application web est mise en place, il est possible de la transformer en application mobile en utilisant le PWA.

Ceci permettra à votre Web App d'être installée comme une application native (icône sur les écrans du mobile, navigation plein écran, navigation hors-ligne...).

---

## 2.2 Spécifications techniques

**STx 1 – Architecture**
Architecture **MVC obligatoire**.

**STx 2 – Conformité du code**

* Chaque page HTML doit utiliser des balises sémantiques HTML5.
* Chaque page HTML générée doit être validée par le validateur W3C.
* Le code CSS doit être structuré, lisible et cohérent.
* Côté PHP, l’usage de la **programmation orientée objet (POO)** est obligatoire.
* Le respect des conventions **PSR-12** est fortement recommandé.

**STx 3 – Contrôle des champs de saisie**
Les champs des formulaires doivent être validés :

* côté frontend (HTML / JavaScript),
* côté backend (PHP).

**STx 4 – Interdiction des CMS**
Aucun CMS ne doit être utilisé (WordPress, Drupal, Joomla, etc.).

**STx 5 – Frameworks**

* Les frameworks frontend (React, Angular, Vue.js…) et backend (Laravel, Symfony…) sont interdits.
* L’utilisation de bibliothèques JavaScript (ex : jQuery) et de préprocesseurs CSS (LESS, Sass) est autorisée.

**STx 6 – Stack technique**

* Serveur : Apache
* Frontend : HTML5 / CSS3 / JavaScript
* Backend : PHP
* Base de données : SGBD SQL (MySQL, PostgreSQL, MariaDB…)

**STx 7 – Moteur de template**
L’ensemble du site doit utiliser un moteur de template côté backend, avec une utilisation cohérente des inclusions de fragments.

**STx 8 – Clés étrangères**
Les relations de la base de données doivent exploiter des clés étrangères lorsque cela est pertinent.

**STx 9 – Virtual Host (VHost)**
Un VHost spécifique doit accueillir le contenu statique (images, CSS, JavaScript…).

**STx 10 – Responsive Design**

* L’interface doit s’adapter à toutes les tailles d’écran.
* Un **menu burger** doit être implémenté pour les écrans de petite taille.

**STx 11 – Sécurité**

* Les informations de connexion doivent être stockées dans des cookies sécurisés.
* Aucune donnée sensible ne doit être stockée en clair.
* Mise en place de protections contre les attaques courantes : SQL Injection, XSS, CSRF.
* Utilisation obligatoire du protocole **HTTPS**.

**STx 12 – SEO**

* Pages structurées avec balises HTML optimisées (title, meta description, Hn, alt).
* Utilisation de mots-clés pertinents dans les balises meta.
* Temps de chargement inférieur à 3 secondes par page.
* URLs lisibles et optimisées.
* Mise en place des fichiers **sitemap.xml** et **robots.txt**.

**STx 13 – Routage des URLs**
Le backend doit intégrer un système de routage permettant de gérer des URLs lisibles, hiérarchisées et cohérentes.

**STx 14 – Tests unitaires**
Des tests unitaires doivent être développés à l’aide de **PHPUnit** pour au moins un contrôleur.

---

## Évaluation

Toutes les spécifications fonctionnelles et techniques entrent dans l’évaluation finale.

La **participation individuelle** et l’investissement dans le travail d’équipe auront un impact significatif sur la note de soutenance.

### Ressources fournies

* Matrice des permissions – version 2025 V2.1
* Grille d’évaluation – Projet Web 2025 V1.1
