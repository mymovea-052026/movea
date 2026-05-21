<?php

/**
 * MOVEA — Page d'accueil (Jour 3 — refactorée avec fonctions)
 */

require_once __DIR__ . '/../src/functions.php';

// ====================================================================
// DONNÉES (plus tard : remplacées par la base de données)
// ====================================================================

$chauffeurs = [
    [
        "prenom" => "Jean",
        "nom" => "Dupont",
        "ville"  => "Douala",
        "zone" => "Bonapriso",
        "note"   => 4.8,
        "nombreCourses" => 247,
        "estActif" => true,
    ],
    [
        "prenom" => "Aïcha",
        "nom" => "Mbarga",
        "ville"  => "Douala",
        "zone" => "Akwa",
        "note"   => 4.9,
        "nombreCourses" => 312,
        "estActif" => true,
    ],
    [
        "prenom" => "Paul",
        "nom" => "Nguemo",
        "ville"  => "Douala",
        "zone" => "Bonamoussadi",
        "note"   => 4.2,
        "nombreCourses" => 89,
        "estActif" => false,
    ],
    [
        "prenom" => "Marie",
        "nom" => "Eyenga",
        "ville"  => "Yaoundé",
        "zone" => "Bastos",
        "note"   => 4.7,
        "nombreCourses" => 156,
        "estActif" => true,
    ],
];

// ====================================================================
// CALCULS (via les fonctions de src/functions.php)
// ====================================================================

$heureActuelle    = (int) date('H');
$messageAccueil   = obtenirMessageHoraire($heureActuelle);
$prixExemple      = calculerPrixCourse(5, 12);
$noteMoyenne      = calculerNoteMoyenne($chauffeurs);
$chauffeursActifs = compterChauffeursActifs($chauffeurs);

$dateDuJour    = date('d/m/Y');
$heureComplete = date('H:i:s');

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>MOVEA — Move Africa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background: #f5f5f5;
            color: #333;
        }

        h1 {
            color: #2E75B6;
            border-bottom: 3px solid #2E75B6;
            padding-bottom: 10px;
        }

        h2 {
            color: #2E75B6;
            margin-top: 30px;
        }

        .slogan {
            font-style: italic;
            color: #666;
        }

        .stats {
            display: flex;
            gap: 15px;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .stat {
            flex: 1;
            min-width: 200px;
            background: white;
            padding: 20px;
            border-radius: 4px;
            text-align: center;
            border-left: 4px solid #2E75B6;
        }

        .stat .nombre {
            font-size: 1.8em;
            font-weight: bold;
            color: #2E75B6;
        }

        .stat .label {
            color: #666;
            font-size: 0.9em;
            margin-top: 5px;
        }

        .chauffeur {
            background: white;
            border: 1px solid #ddd;
            border-left: 4px solid #27ae60;
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
        }

        .chauffeur.inactif {
            border-left-color: #e74c3c;
            opacity: 0.6;
        }

        .note {
            color: #f39c12;
            font-weight: bold;
        }

        footer {
            margin-top: 40px;
            text-align: center;
            color: #999;
            font-size: 0.9em;
        }
    </style>
</head>

<body>

    <h1>MOVEA</h1>
    <p class="slogan">Move Africa, une course à la zone à la fois</p>
    <p><a href="calculateur.php" style="color:#2E75B6; font-weight:bold;">→ Estimer le prix d'une course</a></p>
    <p><strong><?= $messageAccueil ?></strong>, bienvenue sur la plateforme.</p>

    <h2>Notre activité aujourd'hui</h2>

    <div class="stats">
        <div class="stat">
            <div class="nombre"><?= count($chauffeurs) ?></div>
            <div class="label">Chauffeurs inscrits</div>
        </div>
        <div class="stat">
            <div class="nombre"><?= $chauffeursActifs ?></div>
            <div class="label">Actuellement actifs</div>
        </div>
        <div class="stat">
            <div class="nombre"><?= number_format($noteMoyenne, 2) ?></div>
            <div class="label">Note moyenne /5</div>
        </div>
        <div class="stat">
            <div class="nombre"><?= $prixExemple ?></div>
            <div class="label">Prix course exemple (FCFA)</div>
        </div>
    </div>

    <h2>Nos chauffeurs</h2>

    <?php foreach ($chauffeurs as $chauffeur): ?>
        <?php $classe = $chauffeur["estActif"] ? "" : "inactif"; ?>
        <div class="chauffeur <?= $classe ?>">
            <h3>
                <?= $chauffeur["prenom"] ?> <?= $chauffeur["nom"] ?>
                <?php if (!$chauffeur["estActif"]): ?>
                    <small>(inactif)</small>
                <?php endif; ?>
            </h3>
            <p>
                📍 <?= $chauffeur["ville"] ?>, zone <?= $chauffeur["zone"] ?><br>
                <span class="note">⭐ <?= $chauffeur["note"] ?>/5</span>
                — <?= $chauffeur["nombreCourses"] ?> courses
            </p>
        </div>
    <?php endforeach; ?>

    <footer>
        Page générée le <?= $dateDuJour ?> à <?= $heureComplete ?> — MOVEA v0.3
        <br><a href="connexion.php" style="color:#999;">Espace administration</a>
    </footer>

</body>

</html>