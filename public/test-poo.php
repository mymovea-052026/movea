<?php

// On inclut la classe
require_once __DIR__ . '/../src/Models/Chauffeur.php';

// ============================================================
// CRÉER UN OBJET (instancier la classe)
// ============================================================

// "new Chauffeur()" fabrique un nouvel objet à partir du moule
$jean = new Chauffeur();

// On remplit ses propriétés
$jean->prenom = "Jean";
$jean->nom = "Dupont";
$jean->ville = "Douala";
$jean->note = 4.8;
$jean->nombreCourses = 247;
$jean->estActif = true;

// ============================================================
// UTILISER L'OBJET (appeler ses méthodes)
// ============================================================

echo "<h2>Premier objet chauffeur</h2>";
echo "Nom complet : " . $jean->nomComplet() . "<br>";
echo "Performant ? " . ($jean->estPerformant() ? "Oui" : "Non") . "<br>";
echo "Revenu estimé : " . number_format($jean->revenuEstime(), 0, ',', ' ') . " FCFA<br>";

// ============================================================
// CRÉER UN DEUXIÈME OBJET (même moule, autres données)
// ============================================================

$aicha = new Chauffeur();
$aicha->prenom = "Aïcha";
$aicha->nom = "Mbarga";
$aicha->ville = "Douala";
$aicha->note = 4.9;
$aicha->nombreCourses = 312;
$aicha->estActif = true;

echo "<h2>Deuxième objet chauffeur</h2>";
echo "Nom complet : " . $aicha->nomComplet() . "<br>";
echo "Performant ? " . ($aicha->estPerformant() ? "Oui" : "Non") . "<br>";
echo "Revenu estimé : " . number_format($aicha->revenuEstime(), 0, ',', ' ') . " FCFA<br>";
