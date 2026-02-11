<?php
/**
 * validateInput
 * -----------------
 * Petite fonction utilitaire qui « nettoie » et valide une entrée utilisateur
 * (ex. valeurs récupérées dans $_GET ou $_POST) afin d'éviter des
 * problèmes de sécurité et des erreurs d'exécution.
 *
 * Étapes effectuées :
 * 1) trim            → retire les espaces au début et à la fin.
 * 2) htmlspecialchars→ échappe les caractères spéciaux HTML (ex. <, >, ", ').
 * 3) preg_match      → vérifie que la chaîne ne contient que des lettres,
 *                      des chiffres, des espaces et des tirets.
 *
 * @param string $input Chaîne à valider (potentiellement fournie par l'utilisateur)
 * @return string       Chaîne nettoyée et validée
 */
function validateInput($input) {
    // 1) On supprime les espaces inutiles autour de la chaîne
    $input = trim($input);

    // 2) On échappe les caractères spéciaux pour éviter l'injection HTML/XSS
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

    // 3) On contrôle le contenu : uniquement lettres/chiffres/espaces/tirets
    // La regex ^[a-zA-Z0-9\s\-]+$ signifie :
    //  - ^ et $ : début et fin de chaîne
    //  - [a-zA-Z0-9\s\-]+ : un ou plusieurs caractères parmi lettres, chiffres, espace, tiret
    // Le modificateur 'u' indique que la chaîne est en UTF‑8
    if (!preg_match('/^[a-zA-Z0-9\s\-]+$/u', $input)) {
        // En cas d'entrée invalide, on interrompt le script avec un message simple
        die('Entrée invalide.');
    }

    // Si tout va bien, on renvoie la valeur nettoyée
    return $input;
}
?>