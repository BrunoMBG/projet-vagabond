<?php

/**
 * Contrôleur pour la gestion de l'oubli de mot de passe.
 * 
 * forgot_password gère les deux étapes clés de la récupération du mot de passe.
 * La demande initiale : validation de l'email et envoi d'un lien sécurisé par email.
 * La réinitialisation effective, saisie et hachage d'un nouveau mot de passe via un token.
 */

/**
 * Gère la réinitialisation de mot de passe.
 * Initialise le formulaire via la classe Form.
 * Génère un token de sécurité unique.
 * Construit l'URL de retour pour garantir.
 * @return void
 */

function passwordForgotController(): void
{
    global $title;
    require_once RACINE . '/app/class/form.php';
    require_once RACINE . '/app/utils/mailer.php';

    $title = "Mot de passe oublié - Vagabond";

    $form = new Form("index.php?action=forgotten", "post");

    // Ajout des champs via la class Form
    $form->setInput("email", "Email :", "email");
    $form->setSubmit("Envoyer", "btn-auth");

    // Traitement si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        if ($email) {
            // Générer le token
            $token = bin2hex(random_bytes(32));

            require_once RACINE . '/app/model/user.php';

            if (storeResetToken($email, $token)) {
                $subject = "Réinitialisation de mot de passe - Projet Vagabond";

                // Détection du protocole
                $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

                // Récupération du nom de domaine et du port
                $host = $_SERVER['HTTP_HOST'];

                // Récupération du chemin vers le dossier du projet
                $uri = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']); 

                // Construction de l'URL complète pour la réinitialisation du mot de passe
                $resetLink = $protocol . "://" . $host . $uri . "index.php?action=reset_password&token=" . $token;

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

    $formPassword = $form->getForm();

    require RACINE . "/app/view/forgot_password.php";
}



/**
 * Gère la validation du token et la saisie du nouveau mot de passe.
 * Récupère et vérifie la validité du token présent dans l'URL.
 * Affiche le formulaire de changement de mot de passe si le token est valide.
 * Hache le nouveau mot de passe (password_hash) avant enregistrement.
 * Invalide le token après usage pour empêcher toute réutilisation.
 * @return void
 */
function passwordResetController(): void
{
    global $title;
    $token = $_GET['token'] ?? null;

    if (!$token) {
        header("Location: index.php?action=default");
        exit;
    }

    $title = "Réinitialisation du mot de passe - Vagabond";
    
    require_once RACINE . '/app/model/user.php';
    $user = checkResetToken($token);

    if (!$user) {
        die("Ce lien est invalide ou a expiré.");
    }

    require_once RACINE . '/app/class/form.php';
    $form = new Form("index.php?action=reset_password&token=" . $token, "post");
    $form->setInput("password", "Nouveau mot de passe :", "password");
    $form->setSubmit("Mettre à jour le mot de passe", "btn-auth");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = $_POST['password'] ?? '';

        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            if (updateUserPassword($user['id_utilisateur'], $hashedPassword)) {
                $form->setSuccess("Mot de passe modifié ! <a href='index.php?action=login'>Connectez-vous</a>");
            } else {
                $form->setError("Une erreur est survenue lors de la mise à jour.");
            }
        } else {
            $form->setError("Veuillez saisir un mot de passe.");
        }
    }

    $formReset = $form->getForm();
    require RACINE . "/app/view/reset_password.php";
}
