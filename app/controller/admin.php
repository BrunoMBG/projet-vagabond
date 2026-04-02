<?php
require RACINE . "/app/model/user.php";
/**
 * Gère l'accès au tableau de bord administrateur.
 * * @return void
 *  */
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
