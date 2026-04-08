<?php

    /**
     * Contrôleur de la page d'accueil
     * 
     * Récupère les 3 derniers récits de voyage via le modèle 
     * et les transmet à la vue home.php.
     */

    
    global $db;

    require_once RACINE . "/app/model/article.php";

    // Récupération des 3 derniers articles
    $articles = getLatestArticles($db, 3);

    require RACINE . "/app/view/home.php";