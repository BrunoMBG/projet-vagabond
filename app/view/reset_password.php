<?php
/**
 * Vue Formulaire de création d'un nouveau mot de passe.
 * 
 * Cette page est la destination du lien envoyé par email. Elle permet à l'utilisateur
 * de saisir son nouveau mot de passe. Le formulaire n'est accessible que si le 
 * token passé en URL est valide et n'a pas expiré.
 */
?>

<div class="container">
    <h2>Réinitialisation de votre mot de passe</h2>

    <div class="form-wrapper">
        <?= $formReset ?>
    </div>
</div>

<?php
    // Footer
    require RACINE. "/app/view/partials/footer.php"; 
?>