# Réponses au Workshop - Partie 1 : Testons l’application 📚Bookshop

## 1.1 Préambule sur les tests

### ❓ Quelles classes vont faire l’objet de tests dans ce projet ?
Dans ce projet, les classes qui font l’objet de tests sont les classes métiers de l'application Bookshop : `Book` (livre) et `Library` (bibliothèque), situées dans le répertoire `src/`.

### ❓ Où sont écrits les tests ?
Les tests sont écrits dans le répertoire `tests/`. On y trouve les fichiers `BookTest.php` et `LibraryTest.php`.

### ❓ D’après la documentation de PHPUnit, quelle est la convention pour définir le nom des classes de test ? De quelle classe, les classes de tests doivent-elles hériter ? Comment sont nommées les méthodes d’une classe de test ?
- **Convention de nommage :** Le nom de la classe de test doit correspondre au nom de la classe testée suivi du suffixe `Test` (ex: `Book` devient `BookTest`).
- **Héritage :** Les classes de tests doivent hériter de `PHPUnit\Framework\TestCase`.
- **Nom des méthodes :** Les méthodes de test doivent être publiques et leur nom doit commencer par le préfixe `test` (ex: `testAddBook`).

### ❓ Comment vérifie-t-on dans un test unitaire (écrit avec PHPUnit) qu’une valeur obtenue correspond bien à la valeur attendue ?
On utilise des **assertions**, qui sont des méthodes héritées de `TestCase`. La plus courante est `$this->assertSame($expected, $actual)` pour vérifier l'égalité stricte, ou `$this->assertEquals($expected, $actual)`.

### ❓ Quelle commande permet d’exécuter les tests ?
La commande standard à la racine du projet est :
`.\vendor\bin\phpunit`

On peut également spécifier un dossier ou utiliser l'option `--testdox` pour un affichage lisible :
`.\vendor\bin\phpunit tests --testdox`

---

## 1.2 Réalisation des tests unitaires de la classe Book

### ❓ Au début de chaque test, il faut instancier un nouvel objet Book, comment pouvons-nous éviter cette répétition dans le code ?
Pour éviter de réinstancier l'objet `Book` manuellement dans chaque méthode de test, on utilise la méthode spéciale `protected function setUp(): void`. 

Cette méthode est exécutée automatiquement par PHPUnit avant le lancement de **chaque** méthode de test. On y initialise alors l'objet dans une propriété de la classe (ex: `$this->book = new Book(...);`), ce qui permet de l'utiliser directement dans toutes les méthodes `test...` via `$this->book`.
