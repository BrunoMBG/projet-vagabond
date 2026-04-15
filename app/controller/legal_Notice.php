<?php

/**
 * Affiche la page des mentions légales.
 */
function mentionsLegales(): void
{   
     global $title;
    $title = "Mentions Légales - Vagabond";

    require_once RACINE . '/app/view/legal_Notice.php';
}
