<?php

/**
 * functions.php — Fonctions utilitaires de MOVEA
 *
 * Ce fichier rassemble les fonctions utilisées par plusieurs pages.
 * Inclure avec : require_once __DIR__ . '/../src/functions.php';
 */

/**
 * Calcule le prix d'une course MOVEA.
 *
 * @param  float $distanceEnKm
 * @param  int   $dureeEnMinutes
 * @return int   Prix en FCFA
 */
function calculerPrixCourse($distanceEnKm, $dureeEnMinutes)
{
    $tarifBase = 500;
    $tarifParKm = 250;
    $tarifParMinute = 50;

    return $tarifBase
        + ($tarifParKm * $distanceEnKm)
        + ($tarifParMinute * $dureeEnMinutes);
}

/**
 * Renvoie un message d'accueil selon l'heure.
 *
 * @param  int    $heure  0 à 23
 * @return string
 */
function obtenirMessageHoraire($heure)
{
    if ($heure < 6)  return "Bonne nuit";
    if ($heure < 12) return "Bonjour";
    if ($heure < 18) return "Bon après-midi";
    return "Bonsoir";
}

/**
 * Calcule la note moyenne d'une liste de chauffeurs.
 *
 * @param  array $chauffeurs
 * @return float
 */
function calculerNoteMoyenne($chauffeurs)
{
    if (count($chauffeurs) === 0) return 0;

    $somme = 0;
    foreach ($chauffeurs as $c) {
        $somme += $c["note"];
    }

    return $somme / count($chauffeurs);
}

/**
 * Compte le nombre de chauffeurs actifs.
 *
 * @param  array $chauffeurs
 * @return int
 */
function compterChauffeursActifs($chauffeurs)
{
    $compteur = 0;
    foreach ($chauffeurs as $c) {
        if ($c["estActif"]) $compteur++;
    }
    return $compteur;
}

/**
 * Calcule le prix d'une course avec application d'un multiplicateur de surge.
 *
 * Le surge (tarification dynamique) augmente le prix en période de forte
 * demande. Il est plafonné à 2.5x pour des raisons éthiques.
 *
 * @param  float $distanceEnKm    Distance de la course en km
 * @param  int   $dureeEnMinutes  Durée estimée en minutes
 * @param  float $surge           Multiplicateur (1.0 = normal, max 2.5)
 * @return int                    Prix final en FCFA, arrondi
 */
function calculerPrixAvecSurge($distanceEnKm, $dureeEnMinutes, $surge = 1.0)
{
    // Plafond éthique : on ne dépasse jamais 2.5x
    if ($surge > 2.5) {
        $surge = 2.5;
    }
    // Plancher : le surge ne peut pas réduire le prix sous le tarif normal
    if ($surge < 1.0) {
        $surge = 1.0;
    }

    // On réutilise la fonction de prix de base existante (principe DRY)
    $prixBase = calculerPrixCourse($distanceEnKm, $dureeEnMinutes);

    // On applique le multiplicateur et on arrondit à l'entier
    $prixFinal = round($prixBase * $surge);

    return $prixFinal;
}

/**
 * Vérifie que l'utilisateur est connecté.
 * Si non, redirige vers la page de connexion et arrête le script.
 *
 * À appeler en haut de chaque page protégée, APRÈS session_start().
 *
 * @return void
 */
function exigerConnexion()
{
    if (!isset($_SESSION["estConnecte"]) || $_SESSION["estConnecte"] !== true) {
        header('Location: connexion.php');
        exit;
    }
}


// Ajouter apres le cours

/**
 * Renvoie la liste complète des chauffeurs (données de test).
 * En semaine 3, ces données viendront de la base MySQL.
 *
 * @return array
 */
function obtenirTousLesChauffeurs()
{
    return [
        ["prenom" => "Jean",   "nom" => "Dupont", "ville" => "Douala",  "zone" => "Bonapriso",    "note" => 4.8, "nombreCourses" => 247, "estActif" => true],
        ["prenom" => "Aïcha",  "nom" => "Mbarga", "ville" => "Douala",  "zone" => "Akwa",         "note" => 4.9, "nombreCourses" => 312, "estActif" => true],
        ["prenom" => "Paul",   "nom" => "Nguemo", "ville" => "Douala",  "zone" => "Bonamoussadi", "note" => 4.2, "nombreCourses" => 89,  "estActif" => false],
        ["prenom" => "Marie",  "nom" => "Eyenga", "ville" => "Yaoundé", "zone" => "Bastos",       "note" => 4.7, "nombreCourses" => 156, "estActif" => true],
        ["prenom" => "Samuel", "nom" => "Fotso",  "ville" => "Douala",  "zone" => "Deido",        "note" => 4.5, "nombreCourses" => 198, "estActif" => true],
        ["prenom" => "Estelle", "nom" => "Kamga",  "ville" => "Yaoundé", "zone" => "Mvan",         "note" => 3.9, "nombreCourses" => 54,  "estActif" => false],
        ["prenom" => "Brice",  "nom" => "Talla",  "ville" => "Douala",  "zone" => "Bonapriso",    "note" => 4.6, "nombreCourses" => 271, "estActif" => true],
    ];
}

/**
 * Filtre une liste de chauffeurs selon des critères optionnels.
 *
 * @param  array  $chauffeurs  La liste à filtrer
 * @param  string $ville       Ville recherchée (vide = toutes)
 * @param  string $statut      "actif", "inactif" ou "" (tous)
 * @param  float  $noteMin     Note minimale (0 = pas de filtre)
 * @return array               La liste filtrée
 */
function filtrerChauffeurs($chauffeurs, $ville = "", $statut = "", $noteMin = 0)
{
    $resultats = [];

    foreach ($chauffeurs as $chauffeur) {
        // Filtre ville (insensible à la casse)
        if ($ville !== "" && strcasecmp($chauffeur["ville"], $ville) !== 0) {
            continue; // on saute ce chauffeur
        }

        // Filtre statut
        if ($statut === "actif" && !$chauffeur["estActif"]) {
            continue;
        }
        if ($statut === "inactif" && $chauffeur["estActif"]) {
            continue;
        }

        // Filtre note minimale
        if ($noteMin > 0 && $chauffeur["note"] < $noteMin) {
            continue;
        }

        // Si on arrive ici, le chauffeur passe tous les filtres
        $resultats[] = $chauffeur;
    }

    return $resultats;
}

/**
 * Calcule des statistiques sur une liste de chauffeurs.
 *
 * @param  array $chauffeurs
 * @return array  Tableau associatif avec total, actifs, noteMoyenne, totalCourses
 */
function calculerStatistiques($chauffeurs)
{
    $total = count($chauffeurs);
    $actifs = 0;
    $sommeNotes = 0;
    $totalCourses = 0;

    foreach ($chauffeurs as $chauffeur) {
        if ($chauffeur["estActif"]) {
            $actifs++;
        }
        $sommeNotes += $chauffeur["note"];
        $totalCourses += $chauffeur["nombreCourses"];
    }

    return [
        "total"        => $total,
        "actifs"       => $actifs,
        "noteMoyenne"  => $total > 0 ? $sommeNotes / $total : 0,
        "totalCourses" => $totalCourses,
    ];
}
