<?php

require RACINE . '/app/class/form.php';
/**
 * Gère la page de contact : valide les données saisies, tente d'envoyer un email
 * au destinataire configuré, et génère le formulaire HTML 
 * via la classe Form pour affichage dans la vue.
 * * @return void
 */
function contact()
{
    global $db;

    $messageError = "";
    $messageSuccess = "";


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = trim(htmlspecialchars($_POST['nom'] ?? ''));
        $prenom = trim(htmlspecialchars($_POST['prenom'] ?? ''));
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $sujet = trim(htmlspecialchars($_POST['sujet'] ?? ''));
        $message = trim(htmlspecialchars($_POST['message'] ?? ''));

        // Vérification que tous les champs obligatoires sont bien remplis et valides
        if ($nom && $prenom && $email && $sujet && $message) {
            // Configuration de l'email
            $to = "ex-email@exemple.com";

            // Construction des headers du mail
            $headers = "From: " . $email . "\r\n";
            $headers .= "Reply-To: " . $email . "\r\n";
            $headers .= "Content-Type: text/plain; charset=utf-8\r\n";

            // Construction du corps du mail
            $body = "Nouveau message de contact :\n\n";
            $body .= "Nom : $nom $prenom\n";
            $body .= "Email : $email\n\n";
            $body .= "Sujet : $sujet\n";
            $body .= "Message :\n$message";

            // Envoi du mail via la fonction mail
            if (mail($to, "Contact Site - $sujet", $body, $headers)) {
                $messageSuccess = "Votre message a bien été envoyé !";
            } else {
                // En cas d'erreur tecnique 
                $messageError = "Le serveur n'a pas pu envoyer votre message. Réessayez plus tard.";
            }
        } else {
            $messageError = "Veuillez remplir tous les champs correctement (Email valide requis).";
        }
    }

    // Création du formulaire
    $form = new Form("index.php?action=contact", "post");

    $form->setText("Une question, une suggestion ou une envie de collaborer ? Nous sommes à votre écoute.", "contact-intro");


    if ($messageError) $form->setError($messageError);
    if ($messageSuccess) $form->setSuccess($messageSuccess);

    $form->setInput("nom", "Nom", "text");
    $form->setInput("prenom", "Prénom", "text");
    $form->setInput("email", "Email", "email");
    $form->setInput("sujet", "Sujet", "text");
    $form->setTextarea("message", "Votre Message", 5);

    $form->setSubmit("Envoyer le message");

    // Affichage du formulaire
    $contactFormHtml = $form->getForm();


    require RACINE . "/app/view/contact.php";
}
