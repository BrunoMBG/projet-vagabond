<?php

/**
 * Vue Inscription
 * 
 * Affiche l'interface de création de compte pour les nouveaux visiteurs :
 * @var string $formRegister Bloc HTML complet généré par la classe 'Form'.
 */

?>

<div class="auth-container">
    <h1>Créer un compte</h1>
    <section> 
        <?= $formRegister; ?>
    </section>
    <p class="back-link"><a href="index.php?action=login">Retour à la connexion</a></p>
</div>