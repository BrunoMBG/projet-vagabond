<?php
    /**
     * CONFIG GLOBAL 
     */

    require __DIR__ . '/../../vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
    $dotenv->load();


    define("RACINE", dirname(__DIR__, 2));
