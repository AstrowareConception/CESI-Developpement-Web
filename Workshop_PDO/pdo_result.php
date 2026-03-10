<pre> 
<?php
//------------------------------------------------
// 1. Connexion à la base de données (BDD).
// Pourquoi ? Établir un pont entre PHP et le serveur MySQL pour échanger des données.
// Résultat : Un objet PDO ($bdd) utilisable pour nos requêtes.
//------------------------------------------------
try {
    // Connexion avec DSN (Type:hôte;NomBDD;Encodage), Utilisateur, Mot de passe.
    $bdd = new PDO('mysql:host=localhost;dbname=WS6;charset=utf8','root','');
    
    // Configuration du mode d'erreur pour lancer des exceptions.
    // Pourquoi ? Facilite le débogage en arrêtant le script sur une erreur SQL précise.
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    echo $e->getMessage()."\n";
    die;
}







//------------------------------------------------
// 2. Exécution d'une requête simple (SELECT) et vérification de présence.
// Pourquoi ? Vérifier rapidement si une donnée spécifique existe sans récupérer de colonnes lourdes.
// Résultat : Affiche un message selon que l'utilisateur existe ou non.
//------------------------------------------------
$req_str = "SELECT * FROM utilisateurs WHERE pseudo='Gandalf'";
$stmt = $bdd->query($req_str); // query() exécute la requête immédiatement.

if (!$stmt) {
    echo "erreur de requête : $req_str\n";
    die;
}

if ($stmt->fetch()) // fetch() tente de récupérer la première ligne trouvée.
{
    echo "Utilisateur Gandalf présent dans la base\n";
    // closeCursor() libère la connexion pour permettre d'autres requêtes.
    // C'est une bonne pratique, surtout avant d'autres appels à la BDD.
    $stmt->closeCursor();
}
else
    echo "Utilisateur Gandalf introuvable dans la base\n";






//------------------------------------------------
// 3. Récupération de données sous différentes formes.
// Pourquoi ? PDO permet d'accéder aux données selon vos besoins (index, nom, objet).
// Résultat : Accès aux colonnes 'pseudo' et 'statutAdmin' via 3 syntaxes différentes.
//------------------------------------------------
$req_str = "SELECT * FROM utilisateurs WHERE pseudo='Gandalf'";
$stmt = $bdd->query($req_str);

if ($premiereLigne = $stmt->fetch(PDO::FETCH_LAZY)) {
    // FETCH_LAZY combine les accès tableau et objet sans surconsommer de mémoire.
    
    // Accès par index numérique (position de la colonne dans le SELECT *)
    echo $premiereLigne[1]." admin ? ".$premiereLigne[3]."\n";
    
    // Accès par dictionnaire / tableau associatif (nom de la colonne)
    echo $premiereLigne['pseudo']." admin ? ".$premiereLigne['statutAdmin']."\n";
    
    // Accès par objet (propriété portant le nom de la colonne)
    echo $premiereLigne->pseudo." admin ? ".$premiereLigne->statutAdmin."\n";
    
    $stmt->closeCursor();
}
else
    echo "Utilisateur Gandalf introuvable dans la base\n";









//------------------------------------------------
// 4. Parcourir tous les résultats d'une requête.
// Pourquoi ? Lister plusieurs éléments (ex: tous les pseudos enregistrés).
// Résultat : Affichage de chaque pseudo trouvé dans la table utilisateurs.
//------------------------------------------------
$req_str ="SELECT pseudo FROM utilisateurs";
if (!$stmt = $bdd->query($req_str)) {
    echo "erreur de requête : $req_str\n";
    die;
}

// PDOStatement est "Traversable" : on peut boucler dessus directement.
// Chaque itération fait un fetch() interne automatiquement.
foreach ($stmt as $i=>$ligne) 
{
    echo "ligne $i :".$ligne['pseudo']."\n";
}
$stmt->closeCursor();

//------------------------------------------------
// 5. Simulation de connexion sécurisée (simple SELECT).
// Pourquoi ? Comparer un pseudo et un mot de passe fournis.
//------------------------------------------------
$pseudo = 'Gandalf';
$mdp = 'Maia';
// Danger : Injection possible ici car les variables sont concaténées directement.
$req_str = "SELECT 1 FROM utilisateurs WHERE pseudo='$pseudo' AND motDePasse='$mdp'";
if (!$stmt  = $bdd->query($req_str)) {
    echo "erreur de requête : $req_str\n";
    die;
}
if ($stmt->fetch())
    echo "Connexion de $pseudo réussie avec le mot de passe $mdp\n";
else
    echo "Connexion échouée\n";
$stmt->closeCursor();

