<?php

/**
 * Page Mes Favoris
 * 
 * my-favorites affiche la liste des récits que l'utilisateur connecté a ajoutés à ses favoris.
 * Si aucun favori n'est trouvé, un message informatif est affiché à l'utilisateur.
 */
?>

<section class="favorites-articles-container">
    <div class="last-articles-title">
        <h2>Mes Récits Favoris</h2>
    </div>

    <div class="favorites-articles">
        <?php if (!empty($favoriteArticles)): ?>
            <?php foreach ($favoriteArticles as $article): ?>
                <article class="favorite-article">
                    <div class="articles-images"> 
                        <img src="index.php?action=viewImage&name=<?= urlencode($article['image']) ?>" 
                        alt="<?= htmlspecialchars($article['titre']) ?>">
                    </div>

                    <div class="last-article-content">
                        <h3><?= htmlspecialchars($article['titre']) ?></h3>
                        <div class="last-article-btn"> 
                            <a href="index.php?action=articleView&id=<?= $article['id_recit'] ?>" 
                            class="btn-read">Lire plus</a>
                        </div>
                    </div>

                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="empty-msg">Vous n'avez pas encore de favoris.</p>
        <?php endif; ?>
    </div>
</section>