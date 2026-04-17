<?php

/**
 * Modèle Article & Interactions
 * 
 * article centralise toutes les requêtes SQL liées aux récits de voyage.
 * addArticle : Enregistre un nouveau récit de voyage en base de données.
 * deleteArticle : Supprime un récit de la base de données.
 * getAllArticles : Récupère l'intégralité des récits avec leurs destinations.
 * getArticleById : Récupère les détails d'un récit spécifique via son ID.
 * getLatestArticles : Récupère les derniers récits (pour la page d'accueil).
 * updateArticle : Met à jour les informations d'un récit existant dans la base de données.
 * getFavoriteArticles : Récupère la liste des récits marqués comme favoris par un utilisateur.
 */


/**
 * Ajout un nouveau article dans la base de données.
 * @param PDO $db Connexion à la base de données.
 * @param string $titre Le titre du récit.
 * @param string $ville Nom de la ville
 * @param string $contenu Le texte du récit.
 * @param string|null $image Le nom du fichier image.
 * @param int $id_user L'identifiant de l'auteur (clé étrangère utilisateurs).
 * @param int $id_destination L'identifiant de la destination (clé étrangère destination).
 * @return bool Retourne true si l'insertion a réussi, false sinon.
 */
function addArticle(PDO $db, string $titre, string $ville, string $contenu, ?string $image, int $id_user, int $id_destination): bool
{
    try {
        $sql = "INSERT INTO recits (titre, ville, contenu, image, id_destination, id_utilisateur) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $query = $db->prepare($sql);
        return $query->execute([$titre, $ville, $contenu, $image, $id_destination, $id_user]);
    } catch (PDOException $e) {
        error_log("Erreur addArticle : " . $e->getMessage());
        return false;
    }
}

/**
 * Supprime un récit de la base de données.
 * @param PDO $db Connexion à la base de données.
 * @param int $id L'identifiant du récit à supprimer.
 * @return bool Retourne true en cas de succès.
 */
function deleteArticle(PDO $db, int $id): bool
{
    try {
        $sql = "DELETE FROM recits WHERE id_recit = ?";
        $query = $db->prepare($sql);
        return $query->execute([$id]);
    } catch (PDOException $e) {
        error_log("Erreur deleteArticle : " . $e->getMessage());
        return false;
    }
}

/**
 * Récupère la liste des articles avec leurs destinations associées.
 * Permet un filtrage par destination si un identifiant est fourni.
 * * @param PDO $db Connexion à la base de données.
 * @param int|null $id_dest L'identifiant de la destination pour filtrer les résultats.
 * @return array Liste associative des articles triés du plus récent au plus ancien.
 */
function getAllArticles(PDO $db, ?int $id_dest = null): array
{
    try {
        $sql = "SELECT r.*, d.nom_destination 
                FROM recits r
                JOIN destinations d ON r.id_destination = d.id_destination";

        if ($id_dest !== null) {
            $sql .= " WHERE r.id_destination = ?";
        }

        $sql .= " ORDER BY r.date_creation DESC";
        $query = $db->prepare($sql);

        $id_dest !== null ? $query->execute([$id_dest]) : $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur getAllArticles : " . $e->getMessage());
        return [];
    }
}


/**
 * Récupère un seul article par son ID.
 * @param PDO $db Connexion à la base de données.
 * @param int $id id de l'article
 * @return array Retourne les données de l'article ou false si non trouvé.
 */
function getArticleById(PDO $db, int $id)
{
    try {
        $sql = "SELECT r.*, d.nom_destination 
                FROM recits r
                JOIN destinations d ON r.id_destination = d.id_destination
                WHERE r.id_recit = ?";

        $query = $db->prepare($sql);
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur getArticleById : " . $e->getMessage());
        return false;
    }
}


/**
 * Récupère les derniers récits publiés avec une limite définie.
 * * @param PDO $db Connexion à la base de données.
 * @param int $limit Nombre d'articles à récupérer (par défaut 3).
 * @return array Liste des articles les plus récents.
 */
function getLatestArticles($db, $limit = 3)
{
    try {
        // Utilisation de bindValue pour sécuriser le LIMIT
        $sql = "SELECT r.*, d.nom_destination 
                FROM recits r
                JOIN destinations d ON r.id_destination = d.id_destination
                ORDER BY r.date_creation DESC
                LIMIT :limit";

        $query = $db->prepare($sql);
        $query->bindValue(':limit', $limit, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur getLatestArticles : " . $e->getMessage());
        return [];
    }
}


/**
 * Met à jour les informations d'un récit existant dans la base de données.
 * @param PDO $db Connexion à la base de données.
 * @param int $id L'identifiant unique du récit à modifier.
 * @param string $titre Le titre du récit.
 * @param string $ville Nom de la ville
 * @param string $contenu Le corps du texte.
 * @param string|null $image Le nom du fichier image.
 * @param int $id_destination L'identifiant de la destination associée.
 * @return bool Retourne true si la mise à jour a réussi, false en cas d'échec.
 */
function updateArticle(PDO $db, int $id, string $titre, string $ville, string $contenu, ?string $image, int $id_destination): bool
{
    try {
        $sql = "UPDATE recits 
                SET titre = ?, ville = ?, contenu = ?, image = ?, id_destination = ? 
                WHERE id_recit = ?";

        $query = $db->prepare($sql);
        return $query->execute([$titre, $ville, $contenu, $image, $id_destination, $id]);
    } catch (PDOException $e) {
        error_log("Erreur updateArticle : " . $e->getMessage());
        return false;
    }
}

/**
 * Récupère la liste des récits marqués comme favoris par un utilisateur.
 * Cette fonction effectue une jointure entre la table 'recit' et 'favoris'
 * pour extraire uniquement les articles liés à l'identifiant de l'utilisateur.
 *
 * @param PDO $db       Connexion à la base de données.
 * @param int $userId   Identifiant de l'utilisateur dont on veut les favoris.
 * @return array        Tableau associatif contenant les données des récits favoris.
 */
function getFavoriteArticles(PDO $db, int $userId)
{
    try {
        $sql = "SELECT r.* FROM recits r
                INNER JOIN favoris f ON r.id_recit = f.id_recit
                WHERE f.id_utilisateur = ?
                ORDER BY r.date_creation DESC";

        $query = $db->prepare($sql);
        $query->execute([$userId]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur getFavoriteArticles : " . $e->getMessage());
        return [];
    }
}
