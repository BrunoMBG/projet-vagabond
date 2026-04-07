<?php
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