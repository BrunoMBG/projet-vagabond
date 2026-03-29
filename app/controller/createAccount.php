<?php

    require RACINE . '/app/class/form.php';
    function register()
    {

        $form = new Form("index.php?action=register", "post");

        $form->setInput("nom", "Votre Nom :", "text");
        $form->setInput("prenom", "Votre Prénom :", "text");
        $form->setInput("email", "Adresse Email :", "email");
        $form->setInput("password", "Mot de passe :", "password");

        $form->setSubmit("Créer mon compte");

        $formRegister = $form->getForm();

        require RACINE . '/app/view/createAccount.php';
    }

    register();
