<?php

    /**
     * Contrôleur de déconnexion
     * logout gère la fin de session utilisateur.
     * Réinitialise les variables de session.
     * Détruit la session en cours.
     * Redirige l'utilisateur vers la page d'accueil.
     */

    session_start();
    session_unset();
    session_destroy();
    header("Location: index.php?action=default");
    exit;
