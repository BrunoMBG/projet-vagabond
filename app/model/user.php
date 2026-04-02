<?php

/**
 * Enregistre un nouveau utilisateur avec les informations du formulaire.
 * @param PDO connexion à la base de données.
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


        return $query->execute([$lastName, $firstName, $email, $hash, 3]);
    } catch (PDOException $e) {

        error_log("Erreur Register : " . $e->getMessage());
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

/**
 * Cherche un utilisateur par son email dans la base de données.
 * @param PDO $db Connexion à la base de données.
 * @param string $email L'email à chercher.
 * @return array|false Les données de l'utilisateur ou false si non trouvé.
 */
function getUserByEmail(PDO $db, string $email): array|false
{
    try {
        $sql = "SELECT * FROM utilisateurs WHERE email = ?";
        $query = $db->prepare($sql);
        $query->execute([$email]);

        return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur getUserByEmail : " . $e->getMessage());
        return false;
    }
}

/**
 * Met à jour les informations de profil de l'utilisateur.
 * si le champ est vide, le mot de passe actuel est conservé.
 * @param PDO $db Connexion à la base de données
 * @param int $id Identifiant de l'utilisateur
 * @param string $nom Nouveau nom
 * @param string $prenom Nouveau prénom
 * @param string $email Nouvel email
 * @param string|null $password Nouveau mot de passe
 * @return bool True si la mise à jour a réussi, false sinon
 */
function updateProfil($db, $id, $nom, $prenom, $email, $password = null): bool
{
    if (!empty($password)) {
        $sql = "UPDATE utilisateurs SET nom = ?, prenom = ?, email = ?, password = ? WHERE id_utilisateur = ?";
        $update = [$nom, $prenom, $email, password_hash($password, PASSWORD_DEFAULT), $id];
    } else {
        $sql = "UPDATE utilisateurs SET nom = ?, prenom = ?, email = ? WHERE id_utilisateur = ?";
        $update = [$nom, $prenom, $email, $id];
    }
    $query = $db->prepare($sql);
    return $query->execute($update);
}

/**
 * Récupère tous les utilisateurs et leurs rôles
 * * Cette fonction lie la table 'utilisateurs' et 'role' pour obtenir 
 * le libellé du rôle en plus des données de l'utilisateur.
 * * @param PDO $db Connexion à la base de données.
 * @return array Liste associative contenant les colonnes de l'utilisateur et 'libelle'.
 */
function getAllUsers(PDO $db): array
{
    $sql = "SELECT u.id_utilisateur, u.nom, u.prenom, u.email, u.id_role, r.libelle 
            FROM utilisateurs u
            INNER JOIN role r ON u.id_role = r.id_role 
            ORDER BY u.nom ASC";
    $query = $db->prepare($sql);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère tous les rôles disponibles en base de données
 * @param PDO $db Connexion à la base de données
 * @return array
 */
function getAllRoles(PDO $db): array
{
    $sql = "SELECT id_role, libelle FROM role ORDER BY id_role ASC";
    $query = $db->query($sql);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Met à jour le rôle d'un utilisateur 
 * @param PDO $db Connexion à la base de données
 * @param int $id_user id d'utilisateur
 * @param int =id_role id du rôle d'utilisateur
 */
function updateUserRole(PDO $db, int $id_user, int $id_role): bool
{
    $sql = "UPDATE utilisateurs SET id_role = ? WHERE id_utilisateur = ?";
    $query = $db->prepare($sql);
    return $query->execute([ $id_role, $id_user]);
}
