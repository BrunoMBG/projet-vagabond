<?php

    /**
     * Contrôleur de la liste des utilisateurs.
     * * user_list récupère l'ensemble des utilisateurs depuis le modèle 
     * et les transmet à la vue correspondante pour gérer l'affichage.
     * * @return void
     */

    require RACINE . "/app/model/user.php";

    require RACINE . "/app/view/user_list.php";
