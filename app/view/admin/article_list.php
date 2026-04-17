<?php

/**
 * Vue Gestion des Articles
 * 
 * Cette vue permet d'afficher la liste des articles existants sous forme de tableau.
 * Cette vue est destinée au backoffice pour les administrateurs
 * ou rédacteurs afin de gérer les contenus existants.
 * * @var array|null $articles Liste des articles à afficher
 */

?>

<div class="admin-view-container">
    <?php // Vérifie si la liste des articles existe (affichage du tableau) ?>
    <?php if (isset($articles)): ?>
        <table class="table-admin-article">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Destination</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php // Boucle sur tous les articles ?>
                <?php foreach ($articles as $article): ?>
                    <tr>
                        <td><?= $article['id_recit'] ?></td>

                        <td><?= htmlspecialchars($article['titre']) ?></td>

                        <td><?= htmlspecialchars($article['nom_destination']) ?></td>
                        <td>
                            <?php // Lien vers la page de modification avec l'ID de l'article ?>
                            <a href="index.php?action=articleEdit&id=<?= $article['id_recit'] ?>" class="btn btn-update">Modifier</a>

                            <?php // Lien vers la page de suppression avec l'ID de l'article ?>
                            <a href="index.php?action=articleDelete&id=<?= $article['id_recit'] ?>" class="btnDelete">
                                Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; // Fin de la boucle ?>
            </tbody>
        </table>

    <?php else: ?>
        <p>Aucune donnée à afficher.</p>
    <?php endif; ?>
</div>