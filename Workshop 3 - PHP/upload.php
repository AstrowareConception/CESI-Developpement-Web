<?php
/**
 * upload.php
 * ---------------
 * Script de traitement du formulaire d'upload (envoi de fichier).
 *
 * Objectif :
 *  - Recevoir un fichier envoyé depuis upload.html
 *  - Vérifier quelques règles de sécurité (taille, type MIME, erreurs)
 *  - Déplacer le fichier dans un dossier /uploads avec un nom unique
 *  - Afficher un message de confirmation (avec un lien pour l'ouvrir)
 */

// On vérifie que la requête est bien un POST et que le champ 'file' est présent
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    // $_FILES['file'] contient toutes les informations du fichier envoyé
    $file = $_FILES['file'];

    // $uploadDir : chemin serveur (physique) où stocker les fichiers
    $uploadDir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;

    // $uploadWebBase : chemin relatif (URL) pour créer un lien vers le fichier depuis le navigateur
    $uploadWebBase = 'uploads/';

    // Taille maximale acceptée : 2 Mo (2 * 1024 * 1024 octets)
    $maxFileSize = 2 * 1024 * 1024;

    // 1) On s'assure que le dossier de destination existe, sinon on le crée
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            // En cas d'échec de création, on arrête tout avec un message explicite
            die('Impossible de créer le répertoire de destination.');
        }
    }

    // 2) On vérifie que le dossier est accessible en écriture (droits suffisants)
    if (!is_writable($uploadDir)) {
        die('Le répertoire de destination n\'est pas accessible en écriture.');
    }

    // 3) Vérification des erreurs signalées par PHP pendant l'upload
    //    UPLOAD_ERR_OK signifie qu'il n'y a pas eu d'erreur
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die('Erreur lors du téléversement. Code : ' . $file['error']);
    }

    // 4) Contrôle de la taille : on refuse au‑delà de 2 Mo
    if ($file['size'] > $maxFileSize) {
        die('Le fichier est trop volumineux (max 2 Mo).');
    }

    // 5) Contrôle du type MIME à partir du contenu temporaire
    //    Cela réduit le risque qu'un fichier non‑PDF soit déguisé en .pdf
    $fileType = mime_content_type($file['tmp_name']);
    if ($fileType !== 'application/pdf') {
        die('Le fichier doit être au format PDF.');
    }

    // 6) Génération d'un nom unique pour éviter d'écraser un fichier existant
    //    uniqid('file_', true) crée une chaîne unique préfixée par "file_"
    $fileName = uniqid('file_', true) . '.pdf';

    // 7) Déplacement du fichier depuis le dossier temporaire vers notre dossier /uploads
    if (move_uploaded_file($file['tmp_name'], $uploadDir . $fileName)) {
        // Succès : on fournit un lien pour consulter le fichier
        echo 'Fichier téléversé avec succès ! <a href="' . $uploadWebBase . $fileName . '">Voir le fichier</a>';
    } else {
        // Échec : message d'erreur générique
        echo 'Erreur lors du déplacement du fichier.';
    }
} else {
    // Cas où le script est appelé sans POST ou sans champ 'file'
    echo 'Aucun fichier téléversé.';
}
?>