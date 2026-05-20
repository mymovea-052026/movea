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
