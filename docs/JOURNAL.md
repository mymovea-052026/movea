### Difficultés rencontrées

- Confusion entre coller du texte dans un fichier vs dans le terminal (le contenu du .gitignore a d'abord été collé dans PowerShell)
- Authentification GitHub : la fenêtre de credential manager ne s'ouvrait pas, résolu en mettant le Personal Access Token directement dans l'URL du remote
- "remote origin already exists" : appris qu'il faut faire `git remote remove origin` avant de recréer

CommandeCe qu'elle fait:
git status : Affiche l'état actuel du projet
git diff : Affiche les modifications non encore ajoutées
git diff --staged : Affiche les modifications dans la zone d'attente
git add fichier : Ajoute un fichier à la zone d'attente
git add . : Ajoute tous les fichiers modifiés à la zone d'attente git commit -m "message"Crée un commit avec les fichiers de la zone d'attente
git push : Envoie les commits locaux sur GitHub
git log : Affiche l'historique des commits git log --oneline : Historique compactgit restore fichierAnnule les modifications non commitées d'un fichier
restore --staged fichier : Retire un fichier de la zone d'attente
