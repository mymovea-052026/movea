<?php
session_start();
require_once __DIR__ . '/../src/functions.php';

// LIGNE DE PROTECTION : si non connecté, on est redirigé avant tout affichage
exigerConnexion();

// À partir d'ici, on est certain que l'utilisateur est connecté
$login = $_SESSION["login"];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>MOVEA — Administration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
        }

        h1 {
            color: #2E75B6;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #2E75B6;
            padding-bottom: 10px;
        }

        .deconnexion {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
        }

        .carte {
            background: #f5f5f5;
            padding: 20px;
            margin: 15px 0;
            border-radius: 4px;
            border-left: 4px solid #2E75B6;
        }
    </style>
</head>

<body>

    <div class="topbar">
        <h1>Espace Administration</h1>
        <a class="deconnexion" href="deconnexion.php">Se déconnecter</a>
    </div>

    <p>Bienvenue, <strong><?= htmlspecialchars($login) ?></strong> 👋</p>

    <div class="carte">
        <h2>Tableau de bord</h2>
        <p>Cette page est protégée. Seuls les administrateurs connectés peuvent la voir.</p>
        <p>Plus tard, on affichera ici les vraies statistiques de MOVEA :
            nombre de courses du jour, chauffeurs actifs, revenus, etc.</p>

        <p><a href="admin-chauffeurs.php" style="color:#2E75B6; font-weight:bold;">→ Gérer les chauffeurs</a></p>
    </div>

    <div class="carte">
        <h2>Actions à venir</h2>
        <p>En semaine 3 (base de données), cet espace permettra de :</p>
        <ul>
            <li>Gérer les chauffeurs (ajouter, modifier, suspendre)</li>
            <li>Consulter les courses</li>
            <li>Configurer les zones et les tarifs</li>
        </ul>
    </div>

</body>

</html>