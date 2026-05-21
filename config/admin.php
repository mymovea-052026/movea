<?php

/**
 * config/admin.php — Identifiants de l'administrateur (temporaire)
 *
 * En semaine 3, ces données viendront d'une table MySQL "utilisateurs".
 * Pour l'instant, un seul admin défini en dur, avec mot de passe haché.
 */

$motDePasse = "movea2026"; // Choisissez votre mot de passe admin
$hache = password_hash($motDePasse, PASSWORD_DEFAULT);

// Remplacez la valeur de "motDePasseHache" par le hachage généré à l'étape 5.4
return [
    "login"          => "admin",
    "motDePasseHache" => "$hache",
];
