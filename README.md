# Vagabond - Blog de Voyage

Vagabond est un site web de blog construite en PHP suivant l'architecture MVC. Elle permet aux voyageurs de partager leurs récits et aux utilisateurs de commenter les articles.

## Fonctionnalités

* Système de Routage : Front Controller unique (index.php) gérant toutes les requêtes.
* Authentification : Inscription et connexion sécurisée des utilisateurs.
* Gestion du Profil : Modification des informations personnelles et du mot de passe.
* Articles \& Commentaires : Lecture d'articles et ajout de commentaires.
* Architecture MVC : Séparation stricte entre la logique métier, les données et l'affichage.
* SEO Friendly : Gestion dynamique des titres de pages pour un meilleur référencement.

## Structure du Projet

### app/

* controller/ : Logique de traitement et gestion des requêtes.
* model/ : Interactions avec la base de données (SQL).
* view/ : Fichiers d'affichage (HTML/PHP) et composants (partials).
* class/ : Classes utilitaires (ex: Générateur de formulaires).
* data/image/ : Stockage des images de la base de données.
* utils/ : Outils transversaux.

### public/

* scss/ : Fichiers sources Sass.
* style/ : Fichiers CSS compilés.
* js/ : Scripts JavaScript.
* img/ : Assets graphiques statiques.

index.php : Le Front Controller point d'entrée unique.


## Stack Technique

* Backend : PHP
* Base de données : MySQL
* Frontend : HTML5, CSS3, JavaScript (Vanilla)
* Architecture : MVC (Modèle-Vue-Contrôleur)


## Installation et Configuration

Pour faire fonctionner ce projet localement, il faut suivre ses étapes : 

1. Prérequis
        
* PHP 8.3
* MySQL 8.0 (recommandé) ou MariaDB
* Composer installé

2. Installation des dépendances 

À la racine du projet, exécutez la commande suivante pour installer PHPMailer et PHP dotenv :

* composer install

3. Configuration de la Base de Données

La base de données utilise la collation utf8mb4_0900_ai_ci.

Lors de la création de votre base de données locale (via phpMyAdmin ou MySQL), 
veillez à sélectionner ce jeu de caractères pour assurer la compatibilité totale avec le script SQL fourni.

1. Créez une base de données nommée vagabond.

2. Importez le fichier SQL situé dans /app/data/sql pour générer le schéma et les données initiales.


4. Variables d'environnement

Le projet utilise un fichier .env pour sécuriser les accès.

1. Repérez le fichier .env.example à la racine.

2. Renommez-le en .env

3. Renseignez vos informations de connexion à la base de données et SMTP pour l'envoi d'emails :

* DB_HOST=localhost
* DB_NAME=vagabond
* DB_USER=votre_identifiant
* DB_PASS=votre_mot_de_passe
* DB_PORT=3306

* SMTP_HOST=smtp.gmail.com
* SMTP_PORT=587
* SMTP_USER=votre_email@gmail.com
* SMTP_PASS=votre_code_application_16_lettres
* ADMIN_EMAIL=votre_email_de_reception@gmail.com 

