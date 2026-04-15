<?php

    /**
     * Contrôleur de la page 404
     * 
     * page404 gère l'affichage de l'erreur "404 : Page introuvable".
     * Il est appelé par le routeur lorsqu'une action inconnue est demandée.
     */

/**
 * Affiche la page d'erreur 404.
 * @return void
 */
function error404Page(): void
{
    global $title;
    // Titre dynamique pour l'onglet du navigateur
    $title = "Page introuvable - Vagabond";

    require_once RACINE . "/app/view/page404.php";
}
