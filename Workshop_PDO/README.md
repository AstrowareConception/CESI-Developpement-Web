
# Workshop PDO – Accès à une base de données avec PHP

## Contrainte du workshop

Vous devez **obligatoirement utiliser PDO** pour toutes les interactions avec la base de données.

Aidez-vous de la documentation officielle disponible sur PHP.net :

https://www.php.net/manual/fr/book.pdo.php

---

# 1. Création de la base de données

Créer une base de données et exécuter le script SQL suivant (par exemple dans **phpMyAdmin**).

```sql
DROP TABLE IF EXISTS utilisateurs;

CREATE TABLE utilisateurs(
    id INT NOT NULL AUTO_INCREMENT,
    pseudo VARCHAR(30) NOT NULL,
    motDePasse VARCHAR(30) NOT NULL,
    statutAdmin BOOLEAN DEFAULT 0,
    PRIMARY KEY (id)
);

INSERT INTO utilisateurs(pseudo, motDePasse, statutAdmin) VALUES
('Gandalf', 'Maia', 1),
('Aragorn', 'Dunedain', 0),
('Legolas', 'Iluvatar', 0),
('Gimli', 'Gloin', 0),
('Frodo', 'ring', 0);
````

---

# 2. Connexion à la base de données

Ouvrir une connexion à la base de données avec **PDO**.

Vous aurez besoin de construire votre **chaîne de connexion (DSN)**.

### Questions

* Que se passe-t-il si la connexion échoue ?
* Par exemple :

    * le serveur ne répond pas
    * l'identification échoue
    * la base de données n'existe pas

### Travail demandé

Gérer **proprement ce cas d'erreur** dans votre programme.

---

# 3. Vérifier la présence d’un utilisateur

Écrire une requête SQL permettant de vérifier si l'utilisateur **"Gandalf"** est présent dans la table `utilisateurs`.

### Consignes

* Mettre la requête dans une **variable PHP**
* Exécuter la requête avec la méthode :

```
PDO::query
```

### Vérifications

* Vérifier que la requête s'est bien exécutée
* Sinon :

    * afficher un **message d'erreur**
    * **arrêter le programme**

### Résultat attendu

Si la requête a fonctionné :

Afficher si l'utilisateur **a été trouvé ou non** dans la base de données.

---

# 4. Récupérer les informations d’un utilisateur

Sur le même modèle, écrire une requête permettant de récupérer **tous les champs** de l'utilisateur **"Gandalf"**.

Afficher le champ **statutAdmin** de **trois façons différentes**, en récupérant l'enregistrement sous forme :

1. d'un **tableau indexé**
2. d'un **tableau associatif (dictionnaire)**
3. d'un **objet anonyme**

### Remarque

Vous pouvez utiliser des **commentaires de code** pour n'exécuter qu'une seule méthode à la fois.

Sinon, plusieurs appels à `fetch()` modifieront le comportement.

---

# 5. Récupérer tous les pseudos

Écrire une requête permettant de récupérer **tous les pseudos** de la table `utilisateurs`.

Afficher les résultats à l'aide d'une boucle :

```
foreach
```

---

# 6. Simuler une connexion utilisateur

Créer une requête permettant de gérer la **connexion d'un utilisateur** au site.

Le programme doit vérifier le **login** et le **mot de passe**.

Les informations sont contenues dans les variables PHP :

```php
$pseudo
$mdp
```

---

# 7. Risques liés aux entrées utilisateur

Nous allons maintenant simuler la saisie de **données inconnues**.

Les variables `$pseudo` et `$mdp` peuvent contenir **n'importe quoi**.

### Questions

* Quels sont les **risques** lors de la construction d'une requête SQL avec ces variables ?
* Imaginez des **valeurs de pseudo pouvant poser problème**.

### Travail demandé

Réaliser volontairement une **injection SQL** dans la requête de connexion.

---

# 8. Passage de paramètres entre pages PHP

Pour comprendre les différentes méthodes de transfert de données entre deux pages PHP, réalisez les étapes suivantes.

### Étape 1

Créer une page :

```
source.php
```

Elle doit contenir :

```php
$param = 'SECRET';
```

---

### Étape 2

Identifier **4 méthodes** de passage de paramètres vers une autre page (`destination.php`).

Les méthodes sont :

* GET
* POST
* SESSION
* COOKIE

---

### Étape 3

Pour chaque méthode :

Créer un **lien ou un formulaire** permettant d'envoyer `$param` vers `destination.php`.

---

### Étape 4

Dans `destination.php` :

* récupérer la valeur transmise
* l'afficher

Objectif : vérifier que le paramètre est **correctement reçu**.

---

### Étape 5

Tester avec différentes valeurs :

* caractères spéciaux
* espaces
* symboles

---

### Analyse

Discuter des différences entre les méthodes :

| Méthode | Utilisation typique            |
| ------- | ------------------------------ |
| GET     | paramètres visibles dans l'URL |
| POST    | envoi via formulaires          |
| SESSION | stockage côté serveur          |
| COOKIE  | stockage côté client           |

---

# 9. Sécurisation des requêtes

### Question

Comment gérer les problèmes de sécurité liés aux entrées utilisateur ?

### Réflexion

Quel est l'intérêt d'une **requête préparée** ?

---

# 10. Requêtes préparées avec PDO

À l'aide de :

```
PDOStatement::prepare
```

Créer une requête préparée permettant de **retourner un utilisateur en fonction de son pseudo**.

---

## Liaison des paramètres

Il existe deux méthodes pour lier les paramètres :

* `PDOStatement::bindParam`
* `PDOStatement::bindValue`

### Travail demandé

1. Expliquer la **différence** entre ces deux méthodes.
2. Écrire un code permettant de **mettre en évidence la différence de comportement** entre les deux.

