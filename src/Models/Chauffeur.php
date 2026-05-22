<?php

/**
 * Classe Chauffeur — représente un chauffeur de la plateforme MOVEA.
 */
class Chauffeur
{
    // ============================================================
    // PROPRIÉTÉS (les données de chaque chauffeur)
    // ============================================================

    public $prenom;
    public $nom;
    public $ville;
    public $note;
    public $nombreCourses;
    public $estActif;

    // ============================================================
    // MÉTHODES (les actions qu'un chauffeur peut faire)
    // ============================================================

    /**
     * Renvoie le nom complet du chauffeur.
     */
    public function nomComplet()
    {
        return $this->prenom . " " . $this->nom;
    }

    /**
     * Indique si le chauffeur est performant (note >= 4.5).
     */
    public function estPerformant()
    {
        return $this->note >= 4.5;
    }

    /**
     * Estime le revenu total du chauffeur.
     * Hypothèse : marge moyenne de 300 FCFA par course.
     */
    public function revenuEstime()
    {
        $margeParCourse = 300;
        return $this->nombreCourses * $margeParCourse;
    }
}
