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
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Rôle</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php // Boucle sur chaque utilisateur récupéré via le contrôleur 
                            ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['prenom'] . " " . $user['nom']) ?></td>
                                    <td>
                                        <span">
                                            <?php // Affiche le labelle de chaque rôle 
                                            ?>
                                            <?= ($user['id_role'] == 1) ? 'Admin' : (($user['id_role'] == 2) ? 'Rédacteur' : 'Membre') ?>
                                            </span>
                                    </td>
                                    <td>
                                        <form action="index.php?action=user_update_role" method="POST" class="form-role-quick">
                                            <input type="hidden" name="id_utilisateur" value="<?= $user['id_utilisateur'] ?>">

                                            <?php // Pré-sélection du rôle actuel 
                                            ?>
                                            <select>
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