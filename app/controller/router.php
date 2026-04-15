<?php

/**
 * Contrôleur Routeur
 * 
 * router est le point d'entrée unique pour la navigation du site. 
 * Réceptionne l'action envoyée par l'URL .
 * Inclus le contrôleur nécessaire.
 * Exécute la fonction associée à la page.
 * Sécurise l'accès en gérant les pages inconnues (404).
 *
 * @param string $action Le nom de la page demandée (par défaut "default").
 * @return void
 */
function handleRequest(string $action = "default"): void
{
    switch ($action) {
        // Affiche la page d'accueil
        case "default":
            require RACINE . "/app/controller/home.php";
            homePage();
            break;

        // Gère l'affichage de la liste des articles
        case "blog":
            require RACINE . "/app/controller/article.php";
            articleList();
            break;

        // Gère le formulaire de contact
        case "contact":
            require RACINE . "/app/controller/contact.php";
            contact();
            break;

        // Gère l'authentification de l'utilisateur
        case "login":
            require RACINE . "/app/controller/login.php";
            login();
            break;

        // Gère la création d'un nouveau compte
        case "register":
            require RACINE . "/app/controller/register.php";
            register();
            break;

        // Gère la déconnexion de l'utilisateur
        case "logout":
            require RACINE . "/app/controller/logout.php";
            break;

        // Affiche le profil de l'utilisateur connecté
        case "profile":
            require RACINE . "/app/controller/profile.php";
            showProfile();
            break;

        // Gère la modification des informations du profil
        case "profile_edit":
            require RACINE . "/app/controller/profile_edit.php";
            editProfile();
            break;

        // Gère l'affichage de la liste des utilisateurs 
        case "user_list":
            require RACINE . "/app/controller/admin.php";
            userList();
            break;

        // Gère la modification des droits d'un utilisateur
        case "user_update_role":
            require RACINE . "/app/controller/admin.php";
            userUpdateRole();
            break;

        // Gère l'ajout d'un nouvel article
        case "articleAdd":
            require RACINE . "/app/controller/article.php";
            articleAdd();
            break;

        // Affiche le contenu d'un article spécifique
        case "articleView":
            require RACINE . "/app/controller/article.php";
            articleView();
            break;

        // Gère la récupération et l'affichage sécurisé des images
        case 'viewImage':
            require_once RACINE . '/app/controller/images.php';
            displayImage();
            break;

        // Gère l'ajout d'un commentaire sur un article
        case "addComment":
            require RACINE . "/app/controller/article.php";
            postComment();
            break;

        // Gère l'ajout ou le retrait des articles favoris
        case 'favorites':
            require RACINE . "/app/controller/article.php";
            favorites();
            break;

        // Gère la modification d'un article
        case 'articleEdit':
            require RACINE . "/app/controller/article.php";
            articleEdit();
            break;

        //  Gère l'affichage de l'interface 
        case 'articleManagement':
            require RACINE . "/app/controller/article.php";
            articleManagement();
            break;

        // Gère la suppression d'un article
        case 'articleDelete':
            require RACINE . "/app/controller/article.php";
            articleDelete();
            break;

        // Gère la récupération du mot de passe 
        case 'forgotten':
            require RACINE . "/app/controller/forgot_password.php";
            passwordForgotController();
            break;

        // Gère le changement du nouveau mot de passe 
        case 'reset_password':
            require RACINE . "/app/controller/forgot_password.php";
            passwordResetController();
            break;

        // Gère l'affichage des favoris
        case 'showMyFavorites':
            require RACINE . "/app/controller/article.php";
            showMyFavorites();
            break;

        // Gère l'affichage des mentions legales
        case 'legal_Notice':
            require RACINE . "/app/controller/legal_Notice.php";
            mentionsLegales();
            break;

        // Gère l'affichage de la page politique de Confidentialité
        case 'privacy':
            require RACINE . "/app/controller/privacy.php";
            privacyPage();
            break;

        // Redirige vers la page d'erreur 404 si l'action est inconnue
        default:
            require RACINE . "/app/controller/page404.php";
            break;
    }
}
