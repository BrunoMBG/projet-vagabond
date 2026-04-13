<?php
/**
 * Vue Page d'Accueil
 * Présentation du site et affichage des trois derniers récits de voyage.
 * @var array $articles Liste des 3 derniers articles récupérés par le contrôleur.
 */
?>

<?php // Section hero ?>
<section class="hero-video">
    <video autoplay muted loop playsinline poster="img/hero-fallback.jpg" class="hero-bg-video">
        <source src="public/videos/voyage.mp4" type="video/mp4">
        Votre navigateur ne supporte pas la lecture de vidéos.
    </video>
    <div class="hero-video-overlay"></div>
</section>

<?php // Section des derniers articles ?>
<section class="">
    <div class="">

        <?php // Titre de la section ?>
        <header class="">
            <h2>Mes derniers voyages</h2>
        </header>
        
         <?php // Liste des articles ?>
        <div class="">
            <?php if (!empty($articles)): ?>

                <?php // Boucle sur les articles ?>
                <?php foreach ($articles as $article): ?>
                    <article class="">

                         <?php // Vérifie si une image est associée à l'article ?>
                        <?php if (!empty($article['image'])): ?>
                            <div class="">
                                <img src="index.php?action=viewImage&name=<?= urlencode($article['image']) ?>" 
                                     alt="<?= htmlspecialchars($article['titre']) ?>">
                            </div>
                        <?php endif; ?>

                        <?php // Titre de l'article ?>
                        <div class="">
                            <h3><?= htmlspecialchars($article['titre']) ?></h3>

                            <?php // Extrait du contenu (100 caractères max) ?>
                            <p><?= nl2br(htmlspecialchars(substr($article['contenu'], 0, 100))) ?>...</p>
                            
                            <?php // Lien vers la page détaillée de l'article ?>
                            <div class="">
                                <a href="index.php?action=articleView&id=<?= $article['id_recit'] ?>" class="btn-read">
                                    Lire la suite
                                </a>
                            </div>
                        </div>

                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>