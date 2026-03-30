<?php

require RACINE . '/app/class/form.php';
require RACINE . '/app/model/user.php';

function register()
{
    global $db;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        $lastName  = htmlspecialchars($_POST['nom'] ?? '');
        $firstName = htmlspecialchars($_POST['prenom'] ?? '');
        $email     = htmlspecialchars($_POST['email'] ?? '');
        $password  = $_POST['password'] ?? '';

        // 2. VÉRIFICATION (Optionnel mais conseillé)
        if (!empty($lastName) && !empty($firstName) && !empty($email) && !empty($password)) {

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








    $form = new Form("index.php?action=register", "post");

    $form->setInput("nom", "Votre Nom :", "text");
    $form->setInput("prenom", "Votre Prénom :", "text");
    $form->setInput("email", "Adresse Email :", "email");
    $form->setInput("password", "Mot de passe :", "password");
    $form->setError($error);
    $form->setSubmit("Créer mon compte");

    $formRegister = $form->getForm();

    require RACINE . '/app/view/createAccount.php';
}

register();
