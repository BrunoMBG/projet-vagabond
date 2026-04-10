<?php

/**
 * Contrôleur pour la gestion de l'oubli de mot de passe.
 * * forgot_password gère l'affichage du formulaire de récupération et le traitement
 * de la demande : validation de l'email, génération du jeton (token) de sécurité
 * et envoi de l'email de réinitialisation via PHPMailer.
 */

/**
 * Gère la réinitialisation de mot de passe.
 * Initialise le formulaire via la classe Form.
 * Valide l'adresse email soumise en POST.
 * Génère un jeton unique et sécurisé.
 * Expédie un email contenant le lien de récupération.
 * Charge la vue correspondante pour afficher les messages de succès ou d'erreur.
 *
 * @return void
 */

function passwordForgotController()
{
    require_once RACINE . '/app/class/form.php';
    require_once RACINE . '/app/utils/mailer.php';

    $form = new Form("index.php?action=forgotten", "post");

    // Ajout des champs via la class Form
    $form->setInput("email", "Email :", "email");
    $form->setSubmit("Envoyer");

    // Traitement si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        if ($email) {
            // Générer le token
            $token = bin2hex(random_bytes(32));

            require_once RACINE . '/app/model/user.php';

            if (storeResetToken($email, $token)) {
                // Si l'enregistrement SQL réussit, on prépare et envoie le mail
                $subject = "Réinitialisation de mot de passe - Projet Vagabond";
                $resetLink = "http://localhost:8080/projet-vagabond/index.php?action=reset_password&token=" . $token;
                $body = "<h1>Réinitialisation</h1><p>Cliquez ici : <a href='$resetLink'>$resetLink</a></p>";

                if (sendEmail($email, $subject, $body)) {
                    $form->setSuccess("L'email a été envoyé.");
                } else {
                    $form->setError("Erreur lors de l'envoi de l'email.");
                }
            } else {
          
                $form->setError("Une erreur est survenue lors de la préparation de la demande.");
            }
        }
    }

     $formPassword= $form->getForm();

    require RACINE . "/app/view/forgot_password.php";
}
