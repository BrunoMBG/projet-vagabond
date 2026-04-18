<?php

/**
 * Layout.php - Squelette global de l'application
 */

require RACINE . '/app/view/partials/head.php';
?>

<body>

    <?php
    // ==================== Header ==================== 
    require RACINE . '/app/view/partials/header.php';
    ?>

    <main role="main">
        <?php
        // Affhiche le contenu généré par le contrôleur.
        echo $content;
        ?>
    </main>

    <?php
    // Footer
    require RACINE . "/app/view/partials/footer.php";
    ?>

</body>

</html>