<?php
/**
 * Vue Section Hero.
 * 
 * Affiche une vidéo d'arrière-plan .
 */
?>

<section class="hero-video" aria-label="Introduction visuelle">
    <video autoplay muted loop playsinline poster="./public/images/hero-fallback.webp" class="hero-bg-video" aria-hidden="true">
        <source src="public/videos/voyage.webm" type="video/webm">
        <source src="public/videos/voyage.mp4" type="video/mp4">
        Votre navigateur ne supporte pas la lecture de vidéos.
    </video>
    <div class="hero-video-overlay" aria-hidden="true"></div>
</section>