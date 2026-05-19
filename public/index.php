<?php

/**
 * MOVEA — Page d'accueil
 *
 * Cette page présente la plateforme MOVEA et affiche
 * des informations dynamiques selon l'heure de la journée.
 *
 * @author  Votre Nom
 * @version 0.2
 */

// ====================================================================
// 1. Définition des variables du site
// ====================================================================

// Nom et slogan de la plateforme
$nomPlateforme = "MOVEA";
$slogan = "Move Africa, une course à la zone à la fois";

// Informations sur la ville pilote
$villePilote = "Douala";
$paysPilote = "Cameroun";

// Tarifs de base (en francs CFA)
$tarifBaseEnFCFA = 500;          // Prise en charge
$tarifParKmEnFCFA = 250;          // Prix au kilomètre
$tarifParMinuteEnFCFA = 50;       // Prix à la minute (attente)

// Statistiques fictives pour l'instant (on les rendra réelles plus tard)
$nombreChauffeursInscrits = 0;
$nombreCoursesEffectuees = 0;
$nombreClientsInscrits = 0;

// ====================================================================
// 2. Calcul de l'heure actuelle et du message d'accueil adapté
// ====================================================================

// La fonction date() renvoie une partie de la date/heure courante
// 'H' donne l'heure au format 24h (00 à 23)
$heureActuelle = (int) date('H');

// Construction du message d'accueil selon l'heure
if ($heureActuelle < 6) {
    $messageHoraire = "Bonne nuit";
} elseif ($heureActuelle < 12) {
    $messageHoraire = "Bonjour";
} elseif ($heureActuelle < 18) {
    $messageHoraire = "Bon après-midi";
} else {
    $messageHoraire = "Bonsoir";
}

// ====================================================================
// 3. Calcul d'un exemple de prix de course
// ====================================================================

// Exemple : un client veut faire 5 km
$distanceExempleEnKm = 5;
$dureeExempleEnMinutes = 12;

$prixCourseExemple = $tarifBaseEnFCFA
    + ($tarifParKmEnFCFA * $distanceExempleEnKm)
    + ($tarifParMinuteEnFCFA * $dureeExempleEnMinutes);

// ====================================================================
// 4. Date et heure complètes pour affichage
// ====================================================================

// setlocale et strftime sont obsolètes — on utilise date() directement
$dateDuJour = date('d/m/Y');           // Format JJ/MM/AAAA
$heureComplete = date('H:i:s');        // Format HH:MM:SS

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?php echo $nomPlateforme; ?> — Accueil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }

        h1 {
            color: #2E75B6;
            border-bottom: 3px solid #2E75B6;
            padding-bottom: 10px;
        }

        .salutation {
            font-size: 1.5em;
            color: #2E75B6;
        }

        .slogan {
            font-style: italic;
            color: #666;
        }

        .info-box {
            background: white;
            border-left: 4px solid #2E75B6;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .prix {
            font-size: 1.3em;
            font-weight: bold;
            color: #2E75B6;
        }

        footer {
            margin-top: 40px;
            color: #999;
            font-size: 0.9em;
            text-align: center;
        }
    </style>
</head>

<body>

    <h1><?= $nomPlateforme; ?></h1>

    <p class="salutation">
        <?php echo $messageHoraire; ?>, bienvenue sur la plateforme.
    </p>

    <p class="slogan"><?php echo $slogan; ?></p>

    <div class="info-box">
        <strong>Ville pilote :</strong>
        <?php echo $villePilote; ?>, <?php echo $paysPilote; ?>
    </div>

    <div class="info-box">
        <strong>Exemple de tarif</strong> pour une course de
        <?php echo $distanceExempleEnKm; ?> km
        durée
        <?php echo $dureeExempleEnMinutes; ?> minutes :
        <br>
        <span class="prix">
            <?php echo $prixCourseExemple; ?> FCFA
        </span>
        <br>
        <small>
            (Prise en charge : <?php echo $tarifBaseEnFCFA; ?> FCFA
            + Kilomètres : <?php echo $tarifParKmEnFCFA * $distanceExempleEnKm; ?> FCFA
            + Temps : <?php echo $tarifParMinuteEnFCFA * $dureeExempleEnMinutes; ?> FCFA)
        </small>
    </div>

    <div class="info-box">
        <strong>Statistiques :</strong><br>
        Chauffeurs inscrits : <?php echo $nombreChauffeursInscrits; ?><br>
        Clients inscrits : <?php echo $nombreClientsInscrits; ?><br>
        Courses effectuées : <?php echo $nombreCoursesEffectuees; ?>
    </div>

    <footer>
        Page générée le <?php echo $dateDuJour; ?>
        à <?php echo $heureComplete; ?>
        — MOVEA v0.2
    </footer>

</body>

</html>