<article class="article-detail">
    <?php // Titre de l'article ?>
    <header>
        <h1><?= htmlspecialchars($article['titre']) ?></h1>

    </header>
    <?php // Vérifie s'il y a une image ?>
    <?php if (!empty($article['image'])): ?>
        <div class="imageArticle">
            <img src="index.php?action=viewImage&name=<?= urlencode($article['image']) ?>"
                alt="<?= htmlspecialchars($article['titre']) ?>"
                class="img-fluid">
        </div>
    <?php endif; ?>

    <div class="article_content">
        <?= nl2br(htmlspecialchars($article['contenu'])) ?>
    </div>

    <hr>
    <?php // Commentaires ?>
    <section class="comments">
     
        <h3>X Commentaires</h3>
        <?php // Commentaire ?>
        <div class="comment">
            <?php // Prénom/nom et date ?>
            <p><strong>X</strong> <small>x/x/xxxx</small></p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi atque consequatur mollitia consectetur debitis possimus?</p>
        </div>
        <?php // Formulaire ?>
        <div class="comment-form">
            <h4>Laisser un commentaire</h4>
            <form action="#" method="POST">
                <textarea name="comment" rows="5"></textarea>
                <button type="submit" class="btn-submit">Laisser un commentaire</button>
            </form>
        </div>
    </section>
</article>