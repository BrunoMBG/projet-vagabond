<?php
require RACINE . "/app/model/user.php";
/**
 * Gère l'accès au tableau de bord administrateur.
 *  @global PDO $db Connexion à la base de données.
 *  @return void
 * */
function dashboard(): void
{
    global $db;

    // Si une session n'existe pas ou si l'utilisateur n'a pas 
    // le rôle Administrateur (1) ou Rédacteur (2),
    // il sera redirigé vers la page de connexion.
    if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] !== 1 && $_SESSION['user_role'] !== 2)) {
        header("Location: index.php?action=login");
        exit;
    }


    $users = [];

    // Récupère les informations stockées dans le tableau $users
    // uniquement si c'est l'administrateur qui est connecté.
    if ($_SESSION['user_role'] === 1) {
        $users = getAllUsers($db);
    }

    require RACINE . "/app/view/admin/dashboard.php";
}


/**
 * Affiche la page de gestion des utilisateurs
 * @global PDO $db Connexion à la base de données.
 *  @return void
 */
function userList()
{
    global $db;

    //  Vérifier si l'utilisateur est bien Admin
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
        header('Location: index.php?action=default');
        exit;
    }

    // Récupérer tous les utilisateurs via le modèle
    $users = getAllUsers($db);

    // Récupérer tous les rôles
    $roles = getAllRoles($db);


    require_once RACINE . '/app/view/admin/user_list.php';
}

/**
 * Traite la modification du rôle d'un utilisateur 
 * @global PDO $db Connexion à la base de données
 * @return void
 */
function userUpdateRole() {
    global $db;
    require_once RACINE . '/app/model/user.php';

    // Vérifie si l'utilisateur est connecté et possède le rôle Admin
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
        header('Location: index.php?action=default');
        exit;
    }

    // Vérifie si les données ont bien été changé
    if (isset($_POST['id_utilisateur'], $_POST['changeRole'])) {
        $id_user =  $_POST['id_utilisateur'];
        $new_role = $_POST['changeRole'];

        // Appel de la fonction du modèle pour réaliser le changement de
        if (updateUserRole($db, $id_user, $new_role)) {
  
           
        }
    }

   
    header('Location: index.php?action=user_list');
    exit;
}
