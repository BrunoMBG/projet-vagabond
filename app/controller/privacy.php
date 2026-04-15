<?php

/**
 * Affiche la page de politique de confidentialité.
 */
function privacyPage(): void
{
    global $title;
    $title = "Politique de Confidentialité - Vagabond";

    require_once RACINE . '/app/view/privacy.php';
}
