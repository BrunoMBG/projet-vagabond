<?php
/**
 * Vue Formulaire de création d'un nouveau mot de passe.
 * 
 * Cette page est la destination du lien envoyé par email. Elle permet à l'utilisateur
 * de saisir son nouveau mot de passe. Le formulaire n'est accessible que si le 
 * token passé en URL est valide et n'a pas expiré.
 */
?>


<div class="auth-container">
    <h1 id="reset-password-title">Réinitialisation de votre mot de passe</h1>

    <?php // ==================== Formulaire ==================== ?>
    <section class="auth-section" aria-labelledby="reset-password-title">
        <?= $formReset ?>
    </section>

    <p class="back-link">
        <a href="index.php?action=login" aria-label="Retourner à la page de connexion">Retour à la connexion</a>
    </p>
</div>