<?php

/**
 * Vue Informations Personnelles
 * 
 * Affiche les informations du compte utilisateur.
 * @var array $user Données de l'utilisateur (nom, prenom, email, role).
 * Traduit l'ID numérique du rôle en libellé compréhensible (Admin, Rédacteur, Membre).
 */


/**
 * Gestion du libellé du rôle
 * Récupération l'ID numérique de la base de données en texte.
 */
$nameRoles = [
    1 => "Administrateur",
    2 => "Rédacteur",
    3 => "Membre"
];

// Récupération du nom associé à l'ID stocké en session, 
// sinon on affiche "Utilisateur" par défaut
$roleLibelle = $nameRoles[$user['role']] ?? "Utilisateur";
?>

<div class="admin-view-container">
    <h1 id="info-user-title">Mes informations personnelles</h1>

    <?php // Section informations de l'utilisateur 
    ?>
    <section class="profile-details-section" aria-labelledby="info-user-title">
        <div class="profile-user">
            <p><strong>Nom :</strong> <?= htmlspecialchars($user['nom']) ?></p>
            <p><strong>Prénom :</strong> <?= htmlspecialchars($user['prenom']) ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Rôle :</strong> <?= htmlspecialchars($roleLibelle) ?></p>
        </div>

        <?php // Lien vers la page de modification de profil 
        ?>
        <div class="profile-actions">
            <a href="index.php?action=editProfile" class="btn-read" aria-label="Modifier mes informations personnelles">
                Modifier mon profil
            </a>
        </div>
    </section>
</div>