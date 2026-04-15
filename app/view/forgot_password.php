<?php
/**
 * Vue Formulaire de demande de récupération de mot de passe.
 * 
 * Cette page affiche un champ de saisie pour l'adresse email de l'utilisateur.
 * Une fois le formulaire soumis, le contrôleur traitera la demande pour envoyer
 * un lien de réinitialisation sécurisé par email.
 */
?>

<div class="auth-container">
    
    <h1 id="forgot-title">Mot de passe oublié</h1>

    <?php // ==================== Formulaire ==================== ?>
    <section aria-labelledby="forgot-title">
        <?= $formPassword ?>
    </section>

    <p class="back-link">
        <a href="index.php?action=login">Retour à la connexion</a>
    </p>
</div>