<?php

/**
 * Vue Page de Connexion
 * 
 * Affiche l'interface d'authentification des utilisateurs.
 * @var string $formLogin Bloc HTML complet généré par la classe 'Form'.
 */
?>



<div class="auth-container">
    <h1 id="login-title">se connecter</h1>
    <?php // ==================== Formulaire ==================== ?>
    <section class="auth-section" aria-labelledby="login-title">
        <?= $formLogin; ?>
    </section>
</div>