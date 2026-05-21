<?php
session_start();

// Si déjà connecté, on redirige directement vers le tableau de bord
if (isset($_SESSION["estConnecte"]) && $_SESSION["estConnecte"] === true) {
    header('Location: admin.php');
    exit;
}

// Chargement des identifiants admin
$admin = require __DIR__ . '/../config/admin.php';

$erreur = "";

// Traitement du formulaire (méthode POST car données sensibles)
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $loginSaisi    = isset($_POST["login"]) ? trim($_POST["login"]) : "";
    $motDePasseSaisi = isset($_POST["motdepasse"]) ? $_POST["motdepasse"] : "";

    // Validation basique
    if ($loginSaisi === "" || $motDePasseSaisi === "") {
        $erreur = "Veuillez remplir tous les champs.";
    } else {
        // Vérification du login ET du mot de passe
        $loginCorrect = ($loginSaisi === $admin["login"]);
        $motDePasseCorrect = password_verify($motDePasseSaisi, $admin["motDePasseHache"]);

        if ($loginCorrect && $motDePasseCorrect) {
            // Connexion réussie : on enregistre dans la session
            $_SESSION["estConnecte"] = true;
            $_SESSION["login"] = $admin["login"];

            // Redirection vers l'espace protégé
            header('Location: admin.php');
            exit;
        } else {
            // On reste volontairement vague (sécurité : ne pas dire lequel est faux)
            $erreur = "Identifiants incorrects.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>MOVEA — Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 60px auto;
            padding: 20px;
        }

        h1 {
            color: #2E75B6;
            text-align: center;
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
            width: 100%;
            padding: 12px;
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

        .erreur {
            background: #fdecea;
            border-left: 4px solid #e74c3c;
            padding: 12px;
            margin-top: 15px;
            border-radius: 4px;
            color: #c0392b;
        }
    </style>
</head>

<body>

    <h1>Connexion MOVEA</h1>

    <?php if ($erreur !== ""): ?>
        <div class="erreur"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <form action="connexion.php" method="POST">
        <label for="login">Identifiant</label>
        <input type="text" id="login" name="login"
            value="<?= isset($_POST['login']) ? htmlspecialchars($_POST['login']) : '' ?>">

        <label for="motdepasse">Mot de passe</label>
        <input type="password" id="motdepasse" name="motdepasse">

        <button type="submit">Se connecter</button>
    </form>

</body>

</html>