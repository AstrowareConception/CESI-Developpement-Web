<?php
/**
 * pagination.php
 * ----------------
 * Exemple complet de pagination en PHP avec un tableau d'entreprises factices.
 *
 * Pour débutants :
 *  - On prépare des données (un simple tableau PHP)
 *  - On calcule les infos de pagination (page courante, nombre total de pages)
 *  - On extrait uniquement les éléments de la page demandée
 *  - On affiche le tout dans une page HTML bien structurée
 */

// 1) Données : tableau d'entreprises (fictives mais crédibles)
$entreprises = [
    ['nom' => 'TechCorp', 'secteur' => 'Technologie', 'ville' => 'Paris'],
    ['nom' => 'FinSoft', 'secteur' => 'Finance', 'ville' => 'Londres'],
    ['nom' => 'AutoDrive', 'secteur' => 'Automobile', 'ville' => 'Berlin'],
    ['nom' => 'HexaData', 'secteur' => 'Technologie', 'ville' => 'Lyon'],
    ['nom' => 'CréditHexagone', 'secteur' => 'Banque', 'ville' => 'Paris'],
    ['nom' => 'AgriDélice', 'secteur' => 'Agroalimentaire', 'ville' => 'Rennes'],
    ['nom' => 'MediPlus', 'secteur' => 'Santé', 'ville' => 'Marseille'],
    ['nom' => 'GreenWatt', 'secteur' => 'Énergie', 'ville' => 'Nantes'],
    ['nom' => 'BatiNova', 'secteur' => 'BTP', 'ville' => 'Toulouse'],
    ['nom' => 'Mode&Chic', 'secteur' => 'Retail', 'ville' => 'Lille'],
    ['nom' => 'NeoLog', 'secteur' => 'Logistique', 'ville' => 'Bordeaux'],
    ['nom' => 'AéroLine', 'secteur' => 'Aéronautique', 'ville' => 'Toulouse'],
    ['nom' => 'BioPharmis', 'secteur' => 'Pharmaceutique', 'ville' => 'Strasbourg'],
    ['nom' => 'Riviera Hotels', 'secteur' => 'Tourisme', 'ville' => 'Nice'],
    ['nom' => 'CitéAssurances', 'secteur' => 'Assurance', 'ville' => 'Paris'],
    ['nom' => 'AquaPure', 'secteur' => 'Environnement', 'ville' => 'Montpellier'],
    ['nom' => 'SilverRail', 'secteur' => 'Transports', 'ville' => 'Lyon'],
    ['nom' => 'Gusto Italia', 'secteur' => 'Restauration', 'ville' => 'Lyon'],
    ['nom' => 'PixelForge', 'secteur' => 'Jeux vidéo', 'ville' => 'Bordeaux'],
    ['nom' => 'Cloudbrew', 'secteur' => 'Informatique', 'ville' => 'Paris'],
    ['nom' => 'TerraMarket', 'secteur' => 'E‑commerce', 'ville' => 'Nantes'],
    ['nom' => 'UrbanMove', 'secteur' => 'Mobilité', 'ville' => 'Grenoble'],
    ['nom' => 'AlpesFroid', 'secteur' => 'Chaîne du froid', 'ville' => 'Chambéry'],
    ['nom' => 'VitiValley', 'secteur' => 'Viticulture', 'ville' => 'Bordeaux'],
    ['nom' => 'LuxOptic', 'secteur' => 'Optique', 'ville' => 'Dijon'],
    ['nom' => 'HelioSolar', 'secteur' => 'Énergie', 'ville' => 'Perpignan'],
    ['nom' => 'NordShip', 'secteur' => 'Maritime', 'ville' => 'Dunkerque'],
    ['nom' => 'SécuraTech', 'secteur' => 'Cybersécurité', 'ville' => 'Paris'],
    ['nom' => 'DataRive', 'secteur' => 'Data', 'ville' => 'Lille'],
    ['nom' => 'FerroMécanique', 'secteur' => 'Industrie', 'ville' => 'Saint-Étienne'],
    ['nom' => 'ImmoSquare', 'secteur' => 'Immobilier', 'ville' => 'Lyon'],
    ['nom' => 'Pâtissier du Faubourg', 'secteur' => 'Artisanat', 'ville' => 'Paris'],
    ['nom' => 'BlueMed', 'secteur' => 'Santé', 'ville' => 'Marseille'],
    ['nom' => 'Aliméo', 'secteur' => 'Agroalimentaire', 'ville' => 'Brest'],
    ['nom' => 'Printix', 'secteur' => 'Impression', 'ville' => 'Reims'],
    ['nom' => 'Réseau&Co', 'secteur' => 'Télécoms', 'ville' => 'Paris'],
    ['nom' => 'MontBlanc Sports', 'secteur' => 'Sport', 'ville' => 'Annecy'],
    ['nom' => 'SeineCulture', 'secteur' => 'Édition', 'ville' => 'Rouen'],
    ['nom' => 'EcoTrans', 'secteur' => 'Transports', 'ville' => 'Lyon'],
    ['nom' => 'CéramArt', 'secteur' => 'Design', 'ville' => 'Limoges'],
    ['nom' => 'Argo Conseil', 'secteur' => 'Conseil', 'ville' => 'Paris'],
    ['nom' => 'NovaClinic', 'secteur' => 'Santé', 'ville' => 'Strasbourg'],
    ['nom' => 'Alto Finance', 'secteur' => 'Finance', 'ville' => 'Genève'],
    ['nom' => 'Rhone Robotics', 'secteur' => 'Robotique', 'ville' => 'Lyon'],
    ['nom' => 'Atelier Bois&Fer', 'secteur' => 'Artisanat', 'ville' => 'Tours'],
    ['nom' => 'Domotik Home', 'secteur' => 'Domotique', 'ville' => 'Nantes'],
    ['nom' => 'TerraNova Seeds', 'secteur' => 'Agriculture', 'ville' => 'Angers'],
    ['nom' => 'Azur Assur', 'secteur' => 'Assurance', 'ville' => 'Nice'],
    ['nom' => 'MetroFood', 'secteur' => 'Distribution', 'ville' => 'Lille'],
    ['nom' => 'CapCoders', 'secteur' => 'Logiciels', 'ville' => 'Bordeaux']
];

