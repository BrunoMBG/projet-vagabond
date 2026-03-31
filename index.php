    <?php // ==================== Config global ==================== ?>  
    <?php session_start(); ?>
    <?php require __DIR__ . '/app/config/config.php'; ?>

    <?php // ==================== Head ==================== ?>  
    <?php require RACINE . '/app/view/partials/head.php'; ?>

    <?php // ==================== Connexion à la base de données ==================== ?>
    <?php require RACINE . '/app/model/db_connection.php'; ?>

    <body>
      <?php // ==================== Routage ==================== ?>
      <?php require RACINE . '/app/controller/router.php'; ?>

      <?php
      // On récupère l'action de l'URL, sinon on utilise "default"
      $action = $_GET["action"] ?? "default";
      // Appel de la fonction de routage
      handleRequest($action);
      ?>
    </body>

    </html>