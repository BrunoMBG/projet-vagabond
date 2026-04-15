<?php

/**
 * Vue Inscription
 * 
 * Affiche l'interface de création de compte pour les nouveaux visiteurs :
 * @var string $formRegister Bloc HTML complet généré par la classe 'Form'.
 */

?>

<div class="auth-container">
    <h1 id="register-title">Créer un compte</h1>
    <section class="auth-section" aria-labelledby="register-title"> 
        <?= $formRegister; ?>
    </section>
    <p class="back-link"><a href="index.php?action=login" aria-label="Retourner à la page de connexion">Retour à la connexion</a></p>
</div>