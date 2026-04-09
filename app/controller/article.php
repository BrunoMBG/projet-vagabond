<?php

    /**
     * Contrôleur des articles
     * 
     * article centralise toutes les actions liées aux récits de voyage
     * articleAdd : Création d'un article avec upload d'image.
     * articleList : Affichage de la liste globale des récits.
     * articleView : Consultation détaillée d'un récit et de ses commentaires.
     * postComment : Gestion de l'ajout de commentaires par les utilisateurs.
     * favorites : Système de "Like/Unlike" pour mettre en favoris.
     */

    /**
     * Gère l'ajout d'un nouvel article .
     * Vérifie l'authentification de l'utilisateur, récupère les 
     * destinations, valide les données saisies (titre, contenu, destination), 
     * Gère l'upload sécurisé d'une image, enregistre l'article en base de données 
     * et affiche le formulaire de création.
     * * @global PDO $db Connexion à la base de données.
     * @return void
     */
    function articleAdd() : void
    {
        global $db;

        require_once RACINE . '/app/model/article.php';
        require_once RACINE . '/app/class/form.php';

        // Récupération des destinations pour le menu déroulant
        $destinations = getAllDestinations($db);

        // Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // tableau d'erreurs en session
            $_SESSION['errors'] = [];

            $titre = trim(htmlspecialchars($_POST['titre']));
            $contenu = trim(htmlspecialchars($_POST['texte']));
            $id_user = (int)$_SESSION['user_id'];
            $id_destination = isset($_POST['id_destination']) ? $_POST['id_destination'] : 0;

            $image_name = null;

            // Vérifier si les champs obligatoires sont remplis
            if (empty($titre) || empty($contenu)) {
                $_SESSION['errors'][] = "Le titre et le contenu sont obligatoires.";
            }

            // Vérifie si une destination a été choisie
            if ($id_destination === 0) {
                $_SESSION['errors'][] = "Veuillez choisir une destination.";
            }

            // Traitement de l'image si un fichier a été ajouté
            if (isset($_FILES['image_article']) && $_FILES['image_article']['error'] !== UPLOAD_ERR_NO_FILE) {

                // Vérifie si l'image a bien été transférée
                if ($_FILES['image_article']['error'] === 0) {
                    $uploadDir = RACINE . '/app/data/images/';

                    // Création du dossier de stockage s'il n'existe pas
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    // Vérifie  l'extension du fichier
                    $extension = strtolower(pathinfo($_FILES['image_article']['name'], PATHINFO_EXTENSION));
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

                    if (in_array($extension, $allowedExtensions)) {
                        // Génération d'un nom unique
                        $image_name = uniqid('art_') . '.' . $extension;
                        $destinationPath = $uploadDir . $image_name;

                        // Déplacement du fichier vers /app/data/images
                        if (!move_uploaded_file($_FILES['image_article']['tmp_name'], $destinationPath)) {
                            $_SESSION['errors'][] = "Erreur technique lors du transfert de l'image.";
                            $image_name = null;
                        }
                    } else {
                        $_SESSION['errors'][] = "Format d'image non supporté.";
                    }
                } else {
                    $_SESSION['errors'][] = "Problème avec le fichier image (Code : " . $_FILES['image_article']['error'] . ")";
                }
            }

            // Si aucune erreur n'a été détectée
            if (empty($_SESSION['errors'])) {
                if (addArticle($db, $titre, $contenu, $image_name, $id_user, $id_destination)) {

                    // Message de succès et redirection
                    $_SESSION['displayMessage'] = "Votre récit a été publié avec succès !";
                    header('Location: index.php?action=articleAdd');
                    exit;
                } else {
                    $_SESSION['errors'][] = "Erreur SQL : Impossible d'enregistrer le récit.";
                }
            }

            // Redirection en cas d'erreurs
            header('Location: index.php?action=articleAdd');
            exit;
        }
        // Création du formulaire avec enctype="multipart/form-data" (true) pour gérer les fichiers
        $form = new Form("index.php?action=articleAdd", "post", true);


        $form->setInput("titre", "Titre du récit", "text");
        $form->setSelect("id_destination", "Destination", $destinations, "id_destination", "nom_destination");
        $form->setFile("image_article", "Image d'illustration");
        $form->setTextarea("texte", "Votre récit", 10);

        // Affiche les erreurs s'il y en a eu
        if (!empty($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                $form->setError($error);
            }   

            // Nettoyage de la session après affichage
            unset($_SESSION['errors']);
        }

        $form->setSubmit("Publier le récit");

        // Affichage du formulaire
        $formArticle = $form->getForm();

        require_once RACINE . '/app/view/admin/article.php';
    }

    /**
     * Contrôleur : Gère l'affichage de la liste des récits de voyage
     * Cette fonction récupère les données via le modèle et les transmet à la vue.
     */
    function articleList() {
        global $db;
        require_once RACINE . '/app/model/article.php';
        
        $articles = getAllArticles($db);
        
        require_once RACINE . '/app/view/blog.php';
    }

  /**
     * Gère l'affichage détaillé d'un récit.
     * Extrait l'identifiant du récit depuis l'URL.
     * Interroge le modèle 'Article' pour les détails du contenu.
     * Interroge le modèle 'Comments' pour récupérer les interactions associées.
     * Charge la vue finale pour l'affichage utilisateur.
     *
     * @return void 
     */
    function articleView() : void
    {
        global $db;
        
    
        require_once RACINE . '/app/model/article.php';
        require_once RACINE . '/app/model/comments.php';
        require_once RACINE . '/app/model/favorites.php';

        // Récupération de l'ID depuis l'URL
        $id = isset($_GET['id']) ? $_GET['id'] : 0;

        // Appel au modèle pour récupérer l'article spécifique
        $article = getArticleById($db, $id);

    // Gestion d'erreur : si l'article n'existe pas
        if (!$article) {
            $_SESSION['displayMessage'] = ["type" => "danger", "message" => "Cet article est introuvable."];
            header('Location: index.php?action=blog');
            exit;
        }
        $comments = getCommentsByArticle($db, $id);

        require_once RACINE . '/app/view/article_single.php';
    }

 /**
     * Gère l'ajout d'un nouveau commentaire.
     * Vérifie l'authentification de l'utilisateur.
     * Valide et nettoie les données du formulaire (ID récit et contenu).
     * Sollicite le modèle 'Comments' pour l'insertion en base de données.
     * Redirige l'utilisateur vers l'article avec un message de confirmation.
     * @return void
     */
    function postComment() : void
    {
        global $db;
        require_once RACINE . '/app/model/article.php';
        require_once RACINE . '/app/model/comments.php';
        // Vérifie si l'utilisateur est bien connecté
        if (!isset($_SESSION['user']['id'])) {
            $_SESSION['displayMessage'] = ["type" => "danger", "message" => "Vous devez être connecté pour laisser un commentaire."];
            header('Location: index.php?action=login');
            exit;
        }

        // Vérifie si l'ID est présent dans l'URL, sinon assigne 0 par défaut
        $id_recit = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        // Récupère le commentaire depuis le formulaire, supprime les espaces en début et fin,
        // sinon assigne une chaîne vide par défaut
        $texte = isset($_POST['comment']) ? trim($_POST['comment']) : '';

        // Récupère l'ID de l'utilisateur stocké en session (Clé 'id' d'après ton login)
        $id_user = (int)$_SESSION['user']['id']; 

        // Si le texte n'est pas vide et que l'ID de l'article est valide
        if (!empty($texte) && $id_recit > 0) {
            // Appelle le modèle pour ajouter le commentaire 
            if (addComment($db, $id_recit, $id_user, $texte)) {
                $_SESSION['displayMessage'] = ["type" => "success", "message" => "Votre commentaire a été publié !"];
            } else {
                $_SESSION['displayMessage'] = ["type" => "danger", "message" => "Une erreur est survenue lors de l'envoi."];
            }
        }else {
            // Message d'erreur si l'utilisateur tente d'envoyer un message vide
            $_SESSION['displayMessage'] = [
                "type" => "warning", 
                "message" => "Votre commentaire ne peut pas être vide."
            ];
        }

    
        header("Location: index.php?action=articleView&id=" . $id_recit);
        exit;
    }

    /**
     * Gère l'action de "Like/Unlike" pour un récit.
     * Cette fonction vérifie d'abord l'authentification de l'utilisateur.
     * Elle bascule l'état du favori
     * Si le récit est déjà en favori : elle le supprime.
     * Si le récit n'est pas en favori : elle l'ajoute.
     * @return void
     */
    function favorites() {

        global $db;
   
        require_once RACINE . "/app/model/favorites.php";

        //  Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $id_user = $_SESSION['user']['id'];
        
        // Récupérer l'ID du récit depuis l'URL
        $id_recit = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id_recit) {

            if (isFavorite($db, $id_user, $id_recit)) {
                removeFavorite($db, $id_user, $id_recit);
            } else {
                addFavorite($db, $id_user, $id_recit);
            }
        }

        $redirect = $_SERVER['HTTP_REFERER'] ?? "index.php?action=article&id=" . $id_recit;
        header("Location: " . $redirect);
        exit;
    }