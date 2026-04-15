## Vagabond - Blog de Voyage

Vagabond est un site web de blog construite en PHP suivant l'architecture MVC. Elle permet aux voyageurs de partager leurs récits et aux utilisateurs de commenter les articles.

## Fonctionnalités

* Système de Routage : Front Controller unique (index.php) gérant toutes les requêtes.
* Authentification : Inscription et connexion sécurisée des utilisateurs.
* Gestion du Profil : Modification des informations personnelles et du mot de passe.
* Articles \& Commentaires : Lecture d'articles et ajout de commentaires.
* Architecture MVC : Séparation stricte entre la logique métier, les données et l'affichage.
* SEO Friendly : Gestion dynamique des titres de pages pour un meilleur référencement.

## Structure du Projet

# app/ Contient le cœur de l'application.

* controller/ : Logique de traitement et gestion des requêtes.
* model/ : Interactions avec la base de données (SQL).
* view/ : Fichiers d'affichage (HTML/PHP) et composants (partials).
* class/ : Classes utilitaires (ex: Générateur de formulaires).
* data/image/ : Stockage des images de la base de données.
* utils/ : Outils transversaux.

# public/

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

