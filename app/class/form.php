<?php

/**
 * Class Form
 * 
 * Permet de générer le code HTML d'un formulaire
 */
class Form
{
    /**
     * @var string Contient l'ensemble du code HTML
     */
    private string $html;

    /**
     * Ouvre les balises structurelles du formulaire
     * @param string $action L'URL de destination du formulaire
     * @param string $method La méthode POST
     * @param bool $isMultipart Définit si le formulaire accepte l'envoi de fichiers.
     */
    public function __construct(string $action, string $method = "post", bool $isMultipart = false)
    {
        $enctype = $isMultipart ? ' enctype="multipart/form-data"' : '';
        $this->html = "<form action=\"$action\" method=\"$method\"$enctype>\n";
    }

    /**
     * Crée une balise label et un input du type text à l'intérieur d'un paragraphe
     *
     * @param string $name Le nom de l'attribut
     * @param string $label La description affichée pour l'utilisateur
     * @param string $type Le type d'input (text, password, email, etc.).
     * @param string $value La valeur initiale du champ.
     * @return void
     */
    public function setInput(string $name, string $label, string $type, string $value = ""): void
    {
        $this->html .= "<p>";
        $this->html .= "<label for =\"$name\">$label</label>\n";
        $this->html .= "<input type = \"$type\" name =\"$name\" id=\"$name\" value=\"$value\" >";
        $this->html .= "</p>";
    }

    /**
     * Crée un textarea pour les contenus longs (récits, commentaires)
     * @param string $name Le nom de l'attribut
     * @param string $label La description affichée pour l'utilisateur
     * @param int $rows Le nombrede lignes
     * @param $value Le contenu texte à afficher
     * @return void
     */
    public function setTextarea(string $name, string $label, int $rows, string $value = ""): void
    {
        $this->html .= "<p>";
        $this->html .= "<label for=\"$name\">$label</label>\n";
        $this->html .= "<textarea name=\"$name\" id=\"$name\" rows=\"$rows\">" . htmlspecialchars($value) . "</textarea>";
        $this->html .= "</p>";
    }

    /**
     * Génère un champ d'upload de fichier.
     * @param string $name Le nom de l'attribut.
     * @param string $label Le texte affiché.
     * @param string $accept Les types de fichiers autorisés.
     * @return void
     */
    public function setFile(string $name, string $label, string $accept = "image/*"): void
    {
        $this->html .= "<p>";
        $this->html .= "<label for=\"$name\">$label</label>\n";
        $this->html .= "<input type=\"file\" name=\"$name\" id=\"$name\" accept=\"$accept\">";
        $this->html .= "</p>";
    }

    /**
     * Ajoute un message d'erreur au formulaire
     * @param string $message Le texte de l'erreur à afficher
     * @return void
     */
    public function setError(string $message = "", string $class = "error-message"): void
    {
        if (!empty($message)) {
            $this->html .= "<p class=\"$class\">" . htmlspecialchars($message) . "</p>\n";
        }
    }

    /**
     * Ajoute un message de success au formulaire
     * @param string $messageSuccess Le texte de succès à afficher.
     * @param string $class classe CSS.
     * @return void
     */
    public function setSuccess(string $messageSuccess, string $class = ""): void
    {
        if (!empty($messageSuccess)) {
            $this->html .= "<p class ='$class'>$messageSuccess</p>";
        }
    }


    /**
     * Ajoute un paragraphe de texte au formulaire.
     * @param string $text Le contenu du texte.
     * @param string $class classe CSS.
     * @return void
     */
    public function setText(string $text, string $class = ""): void
    {
        $this->html .= "<p class='$class'>$text</p>";
    }
    /**
     * Ajoute un lien au formulaire.
     * @param string $href L'URL.
     * @param string $text Le texte du lien.
     * @param string $class classe CSS.
     */
    public function setLink(string $href, string $text, string $class = ""): void
    {
        $this->html .= "<a href='$href' class='$class'>$text</a>";
    }

    /**
     * Crée un paragraphe avec un input du type submit intérieur
     * @param string $value la value du input
     * @param string $class classe CSS.
     * @return void
     */
    public function setSubmit(string $value, string $class = ""): void
    {
        $this->html .= "<p>\n";
        $this->html .= "<input type=\"submit\" class='$class' value=\"$value\">\n";
        $this->html .= "</p>\n";
    }
    /**
     * Génère et ajoute au formulaire une liste déroulante basée sur des données de la BDD.
     * @param string $name Le nom du champ
     * @param string $label Le texte affiché dans l'étiquette
     * @param array  $options Le tableau contenant les données 
     * @param string $value La clé du tableau correspondant à l'ID
     * @param string $valueLabel La clé du tableau correspondant au texte à afficher
     * @param string|null $selectedValue La valeur à sélectionner par défaut
     * @return void
     */
    public function setSelect(string $name, string $label, array $options, string $value, string $valueLabel, string $selectedValue = null): void
    {
        $this->html .= "<label for='$name'>$label</label>";
        $this->html .= "<select name='$name' id='$name' required>";
        $this->html .= "<option value=''>-- Choisissez une destination --</option>";

        foreach ($options as $option) {

            $id = $option[$value];
            $val = $option[$valueLabel];

            $selected = ($id == $selectedValue) ? "selected" : "";

            $this->html .= "<option value='$id' $selected>" . htmlspecialchars($val) . "</option>";
        }

        $this->html .= "</select>";
    }
    /**
     * Ferme les balises structurelles du formulaire
     * @return string formulaire crée
     */
    public function getForm(): string
    {
        $form = $this->html;
        $form .= "</form>";

        return $form;
    }
}