// 2) Paramètres de pagination
$itemsPerPage = 10; // 10 entreprises par page
$totalItems = count($entreprises); // nombre total d'entrées
$totalPages = (int) ceil($totalItems / $itemsPerPage); // arrondi au-dessus

require_once 'validateInput.php'; // on importe notre fonction de validation

// 3) Lecture et validation de la page actuelle depuis l'URL (?page=...)
$page = isset($_GET['page']) ? validateInput($_GET['page']) : 1; // valeur par défaut = 1
// On s'assure que c'est bien un entier >= 1
$page = (int) filter_var($page, FILTER_VALIDATE_INT, ['options' => ['default' => 1, 'min_range' => 1]]);
// On borne la page entre 1 et $totalPages (si la liste n'est pas vide)
if ($totalPages > 0) {
    if ($page > $totalPages) { $page = $totalPages; }
    if ($page < 1) { $page = 1; }
}

// 4) Calcul de l'index de départ pour extraire les éléments de la page courante
$startIndex = ($page - 1) * $itemsPerPage;

// 5) On récupère uniquement les lignes à afficher pour cette page
$currentItems = array_slice($entreprises, $startIndex, $itemsPerPage);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entreprises – Pagination</title>
    <meta name="description" content="Liste paginée d'entreprises fictives et crédibles (démonstration pagination PHP).">
    <!-- Feuille de styles commune -->
    <link rel="stylesheet" href="pagination.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Annuaire d'entreprises</h1>
            <!-- Petit récapitulatif de la pagination -->
            <p class="muted">Page <?php echo (int)$page; ?> sur <?php echo (int)$totalPages; ?> — <?php echo (int)$totalItems; ?> entrées</p>
        </header>

        <!-- Carte contenant le tableau des entreprises -->
        <section class="card" aria-labelledby="titre-tableau">
            <table>
                <!-- caption = titre accessible pour le tableau -->
                <caption id="titre-tableau">Liste des entreprises (<?php echo (int)$itemsPerPage; ?> par page)</caption>
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Secteur</th>
                        <th scope="col">Ville</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($currentItems as $entreprise): ?>
                    <tr>
                        <!-- On échappe les valeurs pour éviter toute injection -->
                        <td><?php echo htmlspecialchars($entreprise['nom'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><span class="badge"><?php echo htmlspecialchars($entreprise['secteur'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                        <td><?php echo htmlspecialchars($entreprise['ville'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- Navigation de pagination (Précédent / Numéros / Suivant) -->
        <nav aria-label="Pagination">
            <ul class="pager" role="list">
                <?php $hasPrev = $page > 1; $hasNext = $page < $totalPages; ?>
                <li>
                    <?php if ($hasPrev): ?>
                        <a href="?page=<?php echo $page - 1; ?>" rel="prev" aria-label="Page précédente">Précédent</a>
                    <?php else: ?>
                        <span class="disabled" aria-disabled="true">Précédent</span>
                    <?php endif; ?>
                </li>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li>
                        <?php if ($i === $page): ?>
                            <!-- Lien de la page courante non cliquable, marqué comme actif -->
                            <span class="active" aria-current="page"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="?page=<?php echo $i; ?>" aria-label="Aller à la page <?php echo $i; ?>"><?php echo $i; ?></a>
                        <?php endif; ?>
                    </li>
                <?php endfor; ?>

                <li>
                    <?php if ($hasNext): ?>
                        <a href="?page=<?php echo $page + 1; ?>" rel="next" aria-label="Page suivante">Suivant</a>
                    <?php else: ?>
                        <span class="disabled" aria-disabled="true">Suivant</span>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
        <p class="footer-note muted">Astuce: utilisez les liens numérotés pour accéder directement à une page spécifique.</p>
    </div>
</body>
</html>