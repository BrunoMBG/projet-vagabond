  <?php
  /**
   * Index.php - Point d'entrée 
   */

  session_start();
  // ==================== Config global ==================== 
  require __DIR__ . '/app/config/config.php';

  // ==================== Connexion à la base de données ==================== 
  require RACINE . '/app/model/db_connection.php';

  // ==================== Routage ==================== 
  require RACINE . '/app/controller/router.php';



  // On récupère l'action de l'URL, sinon on utilise "default".
  $action = $_GET["action"] ?? "default";
  
  // Vérifie si c'est une image si c'est le cas le script arrête.
  if ($action === 'viewImage') {
      handleRequest($action); 
      exit; 
  }
  
  // Exécute le contrôleur avant d'afficher le HTML.
  ob_start();
  handleRequest($action);
  $content = ob_get_clean();

  // ==================== Head ====================
  require RACINE . '/app/view/partials/head.php';
  ?>


  <body>
    <?php // ==================== Header ==================== 
    ?>
    <?php require RACINE . '/app/view/partials/header.php'; ?>

    <main role="main">
      <?php
        // Affhiche le contenu généré par le contrôleur.
        echo $content;
      ?>
    </main>

  </body>

  <?php
  // Footer
  require RACINE . "/app/view/partials/footer.php";
  ?>

  </html>