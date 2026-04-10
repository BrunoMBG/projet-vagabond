<?php

/**
 * Modèle Article & Interactions
 * 
 * article centralise toutes les requêtes SQL liées aux récits de voyage.
 * addArticle           : Enregistre un nouveau récit de voyage en base de données.
 * getAllDestinations   : Liste toutes les destinations disponibles en (ordre alphabétique).
 * getAllArticles       : Récupère l'intégralité des récits avec leurs destinations.
 * getArticleById       : Récupère les détails d'un récit spécifique via son ID.
 * getLatestArticles    : Récupère les derniers récits (pour la page d'accueil).
 */


/**
 * Ajout un nouveau article dans la base de données.
 * @param PDO $db Connexion à la base de données.
 * @param string $titre Le titre du récit.
 * @param string $contenu Le texte du récit.
 * @param string|null $image Le nom du fichier image.
 * @param int $id_user L'identifiant de l'auteur (clé étrangère utilisateurs).
 * @param int $id_destination L'identifiant de la destination (clé étrangère destination).
 * @return bool Retourne true si l'insertion a réussi, false sinon.
 */
function addArticle(PDO $db, string $titre, string $contenu, ?string $image, int $id_user, int $id_destination): bool
{
    $sql = "INSERT INTO recits (titre, contenu, image, id_destination, id_utilisateur) 
            VALUES (?, ?, ?, ?, ?)";

    $query = $db->prepare($sql);

    return $query->execute([
        $titre,
        $contenu,
        $image,
        $id_destination,
        $id_user
    ]);
}

/**
 * Supprime un récit de la base de données.
 * @param PDO $db Connexion à la base de données.
 * @param int $id L'identifiant du récit à supprimer.
 * @return bool Retourne true en cas de succès.
 */
function deleteArticle(PDO $db, int $id): bool
{
    $sql = "DELETE FROM recits WHERE id_recit = ?";
    $query = $db->prepare($sql);
    return $query->execute([$id]);
}

/**
 * Récupère la liste de tous les articles avec leur destination.
 * @param PDO $db Connexion à la base de données.
 * @return array Liste des articles avec les informations de destination et d'utilisateur.
 */
function getAllArticles($db)
{
    $sql = "SELECT r.*, d.nom_destination 
            FROM recits r
            JOIN destinations d ON r.id_destination = d.id_destination
            ORDER BY r.date_creation DESC";

    $query = $db->query($sql);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * Récupère un seul article par son ID.
 * @param PDO $db Connexion à la base de données.
 * @param int $id id de l'article
 * @return array Retourne les données de l'article ou false si non trouvé.
 */
function getArticleById(PDO $db, int $id)
{
    $sql = "SELECT r.*, d.nom_destination 
            FROM recits r
            JOIN destinations d ON r.id_destination = d.id_destination
            WHERE r.id_recit = ?";

    $query = $db->prepare($sql);
    $query->execute([$id]);

    return $query->fetch(PDO::FETCH_ASSOC);
}


/**
 * Récupère les derniers récits publiés avec une limite définie.
 * * @param PDO $db Connexion à la base de données.
 * @param int $limit Nombre d'articles à récupérer (par défaut 3).
 * @return array Liste des articles les plus récents.
 */
function getLatestArticles($db, $limit = 3)
{
    $sql = "SELECT r.*, d.nom_destination 
            FROM recits r
            JOIN destinations d ON r.id_destination = d.id_destination
            ORDER BY r.date_creation DESC
            LIMIT $limit";

    $query = $db->query($sql);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * Met à jour les informations d'un récit existant dans la base de données.
 * @param PDO $db Connexion à la base de données.
 * @param int $id L'identifiant unique du récit à modifier.
 * @param string $titre Le titre du récit.
 * @param string $contenu Le corps du texte.
 * @param string|null $image Le nom du fichier image.
 * @param int $id_destination L'identifiant de la destination associée.
 * @return bool Retourne true si la mise à jour a réussi, false en cas d'échec.
 */
function updateArticle(PDO $db, int $id, string $titre, string $contenu, ?string $image, int $id_destination): bool
{
    $sql = "UPDATE recits 
            SET titre = ?, contenu = ?, image = ?, id_destination = ? 
            WHERE id_recit = ?";

    $query = $db->prepare($sql);
    return $query->execute([$titre, $contenu, $image, $id_destination, $id]);
}
