# Installation de WordPress avec Composer

1. Télécharger WordPress, ses plugins et ses thèmes provenant de wordpress.org avec la commande `composer install`
2. Créer la base de données
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
