### Difficultés rencontrées

- Confusion entre coller du texte dans un fichier vs dans le terminal (le contenu du .gitignore a d'abord été collé dans PowerShell)
- Authentification GitHub : la fenêtre de credential manager ne s'ouvrait pas, résolu en mettant le Personal Access Token directement dans l'URL du remote
- "remote origin already exists" : appris qu'il faut faire `git remote remove origin` avant de recréer

CommandeCe qu'elle fait:
git status : Affiche l'état actuel du projet
git diff : Affiche les modifications non encore ajoutées
git diff --staged : Affiche les modifications dans la zone d'attente
git add fichier : Ajoute un fichier à la zone d'attente
git add . : Ajoute tous les fichiers modifiés à la zone d'attente
git commit -m "message" : Crée un commit avec les fichiers de la zone d'attente
git push : Envoie les commits locaux sur GitHub
git log : Affiche l'historique des commits
git log --oneline : Historique compactgit restore fichierAnnule les modifications non commitées d'un fichier
restore --staged fichier : Retire un fichier de la zone d'attente

---

## Jour 2 — 19/05/2026

### Ce que j'ai appris aujourd'hui

- Installation et configuration des extensions VS Code pour PHP
- Le cycle Git complet : modifier → add → commit → push
- Les 3 zones de Git : dossier de travail, zone d'attente, historique local
- Les variables PHP : déclaration, types (string, int, float, bool), nommage
- L'interpolation avec guillemets doubles `"Bonjour $prenom"`
- La concaténation avec le point `.`
- Les conditions `if / elseif / else`
- Les opérateurs de comparaison, particulièrement `===` à privilégier sur `==`
- Le raccourci `<?= ... ?>` au lieu de `<?php echo ... ?>`
- La structure de dossiers d'un projet PHP professionnel

### Ce que j'ai produit

- Page d'accueil enrichie qui affiche un message selon l'heure
- Calcul dynamique d'un prix de course (500 + km×250 + min×50)
- Structure de dossiers du projet (public, src, config, docs, tests, logs)
- README.md professionnel

### Difficultés rencontrées

(à compléter par moi)

### Concepts à revoir si besoin

- La différence entre `==` et `===`
- La différence entre guillemets simples `'...'` et doubles `"..."`
- Le rôle de chaque dossier (public, src, config, etc.)

### Préparation Jour 3

---

## Jour 3 — 19/05/2026

### Ce que j'ai appris aujourd'hui

- Les tableaux indexés `[1, 2, 3]` et associatifs `["cle" => "valeur"]`
- Les tableaux multidimensionnels (tableau de tableaux)
- La boucle `foreach` et sa syntaxe alternative `foreach ... endforeach`
- Les boucles `for` (compteur) et `while` (condition)
- L'opérateur ternaire `condition ? si_vrai : si_faux`
- L'opérateur d'incrémentation `$i++`
- Créer mes propres fonctions avec `function nom() { return ... }`
- Paramètres avec valeurs par défaut
- La portée des variables (les variables externes n'existent pas dans une fonction)
- `require_once` et `__DIR__` pour inclure des fichiers
- Le principe DRY : Don't Repeat Yourself
- Les fonctions natives : `count()`, `isset()`, `array_push()`, `number_format()`

### Ce que j'ai produit

- Page d'accueil refactorée avec liste de 4 chauffeurs et statistiques
- Fichier `src/functions.php` avec 4 fonctions réutilisables
- Calcul automatique de la note moyenne et du nombre de chauffeurs actifs

### Difficultés rencontrées

RAS

### Concepts à revoir si besoin

- La différence entre tableau indexé `[1, 2, 3]` et associatif `["a" => 1]`
- Pourquoi `$tarifBase = 500;` à l'extérieur d'une fonction n'est PAS accessible à l'intérieur
- La différence entre `print_r()` et `var_dump()`
