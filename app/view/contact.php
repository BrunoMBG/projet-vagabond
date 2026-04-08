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
<section class="">
    <h1>Contactez-nous</h1>

    <div class="">
        <p>
            Une question, une suggestion ou une envie de collaborer ?
            Nous sommes à votre écoute.
        </p>
    </div>

    <div class="form-wrapper">
        <?= $contactFormHtml; ?>
    </div>
</section>