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

(à compléter selon ce que Claude propose)
