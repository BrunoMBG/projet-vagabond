<?php

/**
 * Vue Modification d'un Article
 * 
 * Cette vue affiche le formulaire de modification généré par la classe Form.
 * Elle est appelée lorsque l'administrateur clique sur le bouton "Modifier".
 * @var string|null $formEdit Formulaire HTML de modification
 */

?>

<div class="admin-view-container">
    <h2>Modifier le récit</h2>

    <?php // Vérifie si le formulaire de modification est disponible ?>
    <?php if (isset($formEdit)): ?>
        
        <div class="update-article">
            <?= $formEdit ?>
        </div>

        <p>
            <a href="index.php?action=articleManagement" class="link-articlEdit">
                <i class="fas fa-arrow-left"></i> Retour à la liste des articles
            </a>
        </p>

    <?php else: ?>
        <p>Erreur : Le formulaire de modification n'a pas pu être généré.</p>
    <?php endif; ?>
</div>