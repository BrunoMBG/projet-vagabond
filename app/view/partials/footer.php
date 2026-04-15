<?php
/**
 * Vue Footer
 * 
 * Affiche le copyright et le lien vers les mentions légales.
 */
?>

<footer class="footer-container" role="contentinfo">
    <div class="footer-content">
        <?php // copyright ?>
        <div class="footer-info">
            <p>&copy; 2026 <strong>Vagabond</strong> - Tous droits réservés</p>
        </div>
        <?php // Menu ?>
        <nav class="footer-link" aria-label="Liens secondaires">
            <a href="index.php?action=legal_Notice" class="footer-link-nav">Mentions légales</a>
            <span class="border">|</span>
            <a href="index.php?action=contact" class="footer-link-nav">Contact</a>
        </nav>
    </div>
</footer>