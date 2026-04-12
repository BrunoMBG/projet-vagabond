<?php
/**
 * Vue Formulaire de demande de récupération de mot de passe.
 * 
 * Cette page affiche un champ de saisie pour l'adresse email de l'utilisateur.
 * Une fois le formulaire soumis, le contrôleur traitera la demande pour envoyer
 * un lien de réinitialisation sécurisé par email.
 */
?>

<div class="">
    
    <h1>Mot de passe oublié</h1>
    <?php // Formulaire ?>
    <section>
        <?= $formPassword ?>
    </section>

    
    <p><a href="index.php?action=login">Retour à la connexion</a></p>
</div>