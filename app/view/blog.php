<?php

/**
 * Vue Liste des Articles 
 * 
 * Affiche une grille de résumés de tous les récits de voyage :
 * @var array $articles Liste des récits (id_recit, titre, contenu, image).
 * @var array $filters Liste des destinations pour les filtres.
 */

?>

<?php // Section hero 
    require RACINE . "/app/view/partials/hero.php";
?>

<?php // Section système de filtres ?>
<section class="filterContainer">
    <h2 class="blog-filtered-title">Destinations</h2>

    <?php // Bouton par défaut, affiché comme 'active' si aucune destination n'est sélectionnée dans l'URL ?>
    <a href="index.php?action=blog"
        class="<?= !isset($_GET['dest']) ? 'active' : '' ?>">
        Tous
    </a>

    <?php // Boucle de création des filtres par destination ?>
    <?php foreach ($filters as $filter): ?>
        <a href="index.php?action=blog&dest=<?= $filter['id_destination'] ?>"
            class="filter <?= (isset($_GET['dest']) && $_GET['dest'] == $filter['id_destination']) ? 'active' : '' ?>">
            <?= htmlspecialchars($filter['nom_destination']) ?>
        </a>
    <?php endforeach; ?>
</section>

<?php // Section affichage des articles ?>
<section class="blog-container">
    <h2 class="blog-article-title">Mes Voyages</h2>

    <?php // Si la destination sélectionnée n'a aucun article ?>
    <?php if (empty($articles)): ?>
        <p>Aucun récit pour cette destination pour le moment.</p>
    <?php else: ?>

        <?php // Boucle principale d'affichage desarticles ?>
        <?php foreach ($articles as $article): ?>

            <?php // Article ?>
            <article class="blog-article">

                <?php // Image ?>
                <div class="articles-images">
                    <?php if (!empty($article['image'])): ?>
                        <img src="index.php?action=viewImage&name=<?= htmlspecialchars($article['image']) ?>"
                            alt="Image du récit">
                    <?php endif; ?>
                </div>

                
                <?php // Contenu de l'article ?>
                <div class="last-article-content">

                    <?php // titre de l'article ?>
                    <h3><?= htmlspecialchars($article['titre']) ?></h3>

                    <?php // texte de l'article ?>
                    <p><?= nl2br(htmlspecialchars(substr($article['contenu'], 0, 100))) ?>...</p>
                    
                    <?php // Lien de l'article ?>
                    <div class="last-article-btn">
                        <a href="index.php?action=articleView&id=<?= $article['id_recit'] ?>" class="btn-read">Lire plus</a>
                    </div>
                    
                </div>
            </article>
        <?php endforeach; // Fin de la boucle ?>
    <?php endif; // Fin de la condition?>
</section>

<?php
    // Footer
    require RACINE. "/app/view/partials/footer.php"; 
?>