//------------------------------------------------
//Cas d'erreur possible dans le code précédent si on prend par exemple
//------------------------------------------------
/*
$pseudo ="Charles d'Artigue";
$mdp = 'Maia';
$req_str = "SELECT 1 FROM utilisateurs WHERE pseudo='$pseudo' AND motDePasse='$mdp'";
if (!$stmt  = $bdd->query($req_str)) {
    echo "erreur de requête : $req_str\n";
}
else
{
    if ($stmt->fetch()) {
        echo "Connexion de $pseudo réussie avec le mot de passe $mdp\n";
        $stmt->closeCursor();
    }
    else
        echo "Connexion échouée\n";
}
*/
//------------------------------------------------
// 6. Démonstration d'une Injection SQL.
// Pourquoi ? Montrer comment un attaquant peut contourner la sécurité si on concatène les variables.
// Résultat : La requête devient "pseudo='Gandalf' -- ' AND motDePasse=...", ce qui commente la fin.
// L'attaquant se connecte SANS connaître le mot de passe !
//------------------------------------------------
$pseudo = "Gandalf' -- "; // La chaîne magique qui casse la requête SQL.
$mdp = 'Mauvais mot de passe';
$req_str= "SELECT 1 FROM utilisateurs WHERE pseudo='$pseudo' AND motDePasse='$mdp'";

if ($stmt = $bdd->query($req_str)) {
    if ($stmt->fetch()) {
        echo "INJECTION RÉUSSIE : Connexion de $pseudo acceptée sans le bon mot de passe !\n";
    }
    $stmt->closeCursor();
}

//------------------------------------------------
// 7. Protection manuelle avec PDO::quote().
// Pourquoi ? Échapper les caractères dangereux (comme l'apostrophe) pour sécuriser la requête.
// Résultat : L'injection échoue car les caractères spéciaux sont neutralisés.
//------------------------------------------------
$pseudo = "Gandalf' -- ";
$mdp = 'Mauvais mot de passe';
// bdd->quote() ajoute les guillemets et échappe les caractères internes.
$req_str= "SELECT 1 FROM utilisateurs WHERE pseudo=".$bdd->quote($pseudo)." AND motDePasse=".$bdd->quote($mdp);

if ($stmt = $bdd->query($req_str)) {
    if ($stmt->fetch()) {
        echo "Connexion réussie\n";
    } else {
        echo "Échec de connexion (Protection quote() active) : l'injection a échoué.\n";
    }
    $stmt->closeCursor();
}


//------------------------------------------------
// 8. Requêtes préparées : bindValue vs bindParam.
// Pourquoi ? C'est LA méthode recommandée. Elle sépare la structure SQL des données.
//------------------------------------------------

// A. bindValue() : La valeur est liée AU MOMENT de l'appel.
// Résultat : On cherche 'Gandalf' même si on change $pseudo juste après.
$pseudo = 'Gandalf';
$req_str = "SELECT pseudo FROM utilisateurs WHERE pseudo=:pseudo";
$stmt = $bdd->prepare($req_str);
$stmt->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
$pseudo = 'Gimli'; // Ce changement n'affectera pas la requête déjà liée.

$stmt->execute();
if ($premiereLigne = $stmt->fetch()) 
    echo "bindValue a cherché : ".$premiereLigne['pseudo']."\n";

// B. bindParam() : La variable est liée par RÉFÉRENCE.
// Pourquoi ? Utile pour exécuter plusieurs fois la même requête avec des valeurs changeantes.
// Résultat : On cherche 'Gimli' car la valeur est lue au moment de l'execute().
$pseudo = 'Gandalf';
$req_str = "SELECT pseudo FROM utilisateurs WHERE pseudo=:pseudo";
$stmt = $bdd->prepare($req_str);
$stmt->bindParam(':pseudo', $pseudo);
$pseudo = 'Gimli'; // La requête utilisera cette valeur lors de l'execute().

$stmt->execute();
if ($premiereLigne = $stmt->fetch()) 
    echo "bindParam a cherché : ".$premiereLigne['pseudo']."\n";

// Autre exemple d'interet du bindParam et de l'utilisation d'une requete préparée
$req_str = "SELECT pseudo FROM utilisateurs WHERE pseudo=:pseudo";
$stmt = $bdd->prepare($req_str);
$stmt->bindParam(':pseudo', $pseudo);
$pseudos = ['Frodo','Aragorn','Legolas'];
foreach ($pseudos as $pseudo)
{
    if (!$stmt->execute())
        echo "erreur de requête : $stmt->queryString\n";
    elseif ($premiereLigne = $stmt->fetch()) echo $premiereLigne['pseudo']."\n";
}

//------------------------------------------------
// 9. Gestion propre des erreurs avec try/catch.
// Pourquoi ? Éviter que le script s'arrête brutalement et capturer l'erreur pour la traiter.
// Résultat : Si une erreur survient (ex: table inexistante), on affiche un message propre.
//------------------------------------------------
$pseudo = 'Frodo';
try {
    $req_str = "SELECT pseudo FROM utilisateurs WHERE pseudo=:pseudo";
    $stmt = $bdd->prepare($req_str);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->execute();
    
    if ($premiereLigne = $stmt->fetch()) {
        echo "Résultat final : " . $premiereLigne['pseudo'] . "\n";
    }
} catch (PDOException $e) {
    // On capture l'exception PDO et on affiche son message.
    echo 'Erreur lors de l\'exécution : ' . $e->getMessage();
}
