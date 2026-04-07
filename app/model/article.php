<?php

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