<?php

    /**
     * Vue Formulaire de Contact
     * 
     * Affiche l'interface de prise de contact avec les utilisateurs
     * @var string $contactFormHtml Contenu HTML complet du formulaire pré-généré.
     * Le formulaire est généralement construit via la classe Form dans le contrôleur.
     */

?>

<?php // Formulaire ?>
<section class="contact-section" aria-labelledby="contact-title">
    <h1 id="contact-title">Contactez-nous</h1>

    <div class="contact-form-container">
        <?= $contactFormHtml; ?>
    </div>
</section>