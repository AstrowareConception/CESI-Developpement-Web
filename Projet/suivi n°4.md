# Projet Web – Séance de suivi n°4

---

## Objectifs de la séance

Cette quatrième séance de suivi correspond à une phase de **montée en puissance du projet**. Elle a pour objectif de :

* consolider l’architecture technique mise en place,
* implémenter les fonctionnalités centrales du projet,
* connecter réellement l’application à la base de données,
* intégrer les notions de sécurité et de qualité logicielle.

À ce stade, le projet doit être **fonctionnel**, même s’il n’est pas encore complet.

---

## Pré-requis pour la séance

Chaque groupe doit arriver avec :

* une architecture MVC opérationnelle,
* un frontend fonctionnel (navigation + pages principales),
* un backend capable d’afficher des données dynamiques,
* un dépôt Git à jour et structuré.

---

## Déroulé de la séance

### 1. Point d’avancement technique

Échange avec chaque groupe autour de :

* l’état réel d’avancement des fonctionnalités,
* la cohérence entre frontend, backend et base de données,
* les difficultés techniques rencontrées.

Ce temps permet d’identifier rapidement les blocages critiques.

---

### 2. Implémentation des fonctionnalités majeures

Travail encadré sur les fonctionnalités centrales du projet, notamment :

* authentification des utilisateurs,
* gestion des rôles et des permissions,
* accès conditionnels aux pages et fonctionnalités,
* premières fonctionnalités complètes de gestion (entreprises, offres, comptes).

Les fonctionnalités doivent être **fonctionnelles de bout en bout**.

---

### 3. Connexion et exploitation de la base de données

Mise en œuvre concrète de la base de données :

* création des tables à partir du MCD,
* utilisation des clés étrangères,
* premières requêtes SQL réelles,
* vérification de l’intégrité des données.

L’objectif est d’abandonner définitivement les données simulées.

---

### 4. Sécurité et validation des données

Intégration progressive des bonnes pratiques de sécurité :

* validation des entrées utilisateur,
* protection contre les injections SQL,
* premières mesures contre XSS et CSRF,
* stockage sécurisé des informations sensibles.

La sécurité doit être pensée comme **une partie intégrante du projet**, pas comme un ajout final.

---

## Attendus à l’issue de la séance

À la fin de cette séance, chaque groupe doit disposer :

* de fonctionnalités clés utilisables (authentification, rôles),
* d’une application connectée à une base de données réelle,
* d’un code plus robuste et sécurisé,
* d’un projet clairement avancé et exploitable.

---

## Travail à préparer pour la séance de suivi n°5

Pour la séance suivante, chaque groupe devra :

### 1. Compléter les fonctionnalités restantes

* implémenter les SFx non encore traitées,
* améliorer l’ergonomie et la navigation,
* gérer les cas limites et erreurs.

### 2. Qualité, tests et optimisation

* commencer l’écriture de tests unitaires (PHPUnit),
* améliorer la qualité du code (lisibilité, factorisation),
* optimiser les performances de base.

### 3. Préparation de la soutenance

* structurer le discours de présentation,
* identifier les fonctionnalités à démontrer,
* préparer les arguments techniques.

---

## Objectif de la séance suivante

La séance de suivi n°5 sera consacrée à :

* la finalisation du projet,
* la validation globale des fonctionnalités,
* la préparation active de la soutenance.
