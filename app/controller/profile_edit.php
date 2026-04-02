<?php
require RACINE . '/app/model/user.php';
require RACINE . '/app/class/form.php';

function editProfile()
{
    global $db;
    $user = $_SESSION['user'];
    $error = "";
    $success = "";

    // Vérifie si l'utilisateur est connecté 
    // Si ce n'est pas le cas il est dirigé vers la page de connexion
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?action=login");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Nettoyage et sécurisation des valeurs saisies par l'utilisateur
        $nom = htmlspecialchars(trim($_POST['nom']));
        $prenom = htmlspecialchars(trim($_POST['prenom']));
        $email = htmlspecialchars(trim($_POST['email']));
        $newPassword = $_POST['password'] ?? '';
        $id = $_SESSION['user']['id'];

        // Vérification que les champs obligatoires ne sont pas vides
        if (!empty($nom) && !empty($prenom) && !empty($email)) {

            // Vérifie si c'est un email valide
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                // Appel de la fonction de mise à jour des données dans la base
                $isUpdated = updateProfil($db, $id, $nom, $prenom, $email, $newPassword);
                // Si les information ont été modifiées, cela met les informations de la SESSION à jour
                if ($isUpdated) {
                    $_SESSION['user']['nom'] = $nom;
                    $_SESSION['user']['prenom'] = $prenom;
                    $_SESSION['user']['email'] = $email;
                    $user = $_SESSION['user'];
                    $success = "Le profil a été mis à jour !";
                } else {
                    $error = "Une erreur est survenue lors de la mise à jour.";
                }
            } else {
                $error = "Le format de l'adresse email n'est pas valide.";
            }
        } else {
            $error = "Tous les champs (sauf le mot de passe) sont obligatoires.";
        }
    }
    // Création du formulaire
    $form = new Form("index.php?action=profile_edit", "post");
    $form->setInput("nom", "Nom :", "text", $user['nom']);
    $form->setInput("prenom", "Prénom :", "text", $user['prenom']);
    $form->setInput("email", "Email :", "email", $user['email']);
    $form->setInput("password", "Nouveau mot de passe :", "password");

    // Message d'erreur
    $form->setError($error);

    $form->setSubmit("Enregistrer les modifications");
    // Affichage du formulaire
    $formEdit = $form->getForm();
    require_once RACINE . '/app/view/profile_edit.php';
}
