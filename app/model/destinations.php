<?php

/**
 * Modèle Destinations
 * 
 * destinations gère les requêtes liées aux destinations de voyage.
 * destinations permet notamment d'alimenter les formulaires de création et de 
 * modification d'articles en listant les lieux disponibles.
 * 
 * getAllDestinations, récupère toutes les destinations classées par ordre alphabétique.
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