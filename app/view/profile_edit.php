<?php

/**
 * Vue Modification du Profil
 * Permet à l'utilisateur de mettre à jour ses informations personnelles.
 * @var string $formEdit Bloc HTML du formulaire généré par la classe 'Form'.
 */

?>
<!-- <h1>Modifier mon profil</h1> -->
<?php // ==================== Formulaire ==================== ?>

<div class="admin-view-container">
    <h1 id="profile-title">Modifier mon profil</h1>

    <section class="profile-edit-section" aria-labelledby="profile-title">
        <?= $formEdit; ?>
    </section>
</div>