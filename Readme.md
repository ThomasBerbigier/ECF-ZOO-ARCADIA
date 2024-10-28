# 🦁 Zoo Arcadia - Application Web

## Description
Le zoo Arcadia est un parc animalier indépendant qui accorde une importance particulière à l'écologie et à la santé de ses animaux.
Le directeur, José, souhaitait moderniser le zoo avec une application web permettant aux visiteurs de découvrir les différents habitats, services, et animaux tout en reflétant les valeurs écologiques du zoo.
En parallèle, elle devait intégrer un aspect fonctionnel avec un espace spécialement conçu pour les professionnels, leur permettant de gérer efficacement les opérations internes et de maintenir le bien-être des animaux. 


## Démonstration

L'application est déployée en ligne et accessible via [Heroku](https://salty-scrubland-07219-ce96da39ee13.herokuapp.com/index.php).


## Stack Technique

- **Front-end** :  
  ![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
  ![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
  ![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
  ![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

- **Back-end** :  
  ![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)

- **Base de données** :  
  ![MariaDB](https://img.shields.io/badge/MariaDB-003545?style=for-the-badge&logo=mariadb&logoColor=white)
  ![MongoDB](https://img.shields.io/badge/MongoDB-47A248?style=for-the-badge&logo=mongodb&logoColor=white)

- **Outils de développement** :  
  ![Visual Studio Code](https://img.shields.io/badge/Visual_Studio_Code-0078D4?style=for-the-badge&logo=visual%20studio%20code&logoColor=white)
  ![Git](https://img.shields.io/badge/Git-F05032?style=for-the-badge&logo=git&logoColor=white)
  ![Composer](https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=composer&logoColor=white)
  ![XAMPP](https://img.shields.io/badge/XAMPP-FB7A24?style=for-the-badge&logo=xampp&logoColor=white)
  ![Heroku](https://img.shields.io/badge/Heroku-430098?style=for-the-badge&logo=heroku&logoColor=white)


## Fonctionnalités Principales

- **Page d’accueil** : Présentation du zoo avec les différents habitats, services, et avis des visiteurs.
- **Vue globale des services** : Affichage des services proposés (restauration, visites guidées, etc.), configurables par l'administrateur et par les employés.
- **Vue des habitats** : Détail des habitats avec les animaux associés et leurs informations, incluant les états de santé.
- **Gestion des avis** : Les visiteurs peuvent laisser des avis validés par les employés avant publication.
- **Espace administrateur** : Gestion des utilisateurs (employés, vétérinaires), services, habitats, et animaux, avec accès aux statistiques.
- **Espace employé** : Validation des avis visiteurs et gestion des services. Enregistrement des données alimentaires des animaux.
- **Espace vétérinaire** : Remplissage de comptes rendus de santé pour les animaux.
- **Connexion sécurisée** : Système d'authentification avec accès restreint aux utilisateurs autorisés.
- **Formulaire de contact** : Les visiteurs peuvent contacter le zoo via un formulaire en ligne. Les messages sont envoyés par email.

## Prérequis

- **Visual Studio Code** : Éditeur de code.
- **XAMPP** : Pour Apache, MariaDB et PHP.
- **Composer** : Gestionnaire de dépendances PHP.
- **Git** : Contrôle de version.
- **MongoDB** : Base de données NoSQL pour les statistiques.

## Installation et Mise en Route

1. **Cloner le dépôt** :
   ```bash
   git clone https://github.com/ThomasBerbigier/ECF-ZOO-ARCADIA

2. **Configurer la base de données** :
   - **MariaDB** :
     - Accédez à phpMyAdmin via XAMPP et créez une base de données pour l'application.
     - Importez le fichier SQL présent dans la racine du projet pour initialiser les tables et les données.
   - **MongoDB** :
     - Démarrez MongoDB avec la commande `mongod`.
     - Utilisez un client comme MongoDB Compass pour créer une base de données et une collection.
     - Configurez la connexion MongoDB dans les fichiers `register_click.php` et `administrateur_crud.php`.

3. **Installer les dépendances** :
   - Placez le projet dans le répertoire `htdocs` de XAMPP.
   - Installez les dépendances PHP :
     ```bash
     composer install
     composer require mongodb/mongodb
     composer require phpmailer/phpmailer
     ```

4. **Lancer l'application** :
   - Démarrez Apache et MySQL dans XAMPP.
   - Assurez-vous que le fichier `pdo.php` contient les bonnes informations de connexion.
   - Ouvrez `http://localhost/votre-projet` dans un navigateur pour accéder à l'application.

---

