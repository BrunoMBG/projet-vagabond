<?php

    /**
     * Contrôleur de la page d'accueil
     * 
     * Récupère les 3 derniers récits de voyage via le modèle 
     * et les transmet à la vue home.php.
     */

    
/**
 * Affiche la page d'accueil avec les derniers articles.
 * @return void
 */
function homePage(): void 
{
    global $db, $title;
    require_once RACINE . "/app/model/article.php";

    $title = "Accueil - Vagabond";
    $articles = getLatestArticles($db, 3);

    require_once RACINE . "/app/view/home.php";
}