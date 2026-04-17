<?php

/**
 * Modèle Commentaires
 * 
 * comments centralise toutes les requêtes SQL liées à la gestion 
 * des commentaires sur les récits de voyage.
 * getCommentsByArticle : récupère la liste des commentaires d'un récit avec les infos auteurs.
 * addComment : permet l'enregistrement d'un nouveau commentaire en base de données.
 * deleteCommentsByArticle : Supprime tous les commentaires associés à un récit spécifique
 */

/**
 * Récupère tous les commentaires associés à un récit spécifique.
 * Effectue une jointure avec la table 'utilisateurs' pour 
 * récupérer automatiquement le nom et le prénom de l'auteur de chaque commentaire.
 * @param PDO $db Connexion à la base de données.
 * @param int $id_article L'identifiant unique du récit
 * @return array Un tableau associatif contenant tous les commentaires trouvés,
 * ou un tableau vide si aucun commentaire n'existe.
 */
function getCommentsByArticle(PDO $db, int $id_article)
{
    try {
        $sql = "SELECT c.*, u.nom, u.prenom 
                FROM commentaires c
                JOIN utilisateurs u ON c.id_utilisateur = u.id_utilisateur
                WHERE c.id_recit = ? 
                ORDER BY c.date_commentaire DESC";

        $stmt = $db->prepare($sql);
        $stmt->execute([$id_article]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur getCommentsByArticle : " . $e->getMessage());
        return [];
    }
}

/**
 * Enregistre un nouveau commentaire dans la base de données.
 * Génère la date actuelle via 
 * et l'insère avec l'ID du récit, l'ID de l'utilisateur et le texte du message.
 * @param PDO $db Connexion à la base de données.
 * @param int $id_recit L'identifiant de l'article.
 * @param int $id_utilisateur L'identifiant de l'auteur du commentaire.
 * @param string $commentaire Le contenu textuel du commentaire.
 * @return bool Retourne true si l'insertion a réussi, false en cas d'erreur.
 */
function addComment(PDO $db, int $id_recit, int $id_utilisateur, string $commentaire): bool
{
    try {
        $date = date('Y-m-d H:i:s');

        $sql = "INSERT INTO commentaires (id_recit, id_utilisateur, commentaire, date_commentaire) 
                VALUES (?, ?, ?, ?)";

        $query = $db->prepare($sql);
        return $query->execute([$id_recit, $id_utilisateur, $commentaire, $date]);
    } catch (PDOException $e) {
        error_log("Erreur addComment : " . $e->getMessage());
        return false;
    }
}


/**
 * Supprime tous les commentaires associés à un récit spécifique.
 * Cette méthode est appelée avant la suppression d'un article
 * @param PDO $db Connexion à la base de données.
 * @param int $id_recit L'identifiant du récit dont on veut supprimer les commentaires.
 * @return bool Retourne true si la requête a été exécutée avec succès, false sinon.
 */
function deleteCommentsByArticle(PDO $db, int $id_recit): bool
{
    try {
        $sql = "DELETE FROM commentaires WHERE id_recit = ?";
        $query = $db->prepare($sql);
        return $query->execute([$id_recit]);
    } catch (PDOException $e) {
        error_log("Erreur deleteCommentsByArticle : " . $e->getMessage());
        return false;
    }
}
