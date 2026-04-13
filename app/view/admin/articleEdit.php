<?php

/**
 * Vue Gestion des Articles 
 * 
 * Cette vue permet soit d'afficher la liste des articles existants,
 * soit de modifier un article en fonction des données disponibles.
 * 
 * Si la variable $articles est définie :
 * Affiche un tableau listant tous les articles
 * 
 * Si la variable $formEdit est définie :
 * Affiche un formulaire de modification d’un article spécifique
 * Propose également un lien pour revenir à la liste des articles
 * 
 * 
 * Cette vue est destinée au backoffice pour les administrateurs
 * ou rédacteurs afin de gérer les contenus existants.
 * 
 * @var array|null $articles Liste des articles à afficher
 * @var string|null $formEdit Formulaire HTML de modification généré dynamiquement
 */

?>

<?php // Vérifie si la liste des articles existe (affichage du tableau) ?>
<?php if (isset($articles)): ?>
    <h2>Gestion des articles</h2>

    <!-- Tableau affichant la liste des articles -->
    <table class="">
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
                <!-- Affichage de l'ID -->
                <td><?= $article['id_recit'] ?></td>

                <!-- Affichage du titre -->
                <td><?= htmlspecialchars($article['titre']) ?></td>

                <!-- Affichage du nom de la destination -->
                <td><?= htmlspecialchars($article['nom_destination']) ?></td>
                <td>
                     <?php // Lien vers la page de modification avec l'ID de l'article  ?> 
                    <a href="index.php?action=articleEdit&id=<?= $article['id_recit'] ?>" class="btn btn-warning">Modifier</a>

                    <?php // Lien vers la page de suppression avec l'ID de l'article  ?>
                    <a href="index.php?action=articleDelete&id=<?= $article['id_recit'] ?>" 
                    class="btnDelete">
                    Supprimer
                    </a>
                </td>
            </tr>
            <?php endforeach; // Fin de la boucle?>
        </tbody>
    </table>

<?php // Si aucun tableau mais un formulaire de modification est disponible ?>
<?php elseif (isset($formEdit)): ?>
    <h2>Modifier le récit</h2>
    
    <!-- Conteneur du formulaire de modification -->
    <div class="">
        <?= $formEdit ?>
    </div>


    <!-- Lien pour revenir à la liste des articles -->
    <p><a href="index.php?action=articleManagement">Retour à la liste</a></p>

<?php else: ?>
    <!-- Message affiché si aucune donnée n'est disponible -->
    <p>Aucune donnée à afficher.</p>

<?php endif; // Fin de la condition principale?>

<?php
    // Footer
    require RACINE. "/app/view/partials/footer.php"; 
?>