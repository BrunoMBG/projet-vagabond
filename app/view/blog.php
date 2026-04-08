<?php

/**
 * Vue Liste des Articles 
 * 
 * Affiche une grille de résumés de tous les récits de voyage :
 * $articles (array) : Liste des récits (id_recit, titre, contenu, image).
 * Utilise substr() pour limiter l'affichage du texte en page d'accueil.
 */

?>
<h1>blog</h1>

<section class="articlesContainer">
    <?php foreach ($articles as $article): ?>
        <article class="article">
            <?php if (!empty($article['image'])): ?>
                <img src="index.php?action=viewImage&name=<?= htmlspecialchars($article['image']) ?>"
                    alt="Image du récit"
                    width="200">
            <?php endif; ?>

            <div class="">
                <h2><?= htmlspecialchars($article['titre']) ?></h2>

                <p><?= nl2br(htmlspecialchars(substr($article['contenu'], 0, 100))) ?>...</p>

                <a href="index.php?action=articleView&id=<?= $article['id_recit'] ?>" class="">Lire plus</a>
            </div>
        </article>
    <?php endforeach; ?>
</section>