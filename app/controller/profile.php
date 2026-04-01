<?php
/**
 * Gère l'affichage du profil utilisateur.
 * Récupère les données de la session et prépare la vue.
 */
function showProfile() {
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?action=login");
        exit;
    }

    $user = $_SESSION['user'];

    require_once RACINE . '/app/view/profile.php';
}
