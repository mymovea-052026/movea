<?php
session_start();
require_once __DIR__ . '/../src/functions.php';

// Protection : réservé aux admins connectés
exigerConnexion();

// Récupération de toutes les données
$tousLesChauffeurs = obtenirTousLesChauffeurs();

// --- Récupération et validation des filtres (méthode GET) ---
$filtreVille  = isset($_GET["ville"]) ? trim($_GET["ville"]) : "";
$filtreStatut = isset($_GET["statut"]) ? $_GET["statut"] : "";
$filtreNoteMin = 0;

if (isset($_GET["note_min"]) && is_numeric($_GET["note_min"])) {
    $filtreNoteMin = (float) $_GET["note_min"];
    // On borne entre 0 et 5
    if ($filtreNoteMin < 0) $filtreNoteMin = 0;
    if ($filtreNoteMin > 5) $filtreNoteMin = 5;
}

// On valide le statut (seules 3 valeurs acceptées)
if (!in_array($filtreStatut, ["", "actif", "inactif"], true)) {
    $filtreStatut = "";
}

// --- Application des filtres ---
$chauffeursFiltres = filtrerChauffeurs(
    $tousLesChauffeurs,
    $filtreVille,
    $filtreStatut,
    $filtreNoteMin
);

// --- Calcul des statistiques sur les résultats filtrés ---
$stats = calculerStatistiques($chauffeursFiltres);

$login = $_SESSION["login"];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>MOVEA — Gestion des chauffeurs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            color: #333;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #2E75B6;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        h1 {
            color: #2E75B6;
            margin: 0;
        }

        .deconnexion {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
        }

        .filtres {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .filtres form {
            display: flex;
            gap: 15px;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .champ {
            display: flex;
            flex-direction: column;
        }

        .champ label {
            font-weight: bold;
            font-size: 0.9em;
            margin-bottom: 5px;
        }

        .champ input,
        .champ select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 9px 18px;
            background: #2E75B6;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .reset {
            background: #999;
            text-decoration: none;
            color: white;
            padding: 9px 18px;
            border-radius: 4px;
        }

        .stats {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .stat {
            flex: 1;
            min-width: 150px;
            background: #e8f4fd;
            padding: 15px;
            border-radius: 4px;
            text-align: center;
            border-left: 4px solid #2E75B6;
        }

        .stat .nombre {
            font-size: 1.6em;
            font-weight: bold;
            color: #2E75B6;
        }

        .stat .label {
            font-size: 0.85em;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #2E75B6;
            color: white;
        }

        tr:hover {
            background: #f9f9f9;
        }

        .badge {
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.85em;
            font-weight: bold;
        }

        .badge.actif {
            background: #d5f4e6;
            color: #27ae60;
        }

        .badge.inactif {
            background: #fdecea;
            color: #e74c3c;
        }

        .note {
            color: #f39c12;
            font-weight: bold;
        }

        .aucun {
            padding: 30px;
            text-align: center;
            color: #999;
            font-style: italic;
        }
    </style>
</head>

<body>

    <div class="topbar">
        <h1>Gestion des chauffeurs</h1>
        <div>
            <span><?= htmlspecialchars($login) ?></span> —
            <a class="deconnexion" href="deconnexion.php">Se déconnecter</a>
        </div>
    </div>

    <!-- FILTRES -->
    <div class="filtres">
        <form action="admin-chauffeurs.php" method="GET">
            <div class="champ">
                <label for="ville">Ville</label>
                <input type="text" id="ville" name="ville" placeholder="Toutes"
                    value="<?= htmlspecialchars($filtreVille) ?>">
            </div>

            <div class="champ">
                <label for="statut">Statut</label>
                <select id="statut" name="statut">
                    <option value="" <?= $filtreStatut === "" ? 'selected' : '' ?>>Tous</option>
                    <option value="actif" <?= $filtreStatut === "actif" ? 'selected' : '' ?>>Actifs</option>
                    <option value="inactif" <?= $filtreStatut === "inactif" ? 'selected' : '' ?>>Inactifs</option>
                </select>
            </div>

            <div class="champ">
                <label for="note_min">Note minimale</label>
                <input type="number" id="note_min" name="note_min" step="0.1" min="0" max="5" placeholder="0"
                    value="<?= $filtreNoteMin > 0 ? htmlspecialchars($filtreNoteMin) : '' ?>">
            </div>

            <button type="submit">Filtrer</button>
            <a class="reset" href="admin-chauffeurs.php">Réinitialiser</a>
        </form>
    </div>

    <!-- STATISTIQUES -->
    <div class="stats">
        <div class="stat">
            <div class="nombre"><?= $stats["total"] ?></div>
            <div class="label">Chauffeurs affichés</div>
        </div>
        <div class="stat">
            <div class="nombre"><?= $stats["actifs"] ?></div>
            <div class="label">Actifs</div>
        </div>
        <div class="stat">
            <div class="nombre"><?= number_format($stats["noteMoyenne"], 2) ?></div>
            <div class="label">Note moyenne</div>
        </div>
        <div class="stat">
            <div class="nombre"><?= number_format($stats["totalCourses"], 0, ',', ' ') ?></div>
            <div class="label">Courses cumulées</div>
        </div>
    </div>

    <!-- TABLEAU DES CHAUFFEURS -->
    <?php if (count($chauffeursFiltres) === 0): ?>
        <p class="aucun">Aucun chauffeur ne correspond à ces critères.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Ville</th>
                    <th>Zone</th>
                    <th>Note</th>
                    <th>Courses</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chauffeursFiltres as $chauffeur): ?>
                    <tr>
                        <td><?= htmlspecialchars($chauffeur["prenom"]) ?> <?= htmlspecialchars($chauffeur["nom"]) ?></td>
                        <td><?= htmlspecialchars($chauffeur["ville"]) ?></td>
                        <td><?= htmlspecialchars($chauffeur["zone"]) ?></td>
                        <td class="note">⭐ <?= $chauffeur["note"] ?></td>
                        <td><?= number_format($chauffeur["nombreCourses"], 0, ',', ' ') ?></td>
                        <td>
                            <?php if ($chauffeur["estActif"]): ?>
                                <span class="badge actif">Actif</span>
                            <?php else: ?>
                                <span class="badge inactif">Inactif</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>

</html>