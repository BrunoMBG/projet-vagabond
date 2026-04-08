<?php

/**
 * Configuration de la Base de Données
 *
 * db_connection gère la communication initiale avec le serveur SQL
 * connectDB : Initialise la connexion PDO avec les variables d'environnement.
 * Initialise la variable globale $db utilisée dans toute l'application.
 */

/**
 * Établit une connexion à la base de données via PDO.
 *
 * Utilise les variables d'environnement pour récupérer les informations de connexion.
 * Configure PDO pour lever des exceptions en cas d'erreur.
 *
 * @return PDO Retourne la connexion PDO si la connexion réussit.
 * @throws Exception Arrête le script et affiche un message d'erreur si la connexion échoue. 
 */

function connectDB(): PDO
{
    try {
        $dbConnector = new PDO(
            "mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8",
            $_ENV['DB_LOGIN'],
            $_ENV['DB_PASSWORD']
        );
        $dbConnector->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $dbConnector;
    } catch (Exception $e) {
        die("Erreur de connexion à la base : " . $e->getMessage());
    }
}
$db = connectDB();
