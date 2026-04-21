  <?php
  /**
   * Index.php - Point d'entrée 
   */

if (session_status() === PHP_SESSION_NONE) {
    session_name('VAGABOND_SESSION'); 

    session_start();
}

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


  require RACINE . '/app/view/layout.php';
