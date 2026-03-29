<?php

/**
 * Routeur principal.
 * * Analyse l'action demandée et charge le contrôleur correspondant.
 * Si l'action est inconnue ou absente, redirige vers la page d'accueil ou une erreur 404.
 *
 * @param string $action Le nom de la page demandée (par défaut "default").
 * @return void
 */
function handleRequest(string $action = "default"): void
{
    switch ($action) {
        case "default":
            require RACINE . "/app/controller/home.php";
            break;
        case "register":
            require RACINE . "/app/controller/createAccount.php";
            break;
        default:
            require RACINE . "/app/controller/page404.php";
            break;
    }
}
