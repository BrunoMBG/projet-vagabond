<?php

/**
 *  Vue Ajout d'Article (Backoffice)
 * 
 * Interface de création de contenu réservée aux Rédacteurs et Administrateurs.
 * @var string $formArticle Bloc HTML du formulaire généré par la classe 'Form'.
 * Permet la saisie du titre, du contenu, du choix de la destination et de l'image.
 */

?>
<h1>Ajouter un article</h1>

<section>
    <?= $formArticle; ?>
</section>

<?php
    // Footer
    require RACINE. "/app/view/partials/footer.php"; 
?>