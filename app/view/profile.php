<?php // ==================== Head ==================== ?>
<?php require_once RACINE . '/app/view/partials/head.php'; ?>

<body>
    <?php // ==================== Header ==================== ?>
    <?php require RACINE . '/app/view/partials/header.php'; ?>
    <!--====================  Main ==================== -->
    <main>
        <h1>
            Mes informations personnelles
        </h1>
        <div class="profile-card">
            <p><strong>Nom :</strong> <?= htmlspecialchars($user['nom']) ?></p>
            <p><strong>Prénom :</strong> <?= htmlspecialchars($user['prenom']) ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
            <?php
                /**
                 * Gestion du libellé du rôle
                 * Récupération l'ID numérique de la base de données en texte.
                 */
                $nomsRoles = [
                    1 => "Administrateur",
                    2 => "Rédacteur",
                    3 => "Membre"
                ];

                // Récupération du nom associé à l'ID stocké en session, 
                // sinon on affiche "Utilisateur" par défaut
                $roleLibelle = $nomsRoles[$user['role']] ?? "Utilisateur";
            ?>
            <p><strong>Rôle : <?= htmlspecialchars($roleLibelle) ?></strong> </p>
        </div>
    </main>
</body>

</html>