<?php

/**
 * Modèle Utilisateur & Sécurité
 * 
 * user centralise toutes les requêtes SQL liées aux comptes utilisateurs :
 * registerUser       : Enregistre un nouvel utilisateur (Rôle 'Membre' par défaut).
 * isEmailExists      : Vérifie si l'email existe déjà en base.
 * getUserByEmail     : Récupère les données complètes d'un utilisateur pour le login.
 * updateProfil       : Modifie les informations personnelles et/ou le mot de passe.
 * getAllUsers        : Liste l'ensemble des utilisateurs avec leurs libellés de rôle.
 * getAllRoles        : Récupère les différents niveaux d'accréditation disponibles.
 * updateUserRole     : Modifie les privilèges d'un utilisateur (Admin uniquement).
 * storeResetToken    : Enregistre un jeton de récupération avec expiration (1h).
 * checkResetToken    : Vérifie si un jeton est valide et non expiré.
 * updateUserPassword : Met à jour le mot de passe et invalide le jeton utilisé.
 */

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
    try {
        $sql = "SELECT COUNT(*) FROM utilisateurs WHERE email = ?";
        $query = $db->prepare($sql);

        $query->execute([$email]);
        
        return $query->fetchColumn() > 0;
    } catch (PDOException $e) {
        error_log("Erreur isEmailExists : " . $e->getMessage());
        return true;
    }
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
    try {
        if (!empty($password)) {
            $sql = "UPDATE utilisateurs SET nom = ?, prenom = ?, email = ?, password = ? WHERE id_utilisateur = ?";
            $params = [$nom, $prenom, $email, password_hash($password, PASSWORD_DEFAULT), $id];
        } else {
            $sql = "UPDATE utilisateurs SET nom = ?, prenom = ?, email = ? WHERE id_utilisateur = ?";
            $params = [$nom, $prenom, $email, $id];
        }
        $query = $db->prepare($sql);
        return $query->execute($params);
    } catch (PDOException $e) {
        error_log("Erreur updateProfil : " . $e->getMessage());
        return false;
    }
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
    try {
        $sql = "SELECT u.id_utilisateur, u.nom, u.prenom, u.email, u.id_role, r.libelle 
                FROM utilisateurs u
                INNER JOIN role r ON u.id_role = r.id_role 
                ORDER BY u.nom ASC";
        $query = $db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur getAllUsers : " . $e->getMessage());
        return [];
    }
}

/**
 * Récupère tous les rôles disponibles en base de données
 * @param PDO $db Connexion à la base de données
 * @return array
 */
function getAllRoles(PDO $db): array
{
    try {
        $sql = "SELECT id_role, libelle FROM role ORDER BY id_role ASC";
        $query = $db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur getAllRoles : " . $e->getMessage());
        return [];
    }
}

/**
 * Met à jour le rôle d'un utilisateur 
 * @param PDO $db Connexion à la base de données
 * @param int $id_user id d'utilisateur
 * @param int =id_role id du rôle d'utilisateur
 */
function updateUserRole(PDO $db, int $id_user, int $id_role): bool
{
    try {
        $sql = "UPDATE utilisateurs SET id_role = ? WHERE id_utilisateur = ?";
        $query = $db->prepare($sql);
        return $query->execute([$id_role, $id_user]);
    } catch (PDOException $e) {
        error_log("Erreur updateUserRole : " . $e->getMessage());
        return false;
    }
}


/**
 * Enregistre le token de réinitialisation et sa date d'expiration pour un utilisateur.
 * @param PDO $db Connexion à la base de données
 * @param string $email L'email de l'utilisateur.
 * @param string $token Le token généré.
 * @return bool True si la mise à jour a réussi, sinon false.
 */
function storeResetToken(PDO $db, string $email, string $token): bool
{

    try {
        $sql = "UPDATE utilisateurs 
                SET token = ?, 
                    token_expiration = DATE_ADD(NOW(), INTERVAL 1 HOUR) 
                WHERE email = ?";
        $query = $db->prepare($sql);
        return $query->execute([$token, $email]);
    } catch (PDOException $e) {
        error_log("Erreur storeResetToken : " . $e->getMessage());
        return false;
    }
}


/**
 * Cette fonction interroge la base de données pour trouver un utilisateur possédant
 * le token fourni, à condition que celui-ci n'ait pas dépassé sa date d'expiration.
 * @param PDO $db Connexion à la base de données
 * @param string $token Le token de sécurité unique envoyé par email.
 * @return array|false Retourne les données de l'utilisateur si le token est valide, 
 * ou false si le token est inexistant ou expiré.
 */
function checkResetToken(PDO $db, string $token)
{

    try {
        $sql = "SELECT id_utilisateur FROM utilisateurs 
                WHERE token = ? AND token_expiration > NOW()";
        $query = $db->prepare($sql);
        $query->execute([$token]);
        return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur checkResetToken : " . $e->getMessage());
        return false;
    }
}

/**
 * Cette fonction enregistre le nouveau hash du mot de passe en base de données.
 * Elle force également la suppression du token et de sa date d'expiration afin
 * de rendre le lien de récupération à usage unique.
 * @param PDO $db Connexion à la base de données
 * @param int $id L'identifiant unique de l'utilisateur.
 * @param string $hash Le nouveau mot de passe haché.
 * @return bool Retourne true si la mise à jour a réussi, false en cas d'erreur.
 */
function updateUserPassword(PDO $db, int $id, string $hash)
{
    try {
        $sql = "UPDATE utilisateurs 
                SET password = ?, token = NULL, token_expiration = NULL 
                WHERE id_utilisateur = ?";
        $query = $db->prepare($sql);
        return $query->execute([$hash, $id]);
    } catch (PDOException $e) {
        error_log("Erreur updateUserPassword : " . $e->getMessage());
        return false;
    }
}
