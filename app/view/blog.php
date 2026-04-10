<?php

/**
 * Vue Liste des Articles 
 * 
 * Affiche une grille de résumés de tous les récits de voyage :
 * @var array $articles Liste des récits (id_recit, titre, contenu, image).
 * @var array $filters Liste des destinations pour les filtres.
 */

?>

<?php // Section système de filtres ?>
<section class="filterContainer">

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
<section class="">

    <?php // Si la destination sélectionnée n'a aucun article ?>
    <?php if (empty($articles)): ?>
        <p>Aucun récit pour cette destination pour le moment.</p>
    <?php else: ?>

        <?php // Boucle principale d'affichage desarticles ?>
        <?php foreach ($articles as $article): ?>

            <?php // Article ?>
            <article class="article">

                <?php // Image ?>
                <?php if (!empty($article['image'])): ?>
                    <img src="index.php?action=viewImage&name=<?= htmlspecialchars($article['image']) ?>"
                        alt="Image du récit">
                <?php endif; ?>
                
                <?php // Contenu de l'article ?>
                <div class="">

                    <?php // titre de l'article ?>
                    <h2><?= htmlspecialchars($article['titre']) ?></h2>

                    <?php // texte de l'article ?>
                    <p><?= nl2br(htmlspecialchars(substr($article['contenu'], 0, 100))) ?>...</p>
                    
                    <?php // Lien de l'article ?>
                    <a href="index.php?action=articleView&id=<?= $article['id_recit'] ?>" class="">Lire plus</a>
                </div>
            </article>
        <?php endforeach; // Fin de la boucle ?>
    <?php endif; // Fin de la condition?>
</section>