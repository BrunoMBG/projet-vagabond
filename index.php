    <!--  ==================== Config global ==================== -->
    <?php require __DIR__ . '/app/config/config.php'; ?>

    <!--  ==================== Head ==================== -->
    <?php require RACINE . '/app/view/partials/head.php'; ?>

    <body>
        <!--  ==================== Routage ==================== -->
        <?php require RACINE . '/app/controller/router.php'; ?>

        <?php
            // On récupère l'action de l'URL, sinon on utilise "default"
            $action = $_GET["action"] ?? "default";
            // Appel de la fonction de routage
            handleRequest($action);
        ?>
    </body>

    </html>