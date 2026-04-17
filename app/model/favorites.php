<?php

/**
 * Modèle Favoris
 * 
 * favorites centralise toutes les requêtes SQL liées à la gestion des favoris.
 * Il permet de lier les utilisateurs aux récits qu'ils souhaitent suivre.
 * 
 * getArticlesFavorites,récupère les récits avec l'état du favori pour un utilisateur.
 * isFavorite, Vérifie si un récit spécifique est déjà liké par l'utilisateur.
 * addFavorite, ajoute un récit à la liste des favoris.
 * removeFavorite, supprime un récit de la liste des favoris.
 */

/**
 * Récupère la liste des articles avec les infos auteur et favori
 * @param PDO $db Connexion à la base de données.
 * @param int|null $id_user ID de l'utilisateur pour vérifier ses favoris
 * @return array
 */
function getArticlesFavorites(PDO $db, ?int $id_user = null): array
{
    try {
        // On s'assure que si id_user est null, la sous-requête ne plante pas
        $userId = $id_user ?? 0;

        $sql = "SELECT a.*, 
                    (SELECT COUNT(*) 
                    FROM favoris f 
                    WHERE f.id_recit = a.id_recit 
                    AND f.id_utilisateur = ?) AS is_favori
                FROM recits a
                ORDER BY a.date_creation DESC";

        $query = $db->prepare($sql);
        $query->execute([$userId]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur getArticlesFavorites : " . $e->getMessage());
        return [];
    }
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
    try {
        $sql = "SELECT 1 FROM favoris WHERE id_utilisateur = ? AND id_recit = ?";
        $query = $db->prepare($sql);
        $query->execute([$id_user, $id_recit]);
        return (bool)$query->fetch();
    } catch (PDOException $e) {
        error_log("Erreur isFavorite : " . $e->getMessage());
        return false;
    }
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
    try {
        $sql = "INSERT IGNORE INTO favoris (id_utilisateur, id_recit, date_ajout) 
                VALUES (?, ?, ?)";
        $query = $db->prepare($sql);

        $date = date('Y-m-d H:i:s');

        return $query->execute([$id_user, $id_recit, $date]);
    } catch (PDOException $e) {
        error_log("Erreur addFavorite : " . $e->getMessage());
        return false;
    }
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
    try {
        $sql = "DELETE FROM favoris WHERE id_utilisateur = ? AND id_recit = ?";
        $query = $db->prepare($sql);

        return $query->execute([$id_user, $id_recit]);
    } catch (PDOException $e) {
        error_log("Erreur removeFavorite : " . $e->getMessage());
        return false;
    }
}
