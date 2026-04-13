<?php

/**
 * Vue d'un Article
 * 
 * Affiche le contenu complet d'un récit de voyage et ses interactions :
 * @var array $article Données du récit (titre, contenu, image, id_recit).
 * @var array $comments Liste des commentaires associés.
 * @var PDO $db  : Instance de connexion pour la vérification des favoris.
 * $_SESSION['user'] pour l'affichage des options de favoris et commentaires.
 */

?>

<article class="article-detail">
    <?php // Titre de l'article ?>
    <header>
        <h1><?= htmlspecialchars($article['titre']) ?></h1>

    </header>

   <?php // Vérifie s'il y a une image associée à l'article ?>
    <?php if (!empty($article['image'])): ?>
        <div class="imageArticle">
            <?php // Affichage de l'image ?>
            <img src="index.php?action=viewImage&name=<?= urlencode($article['image']) ?>"
                alt="<?= htmlspecialchars($article['titre']) ?>"
                class="img-fluid">
        </div>
    <?php endif; ?>

    <?php // Contenu principal de l'article ?>
    <div class="article_content">
        <?= nl2br(htmlspecialchars($article['contenu'])) ?>
    </div>

    <?php // Ajouter/retirer des favoris?>
    <div class="">
        <?php if (isset($_SESSION['user'])): ?>
            <a href="index.php?action=favorites&id=<?= (int)$article['id_recit'] ?>" >
                <?php if (isFavorite($db, (int)$_SESSION['user']['id'], (int)$article['id_recit'])): ?>
                    <span title="Retirer des favoris"><i class="fa-solid fa-heart"></i> Retirer des favoris</span>
                <?php else: ?>
                    <span title="Ajouter aux favoris"><i class="fa-regular fa-heart"></i> Ajouter aux favoris</span>
                <?php endif; ?>
            </a>
        <?php endif; ?>
    </div>

    <?php // Commentaires ?>
    <section class="comments">
        <?php // Affiche le nombre total de commentaires ?>
        <h3><?= count($comments) ?> Commentaires</h3>

        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <p>
                        <?php // Affiche le nom et prénom de l'auteur du commentaire ?>
                        <strong><?= htmlspecialchars($comment['prenom'] . ' ' . $comment['nom']) ?></strong>
                        <?php // Affiche la date du commentaire ?>
                        <small><?= date('d/m/Y', strtotime($comment['date_commentaire'])) ?></small>
                    </p>
                    <?php // Affiche le contenu du commentaire  ?>
                    <p><?= nl2br(htmlspecialchars($comment['commentaire'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <?php   // Message si aucun commentaire n'est présent ?>
            <p>Aucun commentaire pour le moment. Soyez le premier à donner votre avis !</p>
        <?php endif; ?>

        <?php // Formulaire pour ajouter un nouveau commentaire ?>
        <div class="comment-form">
            <h4>Laisser un commentaire</h4>
            <form action="index.php?action=addComment&id=<?= (int)$article['id_recit'] ?>" method="POST">
                <textarea name="comment" rows="5" required placeholder="Votre message..."></textarea>
                <button type="submit" class="btn-submit">Laisser un commentaire</button>
            </form>
        </div>
    </section>
</article>

<?php
    // Footer
    require RACINE. "/app/view/partials/footer.php"; 
?>