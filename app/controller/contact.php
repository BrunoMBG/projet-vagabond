<?php

/**
 * Contrôleur de la page de contact
 * 
 * contact gère la réception des messages envoyés par les visiteurs.
 * Validation des entrées.
 * Envoi sécurisé via SMTP avec PHPMailer.
 * Génération du formulaire.
 */


/**
 * Gère la page de contact : valide les données saisies, prépare le corps HTML
 * et expédie l'email au destinataire via PHPMailer.
 * @return void
 */
function contact()
{
    require RACINE . '/app/class/form.php';
    require RACINE . '/app/utils/mailer.php';

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

            // Construction du sujet
            $subject = "Nouveau message de : " . $nom . " " . $prenom . " - " . $sujet;

            // Construction du corps du mail
            $body = "<h2>Vous avez reçu un nouveau message de contact</h2>";
            $body .= "<p><strong>Nom :</strong> {$nom} {$prenom}</p>";
            $body .= "<p><strong>Email :</strong> {$email}</p>";
            $body .= "<p><strong>Sujet :</strong> {$sujet}</p>";
            $body .= "<p><strong>Message :</strong><br>" . nl2br($message) . "</p>";

            // Envoi via PHPMailer
            if (sendEmail($to, $subject, $body)) {
                $messageSuccess = "Votre message a bien été envoyé !";
            } else {
                $messageError = "Le serveur de messagerie a rencontré un problème.";
            }
        } else {
            $messageError = "Veuillez remplir tous les champs correctement.";
        }
    }

    // Création du formulaire
    $form = new Form("index.php?action=contact", "post");

    $form->setText("Une question, une suggestion ou une envie de collaborer ? Nous sommes à votre écoute.", "");

    $form->setInput("nom", "Nom", "text");
    $form->setInput("prenom", "Prénom", "text");
    $form->setInput("email", "Email", "email");
    $form->setInput("sujet", "Sujet", "text");
    $form->setTextarea("message", "Votre Message", 5);
    $form->setError($messageError);
    $form->setSuccess($messageSuccess);
    $form->setSubmit("Envoyer le message");

    // Affichage du formulaire
    $contactFormHtml = $form->getForm();


    require RACINE . "/app/view/contact.php";
}
