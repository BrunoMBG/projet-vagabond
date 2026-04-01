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
 * Cherche un email dans la base de données.
 * @param PDO $db Connexion à la base de données.
 * @param string $email L'email à chercher.
 * @return array bool Les données de l'utilisateur ou false si non trouvé.
 */
function getUserByEmail(PDO $db, string $email)
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


function updateProfil($db, $id, $nom, $prenom, $email, $password = null)
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
