# Test technique Dixeed pour poste de développeur intégrateur
Bienvenue sur ce repos! Je suis heureux d'avoir pu réaliser cet exercice qui ma permis d'apprendre de nouvelles choses.
Vous trouverez dans ce readme toutes les informations necessaire pour cloner et utiliser ce repo.
## Installation du projet avec Composer
1. Cloner ce repo
2. S'assurer que composer est bien installer sur votre machine sinon l'installer https://getcomposer.org/doc/00-intro.md
3. Télécharger WordPress, les plugins et les thèmes avec la commande `composer install`
4. Télécharger le fichier SQL de la base de donnée présent sur ce repo
5. Créer la base de données 
    * Nom de la base: Wp-Dixeed
    * Utilisateur: Wp-Dixeed
    * Mot de passe: NLrGJMDAy6YLz0lp
    * Adresse de l'instance locale: http://localhost/WordPress-Dixeed
6. Compléter dans le fichier `wp-config.php` :
    1. Les informations de connexion à la base de données
    2. Les clés de salages
    3. L'URL de la page d'accueil
    4. Le mode débug
    5. Sélectionner l'environnement d'exécution de l'application : `production`, `development` ou `staging`
7. Modifier les droits des dossiers et fichiers avec les commandes :
    * `sudo chown -R $USER:www-data .`
    * `sudo find . -type f -exec chmod 664 {} +`
    * `sudo find . -type d -exec chmod 775 {} +`
    * `sudo chmod g-w .htaccess`
8. Compléter le formulaire d'installation de WordPress
    * Utilisateur : Dixeed
    * Mot de passe: NLrGJMDAy6YLz0lp
## Dépendances du projet
* Wordpress version 5.1
* Woocommerce version 4.3.3
* Query monitor version 3.4.0
* Theme store front version 2.5.8
## Travail effectué et durée
1. Instalation de wordpress, woocommerce, strorefront. Durée : 20 min
2. Paramétrage woocommerce pour créer 3 catégories de produits, 1 produit par catégorie dont un avec le choix de couleur, ajouter deux méthodes d'expédition, limiter la vente en france seulement. Durée  : 20 min
3. Modification de la couleur de fonds des boutons sans utiliser le backoffice en créant un thème enfant "storefront-child" 
puis modification du css de la classe des boutons. Durée : 15 min
4. Création d'un module "livraison en urgence" sur la page paiement: Ajout d'un bouton radio et d'un choix multiple avec re-calcul du pannier en fonction du délai de livraison choisi: 2 heures en s'inspirant de ce tutoriel https://mosaika.fr/personnaliser-tunnel-commande-woocommerce/
* Ajout de nouveaux champs sur la page grâce au hook `woocommerce_checkout_billing`
* S'assurer de la validité des champs grâce au hook `woocommerce_checkout_process`
* Modifier le prix du pannier dynamiquement en fonction des champs grâce au hook `woocommerce_cart_calculate_fees`
* rendre les champs visibles pour woocommerce grâce au filtre `woocommerce_checkout_posted_data`
* Enregistrer la valeur des champs sur chaque commande passée grâce au hook ` woocommerce_checkout_update_order_meta`
5. Création du plugin "showMessage" permettant l'affichage sur la page mon compte: 
j'ai créer deux solutions différentes :
Solution 1:
* Création d'une métabox avec un champ texte qui apparait lors de l'édition de la page "mon compte"
* Enregistrement de la métabox
* récupération et affichage des données.
Solution 2:
* Création d'un menu suplémentaire dans le backoffice permetant le réglage du thème
* création d'un champ texte pour rentrer le message
* Envoie du message désiré sur la bonne page.
* Récupération des données en POST puis affichage
durée: 4 heures
6. Création d'une page avec un formulaire permetant de récupèrer des informations que rentrera l'utilisateur courant et les afficher en direct sur la page et dans le backoffice:
* Creation de la page et assignation du template modèle sans utiliser le backoffice grâce à ` wp_insert_post` depuis le thème enfant 
URL http://localhost/WordPress-Dixeed/aimez-vous-les-ananas/
* Création du template modèle avec le formulaire dans le thème enfant
* Récupération et affichage des infos sur le site avec  ` $_POST` 
* création d'une colone suplémentaire dans la table wp-users en base de donnée pour insérer les informations de l'utilisateur courant
* insertion des nouvelles infos en base de donnée grâce à  `wpdb`
* Création d'une "list-table" permetant d'afficher les préférences des utilisateurs sous forme de tableau dans le backoffice en récupèrant les données en base
Durée: 3 heures
7. Création d'un bouton dans la page produit permetant l'affichage de mon adresse ip au click :
* création d'un fichier js et déclaration de celui-ci via le thème enfant
* récupération des donnée de l'api "Ipfy" grâce à `$.getJSON` puis affichage au click sur la page grâce à un script jquery. Durée: 1 heures
8. Mise en forme css, réorganisation des fichiers, factorisation; Durée 2 heures.
