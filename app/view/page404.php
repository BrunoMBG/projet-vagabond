<?php

/**
 * Vue Erreur 404
 * 
 * Affichée lorsque l'action demandée ou l'URL n'existe pas.
 */

?>

<div class="error-container">
    <section class="error" aria-labelledby="error-title">
        <h1 id="error-title">Oups ! Ce chemin n'existe pas.</h1>
        
        <div class="error-content">
            <p class="error-code">Erreur 404</p>
            <p>Il semble que vous vous soyez égaré en chemin. Pas de panique, même les meilleurs vagabonds se perdent parfois !</p>
        </div>

        <div class="error-actions">
            <a href="index.php?action=default" class="btn-read" aria-label="Retourner à la page d'accueil">
               Accueil
            </a>
        </div>
    </section>
</div>