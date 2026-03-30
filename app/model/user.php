<?php

/**
 * Enregistre un nouveau utilisateur avec les informations du formulaire.
 * * @param PDO connexion à la base de données.
 * @param string $lastName nom de famille de l'utilisateur.
 * @param string $firstName prénom de l'utilisateur.
 * @param string $email adresse email.
 * @param string $password mot de passe.
 * @return bool Retourne true si l'utilisateur est créé, sinon false.
 */
function registerUser(PDO $db, string $lastName, string $firstName, string $email, string $password): bool
{
    try {

        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO utilisateurs (nom , prenom, email, password, id_role) VALUES (?, ?, ?, ?, ?)";

        $query = $db->prepare($sql);


        return $query->execute([$lastName, $firstName, $email, $hash, 2]);
    } catch (PDOException $e) {
        // Log de l'erreur (ex: email déjà existant) pour le debug
        error_log("Erreur SQL Register : " . $e->getMessage());
        return false;
    }
}

/**
 * Vérifie si un email existe déjà dans la base de données.
 * @param PDO $db connexion à la base de données.
 * @param string $email adresse email.
 */
function isEmailExists(PDO $db, string $email): bool
{
    $sql = "SELECT COUNT(*) FROM utilisateurs WHERE email = ?";
    $query = $db->prepare($sql);
    $query->execute([$email]);
    return $query->fetchColumn() > 0;
}
