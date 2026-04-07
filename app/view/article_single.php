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

    <hr>
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