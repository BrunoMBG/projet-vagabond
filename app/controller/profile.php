<?php
/**
 * Contrôleur du profil utilisateur
 * *profile gère l'affichage des informations personnelles de l'utilisateur.
 * Vérifie si l'utilisateur est authentifié.
 * Récupère les données depuis la session.
 * Inclut la vue profil pour l'affichage.
 */

/**
 * Gère l'affichage du profil utilisateur.
 * * Vérifie l'existence d'une session active, redirige vers la connexion 
 * si nécessaire, puis transmet les données utilisateur à la vue.
 * * @return void
 */
function showProfile() {
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?action=login");
        exit;
    }

    $user = $_SESSION['user'];

    require_once RACINE . '/app/view/profile.php';
}
