<?php

/**
 * Modèle Destinations
 * 
 * destinations gère les requêtes liées aux destinations de voyage.
 * destinations permet notamment d'alimenter les formulaires de création et de 
 * modification d'articles en listant les lieux disponibles.
 * 
 * getAllDestinations, récupère toutes les destinations classées par ordre alphabétique.
 * getVisitedDestinations, Récupère la liste des destinations ayant au moins un récit associé.
 */

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
 * Récupère la liste des destinations ayant au moins un récit associé.
 * et ne retourner que les lieux réellement visités.
 * @param PDO $db Connexion à la base de données.
 * @return array Liste associative des destinations triées par ordre alphabétique.
 */
function getVisitedDestinations(PDO $db): array
{
    $sql = "SELECT DISTINCT d.id_destination, d.nom_destination 
            FROM destinations d
            INNER JOIN recits r ON d.id_destination = r.id_destination
            ORDER BY d.nom_destination ASC";

    $query = $db->query($sql);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}