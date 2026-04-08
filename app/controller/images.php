<?php

    /**
     * Contrôleur d'images
     * 
     * images permet d'afficher les images stockées hors de la racine publique.
     * displayImage : Récupère le paramètre dans l'URL.
     * getImage : Sécurise le chemin, identifie le type MIME et sert le fichier.
     */

    /**
     * Cette fonction récupère une image sur le serveur, identifie dynamiquement 
     * son type MIME (jpg, png, etc.) pour envoyer les bons en-têtes HTTP, et affiche 
     * le flux binaire du fichier. Gère les erreurs 404 si le fichier est introuvable.
     * * @param string $imageName Le nom du fichier image
     * @return void
     */
    function getImage($imageName) : void {
        // Extrait le nom de l'image
        $safeName = basename($imageName);
        // Transfert l'image vers /app/data/images/
        $directory = RACINE . '/app/data/images/';
        $filePath = $directory . $safeName;

        // Vérifie si le nom n'est pas vide et si le fichier existe 
        if (!empty($safeName) && file_exists($filePath)) {
            // Si un tampon de sortie existe, le vider et le supprimer
            if (ob_get_level()) ob_end_clean();
            // Controler le fichier pour récupérer son format
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $filePath);
            finfo_close($finfo);

            // Envoie les en-têtes HTTP pour le type et la taille du fichier
            header("Content-Type: $mimeType");
            header("Content-Length: " . filesize($filePath));
            
            // Affiche le contenu dans le navigateur
            readfile($filePath);
            exit; 
        } else {
            header("HTTP/1.0 404 Not Found");
            exit;
        }
    }

    /**
     * Cette fonction fait le lien entre la requête HTTP  
     * et la fonction de traitement getImage(). Elle valide la présence du nom 
     * de l'image et renvoie une erreur 400 en cas de paramètre manquant.
     * * @return void
     */
    function displayImage() {
        // Récupére le nom de l'image via url, sinon le met vide 
        $name = $_GET['name'] ?? '';
        // Si le nom de l'image est trouvé
        if (!empty($name)) {
            getImage($name);
        } else {
            header("HTTP/1.0 400 Bad Request");
        }
    }