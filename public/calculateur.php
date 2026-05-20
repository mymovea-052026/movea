<?php
require_once __DIR__ . '/../src/functions.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>MOVEA — Calculateur de prix</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
        }

        h1 {
            color: #2E75B6;
        }

        label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            margin-top: 20px;
            padding: 12px 24px;
            font-size: 1em;
            background: #2E75B6;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background: #1f5a91;
        }

        .resultat {
            margin-top: 25px;
            padding: 20px;
            background: #e8f4fd;
            border-left: 4px solid #2E75B6;
            border-radius: 4px;
        }

        .prix {
            font-size: 1.8em;
            font-weight: bold;
            color: #2E75B6;
        }
    </style>
</head>

<body>

    <h1>Calculateur de prix MOVEA</h1>
    <p>Estimez le prix de votre course avant de réserver.</p>

    <form action="calculateur.php" method="GET">
        <label for="distance">Distance (en km)</label>
        <input type="number" id="distance" name="distance" placeholder="Ex : 5" step="0.1"
            value="<?= isset($_GET['distance']) ? htmlspecialchars($_GET['distance']) : '' ?>">

        <label for="duree">Durée estimée (en minutes)</label>
        <input type="number" id="duree" name="duree" placeholder="Ex : 12"
            value="<?= isset($_GET['duree']) ? htmlspecialchars($_GET['duree']) : '' ?>">

        <button type="submit">Calculer le prix</button>
    </form>

    <?php
    // On vérifiera ici si des données ont été envoyées (étape suivante)

    // Variables pour stocker les erreurs et le résultat
    $erreurs = [];
    $prix = null;
    $distance = null;
    $duree = null;

    // On traite seulement si le formulaire a été soumis
    if (isset($_GET["distance"]) || isset($_GET["duree"])) {

        // --- Validation de la distance ---
        if (!isset($_GET["distance"]) || $_GET["distance"] === "") {
            $erreurs[] = "Veuillez saisir une distance.";
        } elseif (!is_numeric($_GET["distance"])) {
            $erreurs[] = "La distance doit être un nombre.";
        } else {
            $distance = (float) $_GET["distance"];
            if ($distance <= 0) {
                $erreurs[] = "La distance doit être supérieure à 0.";
            } elseif ($distance > 100) {
                $erreurs[] = "La distance ne peut pas dépasser 100 km.";
            }
        }

        // --- Validation de la durée ---
        if (!isset($_GET["duree"]) || $_GET["duree"] === "") {
            $erreurs[] = "Veuillez saisir une durée.";
        } elseif (!is_numeric($_GET["duree"])) {
            $erreurs[] = "La durée doit être un nombre.";
        } else {
            $duree = (int) $_GET["duree"];
            if ($duree <= 0) {
                $erreurs[] = "La durée doit être supérieure à 0.";
            } elseif ($duree > 300) {
                $erreurs[] = "La durée ne peut pas dépasser 300 minutes.";
            }
        }

        // --- Calcul SEULEMENT si aucune erreur ---
        if (count($erreurs) === 0) {
            $prix = calculerPrixCourse($distance, $duree);
        }
    }

    // --- Affichage des erreurs s'il y en a ---
    if (count($erreurs) > 0) {
        echo "<div style='background:#fdecea; border-left:4px solid #e74c3c; padding:15px; margin-top:20px; border-radius:4px;'>";
        echo "<strong>Veuillez corriger les points suivants :</strong>";
        echo "<ul>";
        foreach ($erreurs as $erreur) {
            echo "<li>$erreur</li>";
        }
        echo "</ul>";
        echo "</div>";
    }

    // --- Affichage du résultat si calcul réussi ---
    if ($prix !== null) {
        echo "<div class='resultat'>";
        echo "<p>Pour une course de <strong>$distance km</strong> ";
        echo "d'une durée de <strong>$duree minutes</strong> :</p>";
        echo "<p class='prix'>" . number_format($prix, 0, ',', ' ') . " FCFA</p>";
        echo "</div>";
    }

    ?>

</body>

</html>