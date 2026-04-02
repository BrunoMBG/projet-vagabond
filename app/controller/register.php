<?php

require RACINE . '/app/class/form.php';
require RACINE . '/app/model/user.php';

/**
 * Gère l'inscription des utilisateurs.
 * Traite la soumission du formulaire,
 * enregistre l'utilisateur en base de données et prépare l'affichage du formulaire.
 * * @global PDO $db Connexion à la base de données.
 * * @return void
 */
function register()
{
    global $db;
    $error = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        $lastName  = htmlspecialchars(trim($_POST['nom'] ?? ''));
        $firstName = htmlspecialchars(trim($_POST['prenom'] ?? ''));
        $email     = htmlspecialchars(trim($_POST['email'] ?? ''));
        $password  = $_POST['password'] ?? '';

        if (!empty($lastName) && !empty($firstName) && !empty($email) && !empty($password)) {

            // Récupération des informations saisies par l'utilisateur depuis le modèle
            $success = registerUser($db, $lastName, $firstName, $email, $password);

            if ($success) {

                header("Location: index.php?action=login&success=1");
                exit;
            } else {
                $error = "L'inscription a échoué.";
            }
        } else {
            $error = "Veuillez remplir tous les champs.";
        }
    }
    // Création du formulaire
    $form = new Form("index.php?action=register", "post");

    $form->setInput("nom", "Votre Nom :", "text");
    $form->setInput("prenom", "Votre Prénom :", "text");
    $form->setInput("email", "Adresse Email :", "email");
    $form->setInput("password", "Mot de passe :", "password");
    // Message d'erreur
    $form->setError($error);
    $form->setSubmit("Créer mon compte");
    // Affichage du formulaire
    $formRegister = $form->getForm();

    require RACINE . '/app/view/register.php';
}
