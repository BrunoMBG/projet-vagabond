<?php // ==================== Head ==================== ?>
<?php require_once RACINE . '/app/view/partials/head.php'; ?>

<body>
    <?php // ==================== Header ==================== 
    ?>
    <?php require RACINE . '/app/view/partials/header.php'; ?>
    <h1>blog</h1>

    <section class="articlesContainer"> <?php foreach ($articles as $article): ?>
            <article class="article">
                <?php if (!empty($article['image'])): ?>
                    <img src="public/images/<?= htmlspecialchars($article['image']) ?>" alt="Image du récit">
                <?php endif; ?>

                <div class="">
                    <h2><?= htmlspecialchars($article['titre']) ?></h2>

                    <p><?= nl2br(htmlspecialchars(substr($article['contenu'], 0, 100))) ?>...</p>

                    <a href="index.php?action=articleView&id=<?= $article['id_recit'] ?>" class="">Lire plus</a>
                </div>
            </article>
        <?php endforeach; ?>
    </section>
</body>

</html>