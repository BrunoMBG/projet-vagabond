<?php

/**
 * Modèle Article & Interactions
 * 
 * article centralise toutes les requêtes SQL liées aux récits de voyage.
 * getArticlesFavorites : Récupère les récits et l'état des favoris pour un utilisateur.
 * addArticle           : Enregistre un nouveau récit de voyage en base de données.
 * getAllDestinations   : Liste toutes les destinations disponibles en (ordre alphabétique).
 * getAllArticles       : Récupère l'intégralité des récits avec leurs destinations.
 * getArticleById       : Récupère les détails d'un récit spécifique via son ID.
 * getCommentsByArticle : Liste les commentaires d'un récit avec l'identité des auteurs.
 * addComment           : Insère un nouveau commentaire pour un récit donné.
 * isFavorite           : Vérifie si un utilisateur a déjà liké un récit.
 * addFavorite          : Ajoute un lien de favori entre un utilisateur et un récit.
 * removeFavorite       : Supprime un récit des favoris d'un utilisateur.
 * getLatestArticles    : Récupère les derniers récits (pour la page d'accueil).
 */

/**
 * Récupère la liste des articles avec les infos auteur et favori
 * @param PDO $db Connexion à la base de données.
 * @param int|null $id_user ID de l'utilisateur pour vérifier ses favoris
 * @return array
 */
function getArticlesFavorites(PDO $db, ?int $id_user = null): array
{
    $sql = "SELECT a.*, 
                (SELECT COUNT(*) 
                FROM favoris f 
                WHERE f.id_article = a.id_recit 
                AND f.id_utilisateur = ?) AS is_favori
                FROM recits a
                ORDER BY a.date_creation DESC";

    $query = $db->prepare($sql);
    $query->execute([$id_user]);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}


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
 * Récupère la liste complète des destinations.
 * Cette fonction extrait l'identifiant et le nom de chaque destination,
 * classés par ordre alphabétique pour faciliter la lecture dans un formulaire.
 * @param PDO $db Connexion à la base de données.
 * @return array Un tableau associatif contenant les colonnes 'id_destination' et 'nom_destination'.
 */
function getAllDestinations(PDO $db): array
{
    $sql = "SELECT id_destination, nom_destination FROM destinations ORDER BY nom_destination ASC";
    $query = $db->query($sql);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère la liste de tous les articles avec leur destination et leur auteur.
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
    return $query->fetchAll();
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
 * Vérifie si un récit spécifique est marqué comme favori par un utilisateur.
 * @param PDO $db Connexion à la base de données.
 * @param int $id_user L'identifiant de l'utilisateur (issu de la session).
 * @param int $id_recit L'identifiant du récit à vérifier.
 * @return bool Retourne true si le favori existe, sinon false.
 */
function isFavorite(PDO $db, int $id_user, int $id_recit): bool
{
    $sql = "SELECT 1 FROM favoris WHERE id_utilisateur = ? AND id_recit = ?";
    $query = $db->prepare($sql);
    $query->execute([$id_user, $id_recit]);
    return (bool)$query->fetch();
}

/**
 * Ajoute un récit aux favoris d'un utilisateur.
 * @param PDO $db Connexion à la base de données.
 * @param int $id_user L'identifiant de l'utilisateur.
 * @param int $id_recit L'identifiant du récit.
 * @return bool Retourne true en cas de succès.
 */
function addFavorite(PDO $db, int $id_user, int $id_recit): bool
{
    $sql = "INSERT IGNORE INTO favoris (id_utilisateur, id_recit, date_ajout) 
            VALUES (?, ?, ?)";
    $query = $db->prepare($sql);

    $date = date('Y-m-d H:i:s');

    return $query->execute([$id_user, $id_recit, $date]);
}

/**
 * Retire un récit des favoris d'un utilisateur.
 * @param PDO $db Connexion à la base de données.
 * @param int $id_user L'identifiant de l'utilisateur.
 * @param int $id_recit L'identifiant du récit.
 * @return bool Retourne true en cas de succès.
 */
function removeFavorite(PDO $db, int $id_user, int $id_recit): bool
{
    $sql = "DELETE FROM favoris WHERE id_utilisateur = ? AND id_recit = ?";
    $query = $db->prepare($sql);

    return $query->execute([$id_user, $id_recit]);
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