# Test technique Dixeed pour poste de développeur intégrateur
Bienvenue sur ce repos! Je suis heureux d'avoir pu réaliser cet exercice qui ma permis d'apprendre de nouvelles choses.
Vous trouverez dans ce readme toutes les informations necessaire pour cloner et utiliser ce repo.
## Installation du projet avec Composer
1.Cloner ce repo.
2. S'assurer que composer est bien installer sur votre machine, sinon l'installer. https://getcomposer.org/doc/00-intro.md
3. Télécharger WordPress, les plugins et les thèmes avec la commande `composer install`.
4. Télécharger le fichier SQL de la base de donnée présent sur ce repo.
2. Créer la base de données: 
    * Nom de la base: Wp-Dixeed
    * Utilisateur: Wp-Dixeed
    * Mot de passe: NLrGJMDAy6YLz0lp
    * Adresse de l'instance locale: http://localhost/WordPress-Dixeed
3. Compléter dans le fichier `wp-config.php` :
    1. Les informations de connexion à la base de données
    2. Les clés de salages
    3. L'URL de la page d'accueil
    4. Le mode débug
    5. Sélectionner l'environnement d'exécution de l'application : `production`, `development` ou `staging`
4. Modifier les droits des dossiers et fichiers avec les commandes
    * `sudo chown -R $USER:www-data .`
    * `sudo find . -type f -exec chmod 664 {} +`
    * `sudo find . -type d -exec chmod 775 {} +`
    * `sudo chmod g-w .htaccess`
5. Compléter le formulaire d'installation de WordPress
    * Utilisateur : Dixeed
    * Mot de passe: NLrGJMDAy6YLz0lp
