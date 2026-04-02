<?php // ==================== Head ==================== 
?>

<?php require_once RACINE . '/app/view/partials/head.php'; ?>

<body>
    <?php // ==================== Header ==================== 
    ?>
    <?php require RACINE . '/app/view/partials/header.php'; ?>

    <main">
        <div">
            <!-- Vérifie s'il utilisateur est admin -->
            <?php if ($_SESSION['user_role'] == 1): ?>
                <section>
                    <h2>Gestion des Utilisateurs</h2>

                    <table>
                        <!-- Les titres du tableau -->
                        <thead>
                            <tr>
                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>Rôle</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <!-- Les cellules -->
                        <tbody>
                            <?php // Boucle sur chaque utilisateur récupéré via le contrôleur 
                            ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['prenom']) ?></td>
                                    <td><?= htmlspecialchars($user['nom']) ?></td>
                                    <td>
                                        <span">
                                            <?php // Affiche le labelle de chaque rôle 
                                            ?>
                                            <?= htmlspecialchars($user['libelle']) ?>
                                            </span>
                                    </td>
                                    <td>
                                        <form action="index.php?action=user_update_role" method="POST">
                                            <input type="hidden" name="id_utilisateur" value="<?= $user['id_utilisateur'] ?>">

                                            <?php // Pré-sélection du rôle actuel 
                                            ?>
                                            <select name="changeRole">
                                                <?php foreach ($roles as $role): ?>
                                                    <option value="<?= $role['id_role'] ?>" <?= ($user['id_role'] == $role['id_role']) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($role['libelle']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>

                                            <?php // Boutton de validation 
                                            ?>
                                            <button type="submit">OK</button>

                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>
            <?php endif; ?>

            </div>
            </main>
</body>

</html>