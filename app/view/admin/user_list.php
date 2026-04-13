<?php

/**
 * Vue Gestion des Utilisateurs (Admin)
 * 
 * Interface permettant de modifier les privilèges des membres :
 *  Interface permettant de modifier les privilèges des membres.
 * @var array $users Liste des utilisateurs (id_utilisateur, prenom, nom, id_role, libelle).
 * @var array $roles Liste de tous les rôles disponibles (id_role, libelle).
 */

?>
<?php if ($_SESSION['user_role'] === 1): ?>
<div class="admin-view-container">
    <section>
        <h2>Gestion des Utilisateurs</h2>

        <?php //  SESSION d'affichage des messages ?>
        <?php if (isset($_SESSION['displayMessage'])): ?>

            <?php // Ajout la classe CSS et affiche le texte sécurisé ?>
            <div class="messageRole-<?= $_SESSION['displayMessage']['type'] ?>">
                <?= htmlspecialchars($_SESSION['displayMessage']['message']) ?>
            </div>

            <?php // Détruit la variable de session immédiatement après l'affichage ?>
            <?php unset($_SESSION['displayMessage']); ?>
        <?php endif; ?>

       <table class="table-article">
            <thead>
                <tr>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Rôle</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php // Boucle sur chaque utilisateur récupéré via le contrôleur ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td data-label="Prénom"><?= htmlspecialchars($user['prenom']) ?></td>
                        <td data-label="Nom"><?= htmlspecialchars($user['nom']) ?></td>
                        <td data-label="Rôle">
                            <span>
                                <?php // Affiche le labelle de chaque rôle 
                                ?>
                                <?= htmlspecialchars($user['libelle']) ?>
                            </span>
                        </td>
                        <td data-label="Action">
                            <form action="index.php?action=user_update_role" method="POST">
                                <input type="hidden" name="id_utilisateur" value="<?= $user['id_utilisateur'] ?>">

                                <?php // Pré-sélection du rôle actuel ?>
                                <select name="changeRole">
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?= $role['id_role'] ?>" <?= ($user['id_role'] == $role['id_role']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($role['libelle']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <?php // Boutton de validation ?>
                                <button class ="btn-role" type="submit">OK</button>

                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>
<?php endif; ?>

<?php
    // Footer
    require RACINE. "/app/view/partials/footer.php"; 
?>