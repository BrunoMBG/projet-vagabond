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
                WHERE f.id_article = a.id_article 
                AND f.id_utilisateur = ?) AS is_favori
                FROM articles a
                ORDER BY a.date_creation DESC";

        $query = $db->prepare($sql);
        $query->execute([$id_user]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
