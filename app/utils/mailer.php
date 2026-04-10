<?php
/**
 * mailer centralise la configuration de PHPMailer et expose 
 * une interface simplifiée pour l'envoi de courriels dans l'application 
 * Utilise les variables d'environnement 
 * pour sécuriser les identifiants SMTP.
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Envoie un email au format HTML via le serveur SMTP configuré.
 * Cette fonction utilise les variables d'environnement .env pour la connexion
 * et PHPMailer pour la gestion de l'envoi. Elle génère automatiquement une version 
 * en texte brut pour assurer la compatibilité avec tous les clients mail.
 *
 * @param string $to Adresse email du destinataire.
 * @param string $subject Sujet du message.
 * @param string $body Contenu du message .
 * @return bool Retourne true si l'envoi a réussi, false sinon.
 */
function sendEmail(string $to, string $subject, string $body): bool
{
    $mail = new PHPMailer(true);

    try {
        // Configuration Serveur via .env
        $mail->isSMTP();
        $mail->Host       = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['SMTP_USER'];
        $mail->Password   = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Équivalent de 'tls'
        $mail->Port       = $_ENV['SMTP_PORT'];
        $mail->CharSet    = 'UTF-8';

        // Expéditeur et Destinataire
        $mail->setFrom('brunomiguel1997dh@gmail.com', 'Projet Vagabond');
        $mail->addAddress($to);

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        // Version texte brut pour les vieux clients mail
        $mail->AltBody = strip_tags($body);

        return $mail->send(); 

    } catch (Exception $e) {
        echo "Erreur Mailer : {$mail->ErrorInfo}";
        return false;
    }
}
