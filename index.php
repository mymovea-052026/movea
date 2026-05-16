<?php
// Tout fichier PHP commence par <?php
// Ces lignes précédées de // sont des commentaires, ignorés par PHP

// Définition du nom du projet
$nomProjet = "MOVEA";

// Définition d'une devise
$devise = "Move Africa, une course à la fois";

// On affiche un message dans la page web
// echo signifie "écrire dans la page"
echo "<h1>Bienvenue sur " . $nomProjet . "</h1>";
echo "<p>" . $devise . "</p>";
echo "<p>Date du jour : " . date("d/m/Y") . "</p>";
echo "<p>Heure : " . date("H:i:s") . "</p>";
