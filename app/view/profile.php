<?php
/**
 * Vue Informations Personnelles
 * 
 * Affiche les informations du compte utilisateur :
 * @var array $user Données de l'utilisateur (nom, prenom, email, role).
 * Traduit l'ID numérique du rôle en libellé compréhensible (Admin, Rédacteur, Membre).
 */
?>
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