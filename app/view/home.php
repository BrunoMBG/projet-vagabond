<?php
/**
 * Vue Page d'Accueil
 * Présentation du site et affichage des trois derniers récits de voyage.
 * @var array $articles Liste des 3 derniers articles récupérés par le contrôleur.
 */
?>

<?php // Section hero 
    require RACINE . "/app/view/partials/hero.php";
?>

<?php // Section intro ?>
<section class="intro-home-container" aria-labelledby="intro-title">
    <div class="intro-home">
        <h1 id="intro-title">Vagabond : L'art de voyager et de partager</h1>
        
        <p>
            Bienvenue sur <strong>Vagabond</strong>, un espace dédié à tous ceux pour qui voyager est bien plus qu'un simple déplacement. C'est une quête de sens, une immersion dans l'inconnu et une rencontre avec l'autre. À travers nos <strong>récits de voyage</strong>, nous vous invitons à découvrir le monde avec un regard neuf et curieux.
        </p>

        <p>
            Que ce soit pour une escapade sauvage au cœur de la nature, une exploration urbaine ou la découverte de traditions lointaines, chaque article est conçu pour vous offrir une <strong>expérience authentique</strong>. Nous croyons que chaque chemin parcouru mérite d'être raconté, car c'est dans le partage que l'aventure prend tout son sens.
        </p>

        <p>
            Laissez-vous inspirer par nos dernières <strong>aventures</strong>, préparez vos futurs itinéraires et rejoignez une communauté de passionnés qui, comme vous, ont l'âme d'un vagabond.
        </p>
    </div>
</section>

<?php // Section des derniers articles ?>
<section class="last-articles-container" aria-labelledby="travels-title">
    <div class="last-articles-">

        <?php // Titre de la section ?>
        <header class="last-articles-title">
            <h2 id="travels-title">Mes derniers voyages</h2>
        </header>
        
         <?php // Liste des articles ?>
        <div class="articles-container">
            <?php if (!empty($articles)): ?>

                <?php // Boucle sur les articles ?>
                <?php foreach ($articles as $article): ?>
                    <article class="last-article">

                         <?php // Vérifie si une image est associée à l'article ?>
                        <?php if (!empty($article['image'])): ?>
                            <div class="articles-images">
                                <img src="index.php?action=viewImage&name=<?= urlencode($article['image']) ?>" 
                                     alt="Illustration du récit : <?= htmlspecialchars($article['titre']) ?>">
                            </div>
                        <?php endif; ?>

                        <?php // Titre de l'article ?>
                        <div class="last-article-content">
                            <h3><?= htmlspecialchars($article['titre']) ?></h3>

                            <?php // Extrait du contenu (100 caractères max) ?>
                            <p><?= nl2br(htmlspecialchars(substr($article['contenu'], 0, 100))) ?>...</p>
                            
                            <?php // Lien vers la page détaillée de l'article ?>
                            <div class="last-article-btn">
                                <a href="index.php?action=articleView&id=<?= $article['id_recit'] ?>" 
                                class="btn-read" 
                                aria-label="Lire la suite : <?= htmlspecialchars($article['titre']) ?>">
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

<?php // Section CTA ?>
<section class="home-cta-container" aria-labelledby="cta-title">
    <div class="home-cta">
        <h2 id="cta-title">Prêt pour le départ ?</h2>
        <p>Découvrez l'intégralité de nos aventures et trouvez l'inspiration pour votre prochain voyage.</p>
        <a href="index.php?action=blog" class="btn-cta" aria-label="Voir tous les articles du blog">
            Explorer tous les récits
        </a>
    </div>
</section>