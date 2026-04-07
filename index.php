  <?php session_start(); ?>
  <?php // ==================== Config global ==================== ?>
  <?php require __DIR__ . '/app/config/config.php'; ?>

  <?php // ==================== Connexion à la base de données ==================== ?>
  <?php require RACINE . '/app/model/db_connection.php'; ?>

  <?php // ==================== Routage ==================== ?>
  <?php require RACINE . '/app/controller/router.php'; ?>


  <?php
    // On récupère l'action de l'URL, sinon on utilise "default"
    $action = $_GET["action"] ?? "default";

    if ($action === 'viewImage') {
      handleRequest($action);
      exit; 
    }
  ?>

  <?php // ==================== Head ==================== ?>
  <?php require RACINE . '/app/view/partials/head.php'; ?>

  <body>
    <?php // ==================== Header ==================== ?>
    <?php require RACINE . '/app/view/partials/header.php'; ?>

    <main>
      <?php
        // Appel de la fonction de routage
        handleRequest($action);
      ?>
    </main>

  </body>

  </html>