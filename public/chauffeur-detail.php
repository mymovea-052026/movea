<?php
session_start();
require_once __DIR__ . '/../src/functions.php';

// Protection : réservé aux admins connectés
exigerConnexion();

// Récupération de la liste complète
$tousLesChauffeurs = obtenirTousLesChauffeurs();

// --- Validation de l'id reçu ---
$erreur = "";
$chauffeur = null;

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    $erreur = "Identifiant de chauffeur manquant ou invalide.";
} else {
    $id = (int) $_GET["id"];

    // Vérifier que l'index existe dans le tableau
    if (isset($tousLesChauffeurs[$id])) {
        $chauffeur = $tousLesChauffeurs[$id];
    } else {
        $erreur = "Aucun chauffeur trouvé avec cet identifiant.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>MOVEA — Détail chauffeur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
        }

        h1 {
            color: #2E75B6;
        }

        a.retour {
            color: #2E75B6;
            text-decoration: none;
        }

        .fiche {
            background: #f5f5f5;
            padding: 25px;
            border-radius: 4px;
            border-left: 4px solid #2E75B6;
            margin-top: 20px;
        }

        .ligne {
            margin: 12px 0;
        }

        .ligne .label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            width: 180px;
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

        .erreur {
            background: #fdecea;
            border-left: 4px solid #e74c3c;
            padding: 15px;
            border-radius: 4px;
            color: #c0392b;
        }
    </style>
</head>

<body>

    <p><a class="retour" href="admin-chauffeurs.php">← Retour à la liste</a></p>

    <?php if ($erreur !== ""): ?>

        <div class="erreur"><?= htmlspecialchars($erreur) ?></div>

    <?php else: ?>

        <h1><?= htmlspecialchars($chauffeur["prenom"]) ?> <?= htmlspecialchars($chauffeur["nom"]) ?></h1>

        <div class="fiche">
            <div class="ligne">
                <span class="label">Ville</span>
                <?= htmlspecialchars($chauffeur["ville"]) ?>
            </div>
            <div class="ligne">
                <span class="label">Zone</span>
                <?= htmlspecialchars($chauffeur["zone"]) ?>
            </div>
            <div class="ligne">
                <span class="label">Note moyenne</span>
                ⭐ <?= $chauffeur["note"] ?>/5
            </div>
            <div class="ligne">
                <span class="label">Courses effectuées</span>
                <?= number_format($chauffeur["nombreCourses"], 0, ',', ' ') ?>
            </div>
            <div class="ligne">
                <span class="label">Statut</span>
                <?php if ($chauffeur["estActif"]): ?>
                    <span class="badge actif">Actif</span>
                <?php else: ?>
                    <span class="badge inactif">Inactif</span>
                <?php endif; ?>
            </div>
        </div>

    <?php endif; ?>

</body>

</html>