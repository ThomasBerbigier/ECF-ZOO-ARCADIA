Pour déployer l'application en local, suivez les étapes ci-dessous.

Prérequis:

1. Visual Studio Code (VSCode): Assurez-vous que vous avez installé VSCode sur votre machine.
1. XAMPP: Un package complet qui inclut Apache, MariaDB et PHP.
1. Composer: Un gestionnaire de dépendances pour PHP.
1. Git: Pour gérer le code source et effectuer des opérations de contrôle de version.
1. MongoDB: Pour la base de données NoSQL.

Étape 1: Installation des outils nécessaires

`	`VSCode:

`    	`Téléchargez et installez VSCode depuis le site officiel: [VSCode](https://code.visualstudio.com/).

`	`XAMPP:

`    	`Téléchargez et installez XAMPP depuis le site officiel: [XAMPP](https://www.apachefriends.org/fr/index.html).

`    	`Une fois installé, lancez XAMPP et démarrez les services Apache et MySQL.

`	`Composer:

`    	`Téléchargez et installez Composer depuis le site officiel: [Composer](https://getcomposer.org/).

`    	`Pour vérifier que Composer est correctement installé, ouvrez un terminal et tapez composer --version.

`	`Git:

`    	`Téléchargez et installez Git depuis le site officiel: [Git](https://git-scm.com/).



`	`MongoDB:

`    	`Téléchargez et installez [MongoDB](https://www.mongodb.com/fr-fr).

Étape 2: Configuration de la base de données

`	`MariaDB (via XAMPP):

1. Accédez à phpMyAdmin via le tableau de bord XAMPP en cliquant sur Admin (ou à l'adresse http://localhost/phpmyadmin).
1. Créez une nouvelle base de données pour votre application.
1. Importez le fichier SQL présent dans le repository pour créer les tables et insérer les données initiales. Cela peut être fait en utilisant l'option "Importer" dans phpMyAdmin.

`	`MongoDB:

1. ` `Démarrez MongoDB en exécutant, depuis le terminal, la commande mongod.
1. Utilisez un client comme MongoDB Compass pour créer une nouvelle base de données et une nouvelle collection.
1. Configurez la connexion MongoDB dans les fichiers de l'application (register\_click.php et administrateur\_crud.php).

Étape 3: Configuration de l'application

1. Placez votre projet dans le répertoire htdocs de XAMPP.    

2. Cloner le dépôt, ouvrez un terminal et clonez le dépôt Git: 

git clone URL\_DU\_REPO

3. Installer les dépendances PHP

Dans le répertoire de votre projet, exécutez la commande suivante pour installer les dépendances:

`		`composer install

`		`composer require mongodb/mongodb

`		`composer require phpmailer/phpmailer

Étape 4: Lancement de l'application

1. Démarrer le serveur local 

Assurez-vous que les services Apache et MySQL sont en cours d'exécution dans XAMPP.

Assurez-vous que votre fichier de configuration de base de données (ici pdo.php) contient les bonnes informations de connexion.

2. Accéder à l'application

Ouvrez votre navigateur web et accédez à l'adresse http://localhost/votre-projet pour voir votre application en action.

3. Vérifier le fonctionnement

Assurez-vous que toutes les fonctionnalités de l'application sont opérationnelles en testant les différentes pages et fonctionnalités (connexion, affichage des animaux, etc.).




En suivant ces étapes, vous devriez pouvoir déployer et exécuter votre application en local avec succès.
