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
        case "blog":
            require RACINE . "/app/controller/blog.php";
            break;
        case "contact":
            require RACINE . "/app/controller/contact.php";
            break;
        case "login":
            require RACINE . "/app/controller/login.php";
            login();
            break;
        case "register":
            require RACINE . "/app/controller/register.php";
            register();
            break;
        case "logout":
            require RACINE . "/app/controller/logout.php";
            break;
        case "profile":
            require RACINE . "/app/controller/profile.php";
            showProfile();
            break;
        case "profile_edit":
            require RACINE . "/app/controller/profile_edit.php";
            editProfile();
            break;
        case "dashboard":
            require RACINE . "/app/controller/admin.php";
            dashboard();
            break;
        case "user_list":
            require RACINE . "/app/controller/admin.php";
            userList();
            break;
        default:
            require RACINE . "/app/controller/page404.php";
            break;
    }
}
