<?php

    /**
     * Contrôleur d'administration
     * 
     * admin gère les fonctionnalités réservées au personnel autorisé.
     * dashboard : Vue d'ensemble pour les Admins (1) et Rédacteurs (2).
     * userList : Gestion et affichage des comptes (Admin uniquement).
     * userUpdateRole : Modification des permissions des utilisateurs.
     */

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
     * Met à jour le rôle d'un utilisateur.
     * Vérifie que l'utilisateur connecté est administrateur, empêche la modification
     * de son propre rôle, puis met à jour le rôle en base de données.
     * Génère un message de succès ou d'erreur en session avant de rediriger
     * vers la liste des utilisateurs.
     * @global PDO $db Connexion à la base de données.
     * @return void
     */
    function userUpdateRole()
    {
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

            // Vérifie si l'utilisateur tente de modifier son propre rôle.
            if ($id_user == $_SESSION['user_id']) {
                $_SESSION['displayMessage'] = [
                    'type' => 'error',
                    'message' => "Vous ne pouvez pas modifier votre propre rôle."
                ];
                header('Location: index.php?action=user_list');
                exit;
            }

            // Appel de la fonction du modèle pour réaliser le changement du rôle
            if (updateUserRole($db, $id_user, $new_role)) {

                $_SESSION['displayMessage'] = [
                    'type' => 'success',
                    'message' => "Le rôle de l'utilisateur a été mis à jour."
                ];
            } else {
                $_SESSION['displayMessage'] = [
                    'type' => 'error',
                    'message' => "Une erreur est survenue lors de la mise à jour."
                ];
            }
        }


        header('Location: index.php?action=user_list');
        exit;
    }
